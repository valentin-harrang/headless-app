<?php

namespace App\Service;

use App\Entity\Feed;
use App\Entity\News;
use App\Model\NewsLequipe;
use Constants;
use DateTime;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use SimpleXMLElement;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use const JSON_THROW_ON_ERROR;
use const LIBXML_COMPACT;
use const LIBXML_NOCDATA;
use const LIBXML_PARSEHUGE;
use function json_decode;
use function json_encode;
use function simplexml_load_string;

class NewsLequipeService
{
    protected EntityManagerInterface $entityManager;

    protected HttpClientInterface $client;

    protected SerializerInterface $serializer;

    protected SluggerInterface $slugger;

    public function __construct(
        EntityManagerInterface $entityManager,
        HttpClientInterface $client,
        SerializerInterface $serializer,
        SluggerInterface $slugger,
    ) {
        $this->entityManager = $entityManager;
        $this->client        = $client;
        $this->serializer    = $serializer;
        $this->slugger       = $slugger;
    }

    public function getXmlContentFromRemoteUrl(string $remoteUrl): string
    {
        return $this->client->request(Request::METHOD_GET, $remoteUrl)->getContent();
    }

    private function getNewsFromLequipeRssFeed(): array
    {
        $xmlContent = $this->getXmlContentFromRemoteUrl(Constants::LEQUIPE_SOCCER_RSS_FEED_URL);

        $xml          = new SimpleXMLElement($xmlContent);
        $xmlWithCdata =
            simplexml_load_string($xml->asXML(),
                'SimpleXMLElement',
                LIBXML_NOCDATA | LIBXML_COMPACT | LIBXML_PARSEHUGE);
        $newsArray    =
            json_decode(json_encode((array)$xmlWithCdata, JSON_THROW_ON_ERROR | true), true, 512, JSON_THROW_ON_ERROR);

        $classMetadataFactory       = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);

        $serializer = new Serializer(
            [
                new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter),
                new GetSetMethodNormalizer(),
                new ArrayDenormalizer(),
            ],
            [new JsonEncoder()],
        );

        $newsAsJson = $serializer->serialize($newsArray['channel']['item'], 'json');

        return $serializer->deserialize($newsAsJson, 'App\Model\NewsLequipe[]', 'json');
    }

    private function hydrateVehiculeEntity(array $newsLequipe, ?int $limit = Constants::NEWS_FEED_DEFAULT_LIMIT): void
    {
        $lequipeFeed = $this->entityManager->getRepository(Feed::class)->findOneBy(['slug' => 'l-equipe']);

        $counter = 1;
        foreach ($newsLequipe as $newsLequipeElement) {
            if ($newsLequipeElement instanceof NewsLequipe && $counter <= $limit) {
                $news = new News();

                $newsTitle = $newsLequipeElement->getTitle();
                $newsSlug  = $this->slugger->slug($newsTitle, '-', 'fr')->lower();

                $newsAlreadyExistsInDb =
                    $this->entityManager->getRepository(News::class)->findOneBy(['slug' => $newsSlug]);

                if (!$newsAlreadyExistsInDb instanceof News) {
                    $news->setTitle($newsTitle);
                    $news->setDescription($newsLequipeElement->getDescription());
                    $news->setPublicationDate(new DateTime($newsLequipeElement->getPubDate()));
                    $news->setFeed($lequipeFeed);
                    $news->setSlug($newsSlug);

                    $this->entityManager->persist($news);
                }
            }

            $counter++;
        }

        $this->entityManager->flush();
    }

    public function getRemoteNewsAndInsertThemInDatabase(?int $limit = Constants::NEWS_FEED_DEFAULT_LIMIT): void
    {
        $this->hydrateVehiculeEntity($this->getNewsFromLequipeRssFeed(), $limit);
    }
}
