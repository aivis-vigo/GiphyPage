<?php declare(strict_types=1);

use Giphy\App;
require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new App();
$response = $client->renderRequested();