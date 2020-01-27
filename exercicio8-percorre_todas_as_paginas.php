<?php

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

require 'vendor/autoload.php';

$browser = new HttpBrowser(HttpClient::create());
$crawler = $browser->request('GET', 'https://vitormattos.github.io/poc-lineageos-cellphone-list-statics');

function getItensInAListPage($crawler)
{
    $return = [];
    $crawler->filter('article')->each(function($article) use (&$return) {
        $url = $article->filter('.title')->link()->getUri();
        $codename = basename($url);

        // pega todos os elementos th
        $attributes = $article->filter('th')->each(function($attr) {
            return strtolower($attr->text());
        });
        // pega todos os elementos td
        $values = $article->filter('td')->each(function($attr) {
            return strtolower($attr->text());
        });

        $return[$codename] = array_combine($attributes, $values);

        $return[$codename]['url'] = $url;
    });
    return $return;
}

$totalPages = $crawler->filter('header')->text();
$totalPages = ceil(preg_replace('/\D/', '', $totalPages) / 10);

$itens = [];
$itens += getItensInAListPage($crawler);
for($i = 2; $i < $totalPages; $i++) {
    $crawler = $browser->request('GET', 'https://vitormattos.github.io/poc-lineageos-cellphone-list-statics/'.$i);
    $itens+= getItensInAListPage($crawler);
}