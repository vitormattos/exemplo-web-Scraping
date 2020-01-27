## Seletor CSS

Caso você prefira trabalhar com seletor CSS do que com seletores XPath, você irá precisar instalar o `symfony/css-selector`:

```bash
 composer require symfony/css-selector
```

E no lugar de usar o método `filterXPath`, utilize o método `filter` passando um seletor CSS.

```php
$text = $crawler->filter('title')->text();
```

> Código: [exercicio4-multiplos_itens.php](../exercicio4-multiplos_itens.php)