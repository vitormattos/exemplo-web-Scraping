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

> Código: [exercicio6-atributo_de_cada_item_visivel.php](../exercicio6-atributo_de_cada_item_visivel.php)