<?php

namespace App\Model;

class NewsLequipe
{
    public string $title = '';

    public string $description = '';

    public string $pubDate;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPubDate(): string
    {
        return $this->pubDate;
    }

    public function setPubDate(string $pubDate): void
    {
        $this->pubDate = $pubDate;
    }
}