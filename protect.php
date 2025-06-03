<?php

require 'auth.php';

$auth = new Auth();
$extraProtectedRoutes = ['/users', '/movies', '/movie-delete', '/movie-update', '/movie-add']; // Páginas que apenas usuários com permissão de administrador conseguem acessar
$protectedRoutes = ['/settings', '/logout', '/user-delete', '/user-update', '/review']; // Páginas protegidas contra acesso não autenticado, direciona o usuário novamente para a página inicial
$publicRoutes = ['/sign-in', '/sign-up']; // Redireciona o usuário autenticado caso ele tente acessar essas páginas estando logado

if (in_array($_SERVER['REQUEST_URI'], $extraProtectedRoutes)) {
    $auth->requireExtraAuth();
} elseif (in_array($_SERVER['REQUEST_URI'], $protectedRoutes)) {
    $auth->requireAuth();
} elseif (in_array($_SERVER['REQUEST_URI'], $publicRoutes)) {
    $auth->redirectIfAuthenticated();
}