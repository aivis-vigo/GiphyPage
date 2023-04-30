<?php declare(strict_types=1);

namespace Giphy\Controller;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Giphy\App;
use function FastRoute\simpleDispatcher;
require_once "../vendor/autoload.php";

class Router
{
    private ApiClient $client;
    private Dispatcher $dispatcher;

    public function __construct()
    {
        $this->client = new ApiClient();
        $this->dispatcher = simpleDispatcher(function (RouteCollector $r) {
            $r->addRoute('GET', '/trending', 'trending');
            $r->addRoute('GET', '/search', 'search');
            $r->addRoute('GET', '', '');
        });
    }

    public function dispatch()
    {
        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                switch ($handler) {
                    case "search":
                        $url = parse_url($_SERVER["REQUEST_URI"]);
                        $parts = explode("&limit=", $url["query"]);
                        return $this->client->fetchAll(substr($parts[0], 2), (int)$parts[1]);
                    case "trending":
                        return $this->client->fetchTrending();
                    case null:
                        return [];
                }
        }
    }
}

