<div class="max-w-2xl mx-auto bg-slate-800 p-8 rounded-lg shadow-md text-white">
    <h2 class="text-2xl font-semibold mb-6 text-blue-400">Editar Perfil</h2>

    <?php if (isset($_SESSION['auth'])): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <ul>
                <?php foreach ($_SESSION['auth'] as $auth): // Percorrerá a lista de valores (em string) que estiverem no array 'validacao' em $_SESSION e mostrará esse valor 
                ?>
                    <li><?= $auth ?></li>
                <?php endforeach;
                unset($_SESSION['auth']); // Limpa todos os valores de 'validacao' em $_SESSION
                ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/update" method="POST" enctype="multipart/form-data" class="space-y-6">

        <!-- Nome de Usuário -->
        <div>
            <label for="username" class="block mb-2 text-sm font-medium">Nome de Usuário</label>
            <input type="text" name="username" value="<?= $user->username ?>"
                class="w-full px-4 py-2 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block mb-2 text-sm font-medium">E-mail</label>
            <input type="email" name="email" value="<?= $user->email ?>"
                class="w-full px-4 py-2 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Senha Antiga -->
        <div>
            <label for="current-password" class="block mb-2 text-sm font-medium">Senha Atual</label>
            <input type="password" name="current-password"
                class="w-full px-4 py-2 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Nova Senha -->
        <div>
            <label for="new-password" class="block mb-2 text-sm font-medium">Nova Senha</label>
            <input type="password" name="new-password"
                class="w-full px-4 py-2 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Foto de Perfil -->
        <div>
            <label for="avatar" class="block mb-2 text-sm font-medium">Foto de Perfil</label>
            <input type="file" name="avatar" accept="image/*"
                class="w-full px-4 py-2 rounded bg-slate-700 text-slate-300 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-400 file:bg-slate-600 file:border-0 file:px-4 file:py-2 file:mr-4 file:text-white file:rounded-md">
        </div>

        <!-- Botão de Enviar -->
        <div class="text-right">
            <button type="submit" name="update-user"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded font-semibold transition">Salvar</button>
        </div>
    </form>
</div>