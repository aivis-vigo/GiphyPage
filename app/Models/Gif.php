<?php declare(strict_types=1);

namespace Giphy\Models;

class Gif
{
    private string $url;
    private string $title;

    public function __construct($url, $title)
    {
        $this->url = $url;
        $this->title = $title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
