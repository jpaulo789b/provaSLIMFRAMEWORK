<?php header("Content-type: text/html; charset=utf-8"); ?>
<?php
require 'vendor/autoload.php';
require_once('model/Pessoa.php');
require_once('controller/Functions.php');
$app = new \Slim\App();

$restFunction =  new Functions();

/*
* GET
* Através do id de uma pessoa obter um JSON
*/
$app->get('/get/[{id}]', function($request,$response,$args){
  global $restFunction;
  $pessoa = new Pessoa();
  $pessoa->id = $request->getAttribute('id');
  echo $restFunction->findPessoa($pessoa);
})->setName('get');
/* POST
* via metodo post e inserido uma pessoa*/
$app->post("/save", function ($request, $response,$args) {
    global $restFunction;
    $pessoa = new Pessoa();
    $pessoa->id = $request->getParam('id');
    $pessoa->primeiro_nome = $request->getParam('primeiro_nome');
    $pessoa->ultimo_nome = $request->getParam('ultimo_nome');
    $pessoa->email = $request->getParam('email');
    echo $restFunction->savePessoa($pessoa);
})->setName('save');

/* DELETE
* Remove uma pessoa com base em seu ID
*/
$app->delete('/remove/{id}', function ($request,$response,$args) {
  global $restFunction;
  $pessoa = new Pessoa();
  $pessoa->id = $request->getAttribute('id');
  echo $restFunction->removePessoa($pessoa);

})->setName('remove');;


$app->run();
?>
