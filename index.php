<?php declare(strict_types=1);

use Giphy\ApiClient;
require_once "vendor/autoload.php";

$loader = new Twig\Loader\FilesystemLoader('app/Views');
$twig = new Twig\Environment($loader);
echo $twig->render( "view.html.twig", [
    "pageTitle" => "Giphy",
    "pageName" => "GIF COLLECTION",
    "menuTitle" => "Find a GIF you're looking for",
    "choiceTitle" => "Or check out"
]);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/trending', [ApiClient::class, "fetchTrending"]);
    $r->addRoute('GET', '/search', [ApiClient::class, "fetchAll"]);
});

require_once "app/Controller/controller.php";

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controllerName, $methodName] = $handler;
        $controller = new $controllerName;

        if ($methodName != "fetchTrending") {
            $link = $_SERVER["REQUEST_URI"];
            $searchFor = explode("=", str_replace("%20", "+", $link));
            $title = explode("&", $searchFor[1]);
            $response = $controller->$methodName($title[0], (int) $searchFor[2]);
            foreach ($response as $gif) {
                echo "<img src='{$gif->getUrl()}' alt='{$gif->getTitle()}'>";
            }
        }

        $response = $controller->$methodName();
        foreach ($response as $gif) {
            echo "<img src='{$gif->getUrl()}' alt='{$gif->getTitle()}'>";
        }

        break;
}