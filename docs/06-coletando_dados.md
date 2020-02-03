# Tratando dados retornados

Ações feitas em `$browser` como por exemplo `submitForm`, `request`, `clickLink` que retornem um html, podem ser manipuladas de forma bem prática. Estes métodos retornam um [crawler](https://symfony.com/doc/current/components/dom_crawler.html) em cima do html retornado.

Digamos que desejamos coletar a tag `title`

# Seletor xpath

O site está com jQuery, abriremos o console do browser e executaremos o seguinte código na página about:

```js
$x('//title')
```
Isto irá trazer um array com todas as tags title encontradas, mas só há uma.

Como faço isto na minha aplicação?
```php
<?php

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

require 'vendor/autoload.php';

$browser = new HttpBrowser(HttpClient::create());
$crawler = $browser->request('GET', 'https://vitormattos.github.io/poc-lineageos-cellphone-list-statics');
```

> **PS**: método request retornado por `HttpClient`  é o response raw da requisição e o método `request` de `HttpBrowser` retorna um objeto `Crawler`.

É com `$crawler` que iremos trabalhar agora.

```php
$text = $crawler->filterXPath('//title')->text();
```

> Código: [Seletor xpath](/exercicio/06-seletor-xpath.php)