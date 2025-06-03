<?php

class Auth
{
    function requireExtraAuth()
    {
        if (!isset($_SESSION['user-id']) && $_SESSION['permission_level'] === 1) {
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