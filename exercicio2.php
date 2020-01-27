<?php

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

require 'vendor/autoload.php';

$browser = new HttpBrowser(HttpClient::create());
$browser->request('GET', 'https://vitormattos.github.io/poc-lineageos-cellphone-list-statics/');
$browser->clickLink('Login');
$crawler = $browser->submitForm('Go', ['username' => 'usuario', 'password' => 'muito-secreta'], 'GET');
$html = $crawler->html();
$raw = $browser->getInternalResponse()->getContent();