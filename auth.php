<?php

class Auth
{
    function requireAuth()
    {
        if (!isset($_SESSION['user-id'])) {
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
}