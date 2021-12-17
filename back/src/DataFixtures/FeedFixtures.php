<?php

namespace App\DataFixtures;

use App\Entity\Feed;
use App\Entity\FeedCategory;
use Constants;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class FeedFixtures extends Fixture
{
    protected SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (Constants::NEWS_FEEDS as $feed) {
            $newFeed = new Feed();

            $feedName = $feed['name'];

            $newFeed->setName($feedName);
            $newFeed->setSlug($this->slugger->slug($feedName, '-', 'fr')->lower());

            foreach ($feed['categories'] as $category) {
                $newFeedCategory = new FeedCategory();
                $newFeedCategory->setName($category['name']);
                $newFeedCategory->setSlug($this->slugger->slug($category['name'], '-', 'fr')->lower());
                $newFeedCategory->setFeed($newFeed);

                $newFeed->addFeedCategory($newFeedCategory);

                $manager->persist($newFeedCategory);
            }

            $manager->persist($newFeed);
        }

        $manager->flush();
    }
}