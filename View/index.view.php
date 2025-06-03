<!-- Mensagem de boas-vindas -->
<section class="text-center mb-10">
    <h2 class="text-4xl font-bold text-white mb-4">Bem-vindo ao CineLog!</h2>
    <p class="text-slate-300 text-lg">Descubra, explore e acompanhe seus filmes favoritos</p>
</section>

<!-- Barra de pesquisa -->
<form action="" method="GET" class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
    <input type="text" name="movie-search"
        class="w-full sm:w-1/2 px-4 py-2 rounded-md bg-slate-800 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
        placeholder="Pesquisar filmes..." />
    <button type="submit"
        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-md transition">
        Pesquisar
    </button>
</form>

<!-- Lista de filmes -->
<section class="grid gap-6 grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
    <?php foreach($movies as $movie): ?>
        <div class="bg-slate-800 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition duration-300">
            <a href="/movie?movie-id=<?= $movie->id ?>">
                <img src="<?= htmlspecialchars($movie->poster) ?>" alt="Poster de <?= htmlspecialchars($movie->title) ?>" class="w-full h-90% object-cover" />
                <div class="p-4">
                    <h3 class="text-white font-semibold text-lg truncate"><?= htmlspecialchars($movie->title) ?></h3>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</section>