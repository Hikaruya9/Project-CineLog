<?php

// if(!isset($_SESSION)){
//     session_start();
// }

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>CineLog</title>
</head>

<body class="bg-slate-900 min-h-screen flex flex-col font-sans">

    <!-- Menu -->
    <header class="bg-slate-800 shadow-md">
        <nav class="container mx-auto flex justify-between items-center px-6 py-4">
            <h1 class="text-3xl font-bold text-blue-400">
                <a href="/">CineLog</a>
            </h1>
            <div class="space-x-4 text-slate-300">
                <a href="/sign-in" class="text-white font-semibold hover:text-blue-400 transition">Entrar</a>
                <a href="/sign-up" class="text-white font-semibold hover:text-blue-400 transition">Criar conta</a>
                <a href="/users" class="text-white font-semibold hover:text-blue-400 transition">Usuários</a>
                <a href="/profile?user-id=<?= $_SESSION['user-id'] ?>" class="text-white font-semibold hover:text-blue-400 transition">Perfil</a>
                <a href="/settings" class="text-white font-semibold hover:text-blue-400 transition">Configurações</a>
                <a href="/logout" class="text-white font-semibold hover:text-red-400 transition">Sair</a>
            </div>
        </nav>
    </header>

    <!-- Conteúdo principal -->
    <main class="flex-grow container mx-auto px-6 py-8">
        <?php require "View/{$view}.view.php" ?>
    </main>

    <!-- Rodapé -->
    <footer class="bg-slate-800 text-slate-300 py-6 mt-10">
        <div class="container mx-auto px-6 flex flex-col sm:flex-row justify-between">
            <h3 class="text-sm">2025, CineLog &copy; Todos os direitos reservados</h3>
            <div class="text-sm mt-4 sm:mt-0 space-y-1">
                <p>test@example.com</p>
                <p>Rua do Cachimbo, 9999, Cidade - RS</p>
            </div>
        </div>
    </footer>

</body>

</html>