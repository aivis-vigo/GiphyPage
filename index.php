<?php declare(strict_types=1);

use Giphy\Models\Gif;
require "app/Views/view.php";
require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new Giphy\ApiClient();
$response = $client->fetchTrending();

if (isset($_GET["trending"])) {
    /** @var Gif $gif */
    foreach ($response as $gif) {
        echo "<img src='{$gif->getUrl()}' alt='{$gif->getTitle()}'>";
    }
}
