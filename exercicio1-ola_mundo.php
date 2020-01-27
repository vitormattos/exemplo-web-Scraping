<?php

use Symfony\Component\HttpClient\HttpClient;

require 'vendor/autoload.php';

$client = HttpClient::create();
$response = $client->request('GET', 'https://vitormattos.github.io/poc-lineageos-cellphone-list-statics/about/');

$statusCode = $response->getStatusCode();
// $statusCode = 200
$contentType = $response->getHeaders()['content-type'][0];
// $contentType = 'text/html; charset=utf-8'
$content = $response->getContent();
// HTML da página about