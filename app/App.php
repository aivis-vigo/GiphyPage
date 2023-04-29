<?php declare(strict_types=1);

namespace Giphy;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Giphy\Controller\GifsController;
require_once "vendor/autoload.php";

class App
{
    private GifsController $gifsController;

    public function __construct()
    {
        $this->gifsController = new GifsController();
    }

    public function renderRequested(): void
    {
        $loader = new FilesystemLoader('app/Templates');
        $twig = new Environment($loader);
        echo $twig->render( "view.html.twig", [
            "pageTitle" => "Giphy",
            "pageName" => "GIF COLLECTION",
            "menuTitle" => "Find a GIF you're looking for",
            "choiceTitle" => "Or check out",
            "labelTitle" => "Title: ",
            "labelLimit" => "Limit: ",
            "collectedGifs" => $this->displayGifs()
        ]);
    }

    public function displayGifs(): array
    {
        if (isset($_POST["search"]) || isset($_POST["trending"])) {
            return $this->gifsController->requested();
        }
        return [];
    }
}