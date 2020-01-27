<?php

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

require 'vendor/autoload.php';

$browser = new HttpBrowser(HttpClient::create());
$crawler = $browser->request('GET', 'https://vitormattos.github.io/poc-lineageos-cellphone-list-statics');

$totalPages = $crawler->filter('header')->text();
$totalPages = preg_replace('/\D/', '', $totalPages);
$totalPages = ceil($totalPages);
