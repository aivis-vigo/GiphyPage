<?php declare(strict_types=1);

namespace Giphy\Controller;

class GifsController
{
    private ApiClient $client;
    private bool $searchRequest;

    public function __construct()
    {
        $this->client = new ApiClient();
        $this->searchRequest = isset($_POST["search"]);
    }

    public function requested(): array
    {
        if ($this->searchRequest) {
            return $this->client->fetchAll($_POST["byName"], (int) $_POST["perPage"]);
        }
        return $this->client->fetchTrending();
    }
}