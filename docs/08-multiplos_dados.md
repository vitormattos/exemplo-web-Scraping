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

> Código: [exercicio4-multiplos_itens.php](../exercicio4-multiplos_itens.php)