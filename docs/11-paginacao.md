# Paginação

Temos um elemento na página inicial de paginação, vamos realizar algumas ações em cima dele.

## Total de itens por página

Observando que cada página segue o padrão `/<numero>` e que cada página tem 10 itens, a forma mais simples para coletar a url de todas as páginas é pegar o total de páginas é pegar o total de elementos e dividir pela quantidade de itens por página.

```php
$totalPages = $crawler->filter('header')->text();
$totalPages = preg_replace('/\D/', '', $totalPages);
$totalPages = ceil($totalPages);
```

> Código: [Paginação](/exercicios/11-total_itens_por_pagina.php)