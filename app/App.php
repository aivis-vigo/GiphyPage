<?php declare(strict_types=1);

namespace Giphy;
use Giphy\Controller\GifsController;
use Giphy\Controller\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
require_once "../vendor/autoload.php";

class App
{
    private Router $router;
    private GifsController $client;

    public function __construct()
    {
        $this->router = new Router();
        $this->client = new GifsController();
    }

    public function run(): void
    {
        $loader = new FilesystemLoader('../app/Templates');
        $twig = new Environment($loader);
        echo $twig->render("view.html.twig", [
            "pageTitle" => "Giphy",
            "menuTitle" => "Find a GIF you're looking for",
            "choiceTitle" => "Or check out",
            "labelTitle" => "Title: ",
            "labelLimit" => "Limit: ",
            "collectedGifs" => $this->displayGifs()
        ]);
    }

    private function displayGifs(): array
    {
        if (isset($_POST["search"]) || isset($_POST["trending"])) {
            return $this->client->requested();
        }
        return ($this->router->dispatch() != null) ? $this->router->dispatch() : [];
    }
}