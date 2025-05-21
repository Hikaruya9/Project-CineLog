<?php

$protectedRoutes = ['/users', '/settings', '/logout']; // Páginas protegidas contra acesso não autenticado, direciona o usuário novamente para a página inicial
$RoutesRedirect = ['/sign-in', '/sign-up']; // Redireciona o usuário autenticado caso ele tente acessar essas páginas estando logado

if (in_array($_SERVER['REQUEST_URI'], $protectedRoutes)) {
    requireAuth();
} elseif(in_array($_SERVER['REQUEST_URI'], $RoutesRedirect)) {
    redirectIfAuthenticated();
}

function requireAuth()
{
    if (!isset($_SESSION['user-id'])) {
        // Redireciona para a página de login
        header('Location: /');
        exit;
    }
}

function redirectIfAuthenticated()
{
    if (isset($_SESSION['user-id'])) {
        header('Location: /profile');
        exit;
    }
}