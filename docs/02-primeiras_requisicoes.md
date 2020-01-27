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