# Simulando comportamento de browser

Tem um outro pacote que, em conjunto com o `http-client` irá nos auxiliar bastante:

```php
composer require symfony/browser-kit
```

Com o Browser-kit é possível navegar pelas páginas como se estivéssemos realmente utilizando um browser, no exemplo a seguir iremos acessar a página inicial de nosso site de testes e ir em seguida para a página de autenticação:

## Clicando em um link
```php
<?php

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

require 'vendor/autoload.php';

$browser = new HttpBrowser(HttpClient::create());
$browser->request('GET', 'https://vitormattos.github.io/poc-lineageos-cellphone-list-statics/');
$browser->clickLink('Login');

// Pega todo o HTML da página
$html = $crawler->html();
```

Top! Já conseguimos navegar entre as páginas sem precisarmos nos preocupar se foi feito algum tipo de redirecionamento, com cookies ou qualquer coisa do gênero, este pacote simplifica muito o nosso trabalho.

> Código: [Clicar em link](/exercicios/03-clicar_link.php)

Mas, e se eu realmente precisar me autenticar em um site? Como faço para enviar dados via formulário?