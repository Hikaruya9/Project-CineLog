<?php

class Auth
{
    function requirePermission()
    {
        if (empty($_SESSION['user-id']) || !isset($_SESSION['permission_level']) || $_SESSION['permission_level'] != "1") {
            header('Location: /');
            exit;
        }
    }

    function requireAuth()
    {
        if (!isset($_SESSION['user-id'])) {
            header('Location: /sign-in');
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
