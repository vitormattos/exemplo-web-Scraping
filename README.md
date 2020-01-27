# PHP web scraping

## Preparando ambiente com PHP

Este projeto utiliza versão latest do PHP com [xdebug](https://xdebug.org/) utilizando [Docker](https://docs.docker.com/engine/reference/builder/) e [docker-compose](https://docs.docker.com/compose/).

Para levantar o ambiente com PHP clone o projeto e levante o ambiente com docker:

```bash
docker-compose up
```

> **PS**: Gosto de utilizar `docker-compose up` e não `docker-compose up -d` para que possamos monitorar logs dos containers mais facilmente.

## Fazendo as primeiras requisições

Para fazermos as primeiras requisições, utilizaremos o pacote [symfony/http-client](https://symfony.com/doc/current/components/http_client.html) por ele implementar [PSR-18](https://www.php-fig.org/psr/psr-18/) que nos traz, além de um padrão para se trabalhar com HTTP e melhor tratamento de erros, também facilita a implementação de testes na aplicação usando `MockHttpClient` e `MockResponse` para fazer mock de requisições e respostas.

> **PS**: Podemos rodar comandos dentro do container da seguinte forma:

```bash
`docker-compose exec php7 composer require symfony/http-client`
```

Daqui para frente faremos mais simplificado e vou informar apenas o comando executado dentro do container.

O nosso site de teste será https://vitormattos.github.io/poc-lineageos-cellphone-list-statics/, ele é baseado no site da Wiki do LineageOS que é o Android original, sem pacotes da Google, fabricantes e operadora. Para quem curte segurança, é uma excelente dica. O código fonte deste site está disponível em https://github.com/vitormattos/poc-lineageos-cellphone-list.

Para o nosso **hello world** faremos uma requisição para a página `about` de nosso site de testes. Crie um arquivo chamado `exercicio1.php` na raiz do projeto e coloque o seguinte conteúdo:

```php
<?php

use Symfony\Component\HttpClient\HttpClient;

require 'vendor/autoload.php';

$client = HttpClient::create();
$response = $client->request('GET', 'https://vitormattos.github.io/poc-lineageos-cellphone-list-statics/about/');
```

Bom, é só, já fizemos a nossa primeira requisição. Na variável `$response` podemos executar algumas ações:

```php
$statusCode = $response->getStatusCode();
// $statusCode = 200
$contentType = $response->getHeaders()['content-type'][0];
// $contentType = 'text/html; charset=utf-8'
$content = $response->getContent();
// HTML da página about
```

Perfeito! Com isto já conseguimos fazer bastante coisas mas vamos avançando aos poucos.

> Código: [exercicio1-ola_mundo.php](exercicio1-ola_mundo.php)

Mas, e se precisarmos clicar em links, preencher formulários, voltar a navegação para a página anterior, tratar redirecionamentos do site (isto pode se tornar um caos sem a ferramenta correta para coleta de dados), esquecer que o site tem cookies de sessão. Este é todo o trabalho que um browser já faz por nós. Podemos simplificar a nossa vida?

## Simulando comportamento de browser

Tem um outro pacote que, em conjunto com o `http-client` irá nos auxiliar bastante:

```php
composer require symfony/browser-kit
```

Com o Browser-kit é possível navegar pelas páginas como se estivéssemos realmente utilizando um browser, no exemplo a seguir iremos acessar a página inicial de nosso site de testes e ir em seguida para a página de autenticação:

### Clicando em um link
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

> Código: [exercicio2-clicar_link.php](exercicio2-clicar_link.php)

Mas, e se eu realmente precisar me autenticar em um site? Como faço para enviar dados via formulário?

### Preenchendo um formulário
Para fazer envio de dados via formulários, precisaremos de mais um pacote que irá funcionar em conjunto com o Browser-kit para realizar o envio dos dados. Então vamos instalar:

```bash
composer require symfony/mime
```

Fazer envio de dados por formulário é bem simples.:
```php
$crawler = $browser->submitForm('Go', ['username' => 'usuario', 'password' => 'muito-secreta'], 'GET');
```

Só isto mesmo? Sim!

> **PS**: Só. Lembre-se de definir o método de envio dos dados, se é por `GET` ou `POST`.

Para ter acesso aos dados coletados, pegue o retorno da função `submitForm`.

```php
// Pega todo o HTML de uma página comum
$html = $crawler->html();
// Coletar dados retornados como JSON por alguma API.
$raw = $browser->getResponse()->getContent();
```

> Código: [exercicio2-formulario.php](exercicio2-formulario.php)

### Navegando por páginas

É possível avançar e voltar na navegação.

> Código: [exercicio3-navegacao.php](exercicio3-navegacao.php)

## Tratando dados retornados

Ações feitas em `$browser` como por exemplo `submitForm`, `request`, `clickLink` que retornem um html, podem ser manipuladas de forma bem prática. Estes métodos retornam um [crawler](https://symfony.com/doc/current/components/dom_crawler.html) em cima do html retornado.

Digamos que desejamos coletar a tag `title`

## Seletor xpath

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

> Código: [exercicio4-multiplos_itens.php](exercicio4-multiplos_itens.php)

## Seletor CSS

Caso você prefira trabalhar com seletor CSS do que com seletores XPath, você irá precisar instalar o `symfony/css-selector`:

```bash
 composer require symfony/css-selector
```

E no lugar de usar o método `filterXPath`, utilize o método `filter` passando um seletor CSS.

```php
$text = $crawler->filter('title')->text();
```

> Código: [exercicio4-multiplos_itens.php](exercicio4-multiplos_itens.php)

### Retornando múltiplos dados

Se o nosso seletor XPath retorna múltiplos nodes, como faremos para pegar o texto de todos?

As funções `filterXPath` e `filter` retornam um objeto que pode ser percorrido como um array, podemos utilizar um foreach normal do PHP ou utilizar um método que já faz a iteração neste array.

Vamos para a página `/about` e vamos coletar todas as tags P desta página utilizando seletor CSS:

```php
$crawler = $browser->request('GET', 'https://vitormattos.github.io/poc-lineageos-cellphone-list-statics/about');

$p = $crawler->filter('article p')->each(function($node) {
    return $node->text();
});
```

> Código: [exercicio4-multiplos_itens.php](exercicio4-multiplos_itens.php)

# Baixando imagens

Aplique o seletor CSS para encontrar todos os nodes de imagens da home do site e em seguida chame o método images:

```php
$images = $crawler->filter('article .img-thumbnail')->images();
```

O método `images` irá nos auxiliar a resolver o src das imagens. Caso estejam com endereços relativos, ele já irá colocar o path absoluto e para cada imagem poderemos chamar o método `getUri()` para pegar a url completa da imagem e baixá-la.

Incrementando o código acima, vamos fazer um `each` para iterar nos nodes retornados, de cada node vamos pegar o atributo src e baixar a imagem:

```php
// Retorna um objeto Image de todos os nodes encontrados
$images = $crawler->filter('article .img-thumbnail')->images();
mkdir('images');
foreach ($images as $image) {
    $uri = $image->getUri();
    $name = basename($uri);
    file_put_contents('images/' . $name, $uri);
}
```

Similar ao método link também temos alguns outros métodos que nos facilitam: `image`, `link`

> Código: [exercicio5-baixando_imagens.php](exercicio5-baixando_imagens.php)

# Coletando atributos de cada item visível na home

Agora vamos baixar todos os dados de cada aparelho visível na home do site. Como não é o objetivo trabalharmos com banco de dados nestes exercícios, vamos salvar a saída destes dados em um arquivo [`json`](https://www.php.net/manual/en/book.json.php).

```php
$crawler = $browser->request('GET', 'https://vitormattos.github.io/poc-lineageos-cellphone-list-statics/about');
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
$itensInPage = getItensInAListPage($crawler);
```

> Código: [exercicio6-atributo_de_cada_item_visivel.php](exercicio6-atributo_de_cada_item_visivel.php)

# Paginação

Temos um elemento na página inicial de paginação, vamos realizar algumas ações em cima dele.

## Total de itens por página

Observando que cada página segue o padrão `/<numero>` e que cada página tem 10 itens, a forma mais simples para coletar a url de todas as páginas é pegar o total de páginas é pegar o total de elementos e dividir pela quantidade de itens por página.

```php
$totalPages = $crawler->filter('header')->text();
$totalPages = preg_replace('/\D/', '', $totalPages);
$totalPages = ceil($totalPages);
```

> Código: [exercicio7-total_itens_por_pagina.php](exercicio7-total_itens_por_pagina.php)

# Percorrendo todas as páginas da listagem


Vamos utilizar nossa função criada anteriormente e a variável total de páginas

```php
$itens = [];
$itens += getItensInAListPage($crawler);
for($i = 2; $i < $totalPages; $i++) {
    $crawler = $browser->request('GET', 'https://vitormattos.github.io/poc-lineageos-cellphone-list-statics/'.$i);
    $itens+= getItensInAListPage($crawler);
}
```

> Código: [exercicio8-percorre_todas_as_paginas.php](exercicio8-percorre_todas_as_paginas.php)

# Baixando o conteúdo das páginas dos produtos

Pra baixar o conteúdo das páginas dos produtos precisaremos fazer algo similar ao que já fizemos anteriormente.

> Código [exercicio9-baixar_tudo.php](exercicio9-baixar_tudo.php)