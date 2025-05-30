<div class="max-w-3xl mx-auto bg-slate-800 p-8 rounded-lg shadow-lg mt-12">
    <h2 class="text-3xl font-bold text-white mb-6 text-center">Atualizar informações do filme</h2>

    <?php if (isset($_SESSION['auth'])): ?>
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <ul>
                <?php foreach ($_SESSION['auth'] as $auth):?>
                    <li><?= $auth ?></li>
                <?php endforeach;
                unset($_SESSION['auth']);
                ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/movie-update" method="POST" enctype="multipart/form-data" class="space-y-6">
        
        <input type="number" name="movie-id" value=<?= $movie->id ?> hidden>

        <!-- Título -->
        <div>
            <label for="title" class="block text-slate-300 mb-2">Título</label>
            <input type="text" name="title" value="<?= $movie->title ?>"
                class="w-full px-4 py-2 rounded-md bg-slate-700 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Digite o título do filme">
        </div>

        <!-- Diretor -->
        <div>
            <label for="director" class="block text-slate-300 mb-2">Diretor</label>
            <input type="text" name="director" value="<?= $movie->director ?>"
                class="w-full px-4 py-2 rounded-md bg-slate-700 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Digite o nome do diretor">
        </div>

        <!-- Ano -->
        <div>
            <label for="year" class="block text-slate-300 mb-2">Ano</label>
            <input type="number" name="year" min="1880" max="2100" value=<?= $movie->year ?>
                class="w-full px-4 py-2 rounded-md bg-slate-700 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Ex: 2024">
        </div>

        <!-- Gênero -->
        <div>
            <label for="genre" class="block text-slate-300 mb-2">Gênero</label>
            <input type="text" name="genre" value="<?= $movie->genre ?>"
                class="w-full px-4 py-2 rounded-md bg-slate-700 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Ex: Ação, Drama, Comédia...">
        </div>

        <!-- Sinopse -->
        <div>
            <label for="synopsis" class="block text-slate-300 mb-2">Sinopse</label>
            <textarea name="synopsis" rows="4"
                class="w-full px-4 py-2 rounded-md bg-slate-700 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Digite a sinopse do filme"><?= $movie->synopsis ?></textarea>
        </div>

        <!-- Poster -->
        <div>
            <label for="poster" class="block text-slate-300 mb-2">Capa do filme</label>
            <input type="file" name="poster" accept="image/*"
                class="w-full px-4 py-2 rounded-md bg-slate-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 file:bg-slate-600 file:border-0 file:px-4 file:py-2 file:mr-4 file:text-white file:rounded-md">
        </div>

        <!-- Botão -->
        <div class="text-center">
            <button type="submit" name="update-movie"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded-md transition">
                Atualizar Filme
            </button>
        </div>
    </form>
</div>