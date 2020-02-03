<?php

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

require '../vendor/autoload.php';

$browser = new HttpBrowser(HttpClient::create());
$crawler = $browser->request('GET', 'https://vitormattos.github.io/poc-lineageos-cellphone-list-statics');

// Retorna um objeto Image de todos os nodes encontrados
$images = $crawler->filter('article .img-thumbnail')->images();
mkdir('images');
foreach ($images as $image) {
    $uri = $image->getUri();
    $name = basename($uri);
    file_put_contents('images/' . $name, $uri);
}