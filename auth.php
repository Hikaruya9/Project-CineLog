<?php

$protectedRoutes = ['/users', '/settings', '/logout'];
$protectedRoutesAuths = ['/sign-in', '/sign-up'];

if (in_array($_SERVER['REQUEST_URI'], $protectedRoutes)) {
    requireAuth();
}

function requireAuth()
{
    if (!isset($_SESSION['user_id'])) {
        // Redireciona para a página de login
        header('Location: /sign-in?error=not_authenticated');
        exit;
    }
}

function redirectIfAuthenticated()
{
    if (isset($_SESSION['user_id'])) {
        header('Location: /profile');
        exit;
    }
}