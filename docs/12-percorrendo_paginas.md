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