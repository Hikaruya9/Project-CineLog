<section class="max-w-lg mx-auto bg-slate-800 p-8 my-30 rounded-lg shadow-md text-white">
    <h2 class="text-2xl font-bold mb-6 text-blue-400 text-center">Crie sua conta</h2>

    <?php if (isset($_SESSION['auth'])) {
        showMessage("auth");
    } elseif (isset($_SESSION['success'])) {
        showMessage("success");
    } ?>

    <form action="/login" method="POST" class="space-y-8">
        <div>
            <label for="username" class="block mb-1 font-medium">Nome de usuário</label>
            <input type="text" name="username"
                class="w-full px-4 py-2 rounded-md bg-slate-700 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="email" class="block mb-1 font-medium">E-mail</label>
            <input type="email" name="email"
                class="w-full px-4 py-2 rounded-md bg-slate-700 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="password" class="block mb-1 font-medium">Senha</label>
            <input type="password" name="password"
                class="w-full px-4 py-2 rounded-md bg-slate-700 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <button type="submit" name="sign-up"
            class="w-full bg-blue-500 hover:bg-blue-600 transition-colors text-white font-semibold py-2 px-4 rounded-md">
            Criar conta
        </button>
    </form>

    <p class="text-center text-sm mt-6 text-slate-400">
        Já tem uma conta? <a href="/sign-in" class="text-blue-400 hover:underline">Entrar</a>
    </p>
</section>