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

> Código: [Baixar arquivos](/exercicio/09-baixando_imagens.php)