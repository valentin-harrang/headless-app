<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity
 */
#[ApiResource]
class Feed
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $name = '';

    /**
     * @ORM\OneToMany(targetEntity="FeedCategory", mappedBy="feed", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected Collection $feedCategories;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $slug = '';

    #[Pure] public function __construct()
    {
        $this->feedCategories = new ArrayCollection();
    }

    public function addFeedCategory(FeedCategory $feedCategory): void
    {
        if ($this->feedCategories->contains($feedCategory) === false) {
            $this->feedCategories->add($feedCategory);
        }
    }

    public function removeFeedCategory(FeedCategory $feedCategory): void
    {
        if ($this->feedCategories->contains($feedCategory) === true) {
            $this->feedCategories->removeElement($feedCategory);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getFeedCategories(): Collection
    {
        return $this->feedCategories;
    }

    public function setFeedCategories(Collection $feedCategories): void
    {
        $this->feedCategories = $feedCategories;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }
}