<?php declare(strict_types=1);

use Giphy\App;
require_once "../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable("../");
$dotenv->load();

$client = new App();
$client->run();