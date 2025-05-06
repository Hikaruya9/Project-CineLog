<?php

// Apresentar visualização do site de acordo com a rota
function view($view, $data = []){

    foreach($data as $key => $value){
        $$key = $value;
    }

    require "View/Template/app.php";

}

// Função para teste de código
function test(...$dump)
{
    echo "<pre>";
    var_dump($dump);
    echo "</pre>";

    die();
}

// Função para url que não direcione a qualquer arquivo
function abort($code){

    http_response_code(404);
    view($code);
    die();
}

?>