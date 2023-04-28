<?php declare(strict_types=1);

use Giphy\Models\Gif;
require_once "vendor/autoload.php";

$client = new Giphy\ApiClient();

if (isset($_POST["search"])) {
    $response = $client->fetchAll($_POST["byName"], (int) $_POST["perPage"]);
    /** @var Gif $gif */
    foreach ($response as $gif) {
        echo "<img src='{$gif->getUrl()}' alt='{$gif->getTitle()}'>";
    }
} elseif (isset($_POST["trending"])) {
    $response = $client->fetchTrending();
    /** @var Gif $gif */
    foreach ($response as $gif) {
        echo "<img src='{$gif->getUrl()}' alt='{$gif->getTitle()}'>";
    }
}