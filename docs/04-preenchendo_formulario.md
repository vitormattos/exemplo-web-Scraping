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