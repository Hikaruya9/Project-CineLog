<?php

require 'auth.php';

$auth = new Auth();
$protectedRoutes = ['/users', '/settings', '/logout', '/user-delete', 'user-update', 'movie-delete', 'movie-update']; // Páginas protegidas contra acesso não autenticado, direciona o usuário novamente para a página inicial
$publicRoutes = ['/sign-in', '/sign-up']; // Redireciona o usuário autenticado caso ele tente acessar essas páginas estando logado

if (in_array($_SERVER['REQUEST_URI'], $protectedRoutes)) {
    $auth->requireAuth();
} elseif (in_array($_SERVER['REQUEST_URI'], $publicRoutes)) {
    $auth->redirectIfAuthenticated();
}