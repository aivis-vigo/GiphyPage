<?php declare(strict_types=1);

namespace Giphy\Controller;
use GuzzleHttp\Client;
use Giphy\Models\Gif;

class ApiClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function fetchTrending(): array
    {
        $collected = [];
        $response = $this->client->get("https://api.giphy.com/v1/gifs/trending", [
            'query' => [
                'api_key' => $_ENV['API_KEY'],
                'limit' => 10
            ]
        ]);
        $gifs = json_decode($response->getBody()->getContents())->data;
        foreach ($gifs as $gif) {
            $gif = new Gif(
                $gif->images->fixed_height->url,
                $gif->title
            );
            $collected[] = $gif;
        }
        return $collected;
    }

    public function fetchAll(string $name, int $perPage): array
    {
        $collected = [];
        $response = $this->client->get("https://api.giphy.com/v1/gifs/search", [
            'query' => [
                'api_key' => $_ENV['API_KEY'],
                'q' => $name,
                'limit' => $perPage
            ]
        ]);
        $gifs = json_decode($response->getBody()->getContents())->data;
        foreach ($gifs as $gif) {
            $gif = new Gif(
                $gif->images->fixed_height->url,
                $gif->title
            );
            $collected[] = $gif;
        }
        return $collected;
    }
}