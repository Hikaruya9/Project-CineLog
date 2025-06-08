<div class="max-w-2xl mx-auto bg-slate-800 p-8 rounded-lg shadow-md text-white">
    <h2 class="text-2xl font-semibold mb-6 text-blue-400">Editar Perfil</h2>

    <?php if (isset($_SESSION['auth'])) {
        showMessage("auth");
    } elseif (isset($_SESSION['success'])) {
        showMessage("success");
    } ?>

    <form action="/settings" method="POST" enctype="multipart/form-data" class="space-y-6">

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

        <!-- Botões -->
        <div class="flex justify-between items-center pt-4">
            <!-- Botão para Abrir Modal de Confirmação -->
            <button type="button" onclick="openDeleteModal()"
                class="text-red-500 hover:text-red-400 font-medium flex items-center">
                <i class="fas fa-trash-alt mr-2"></i>
                Excluir Conta
            </button>

            <!-- Botão de Salvar -->
            <button type="submit" name="update-user"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded font-semibold transition">Salvar</button>
        </div>
    </form>
</div>

<!-- Confirmação para Excluir Conta -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-slate-800 p-6 rounded-lg max-w-md w-full">
        <h3 class="text-xl font-semibold text-white mb-4">Confirmar Exclusão</h3>
        <p class="text-gray-300 mb-6">Tem certeza que deseja excluir sua conta permanentemente? Esta ação não pode ser desfeita.</p>

        <div class="flex justify-end space-x-4">
            <button onclick="closeDeleteModal()"
                class="px-4 py-2 border border-gray-600 text-gray-300 rounded hover:bg-gray-700 transition">
                Cancelar
            </button>
            <form action="/user-delete" method="POST">
                <button type="submit"
                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded font-medium transition">
                    Confirmar Exclusão
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>