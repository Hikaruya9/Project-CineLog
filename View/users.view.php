<?php

// echo "teste usuários";

?>

<form action="" method="GET" class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
    <input type="text" name="user-search"
        class="w-full sm:w-1/2 px-4 py-2 rounded-md bg-slate-800 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
        placeholder="Procurar usuarios..." />
    <button type="submit"
        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-md transition">
        Pesquisar
    </button>
</form>

<div class="bg-slate-800 p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-white mb-6">Lista de Usuários</h2>

    <?php if (empty($users)): ?>
        <p class="text-slate-300 text-center">Nenhum usuário cadastrado</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-slate-700 rounded-lg overflow-hidden">
                <thead class="bg-slate-600 text-slate-200 text-left text-sm uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-center">ID</th>
                        <th class="px-6 py-3 text-center">Foto de perfil</th>
                        <th class="px-6 py-3 text-center">Nome de usuário</th>
                        <th class="px-6 py-3 text-center">Email</th>
                        <th class="px-6 py-3 text-center">Perfil</th>
                        <th class="px-6 py-3 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-slate-100 divide-y divide-slate-600">
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-slate-600 transition text-center">
                            <td class="px-6 py-4 align-middle"><?= htmlspecialchars($user->id) ?></td>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex justify-center">
                                    <img
                                        src="<?= htmlspecialchars($user->avatar) ?>"
                                        alt="Avatar de <?= htmlspecialchars($user->username) ?>"
                                        class="w-12 h-12 rounded-full object-cover border border-slate-500">
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle"><?= htmlspecialchars($user->username) ?></td>
                            <td class="px-6 py-4 align-middle"><?= htmlspecialchars($user->email) ?></td>
                            <td class="px-6 py-4">
                                <form action="/profile" method="GET" class="inline-block mb-1">
                                    <input type="number" name="user" value="<?= $user->id ?>" hidden>
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition">Ver Perfil</button>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <form action="/delete" method="GET" class="inline-block mt-1">
                                    <input type="number" name="user-id" value="<?= $user->id ?>" hidden>
                                    <button type="submit" class=" pl-6 px-5 py-2 bg-red-500 text-white text-center font-semibold rounded-md hover:bg-red-600 transition">Deletar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>