<?php

// Apresentar visualização do site de acordo com a rota
function view($view, $data = [])
{

    foreach ($data as $key => $value) {
        $$key = $value;
    }

    require "View/Template/app.php";
}

// Mostra mensagem de erro ou sucesso na tela
function showMessage($message)
{
    if (!isset($_SESSION[$message])) {
        return;
    }

    $color = ($message == "auth") ? "red" : "green";

    echo '<div class="bg-' . $color . '-500 text-white p-4 rounded mb-4">';
    echo '<ul>';
    
    if (is_array($_SESSION[$message])) {
        foreach ($_SESSION[$message] as $msg) {
            echo '<li>' . $msg . '</li>';
        }
    } else {
        echo '<li>' . $_SESSION[$message] . '</li>';
    }
    
    echo '</ul>';
    echo '</div>';
    
    unset($_SESSION[$message]);
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
function abort($code)
{
    http_response_code(404);
    view($code);
    die();
}
