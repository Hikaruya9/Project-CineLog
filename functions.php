<?php

// Apresentar visualização do site de acordo com a rota
function view($view, $data = []){

    foreach($data as $key => $value){
        $$key = $value;
    }

    require "View/Template/app.php";

}

// Função para teste de código e encerrando a aplicação no fim
function dd(...$dump)
{
    dump($dump);
    die();
}

// Função para teste de código, mas sem o encerramento da aplicação
function dump(...$dump)
{
    echo "<pre>";
    var_dump($dump);
    echo "</pre>";
}

// Função para url que não direcione a qualquer arquivo
function abort($code){

    http_response_code(404);
    view($code);
    die();
}

?>