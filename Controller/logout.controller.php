<?php

// Finaliza a sessão do usuário que está logado
if(isset($_SESSION['user-id'])){
    session_destroy();
}

header('Location: /');

?>