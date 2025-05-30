<form action="" method="GET" class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
    <input type="text" name="movie-search"
        class="w-full sm:w-1/2 px-4 py-2 rounded-md bg-slate-800 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
        placeholder="Procurar filmes..." />
    <button type="submit"
        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-md transition">
        Pesquisar
    </button>
</form>

<div class="bg-slate-800 p-6 rounded-lg shadow-lg">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white">Lista de Filmes</h2>
        <a href="/movie-add" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded-md transition">
            Adicionar Filme
        </a>
    </div>

    <?php if (empty($movies)): ?>
        <p class="text-slate-300 text-center">Nenhum filme cadastrado</p>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-slate-700 rounded-lg overflow-hidden">
                <thead class="bg-slate-600 text-slate-200 text-left text-sm uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-center">ID</th>
                        <th class="px-6 py-3 text-center">Capa do filme</th>
                        <th class="px-6 py-3 text-center">Título</th>
                        <th class="px-6 py-3 text-center">Diretor</th>
                        <th class="px-6 py-3 text-center">Ano</th>
                        <th class="px-6 py-3 text-center">Gênero</th>
                        <th></th>
                        <th class="px-6 py-3 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-slate-100 divide-y divide-slate-600">
                    <?php foreach ($movies as $movie): ?>
                        <tr class="hover:bg-slate-600 transition text-center">
                            <td class="px-6 py-4 align-middle"><?= $movie->id ?></td>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex justify-center">
                                    <img
                                        src="<?= htmlspecialchars($movie->poster) ?>"
                                        alt="Avatar de <?= htmlspecialchars($movie->title) ?>"
                                        class="w-32 h-full rounded-sm object-cover">
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle"><?= htmlspecialchars($movie->title) ?></td>
                            <td class="px-6 py-4 align-middle"><?= htmlspecialchars($movie->director) ?></td>
                            <td class="px-6 py-4 align-middle"><?= $movie->year ?></td>
                            <td class="px-6 py-4 align-middle"><?= htmlspecialchars($movie->genre) ?></td>
                            <td class="px-6 py-4">
                                <form action="/movie" method="GET" class="inline-block mb-1">
                                    <input type="number" name="movie" value="<?= $movie->id ?>" hidden>
                                    <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition">Ver Filme</button>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <form action="/movie-update" method="GET" class="inline-block mt-1">
                                    <input type="number" name="movie-id" value="<?= $movie->id ?>" hidden>
                                    <button type="submit" class="pl-6 px-5 py-2 bg-yellow-500 text-white text-center font-semibold rounded-md hover:bg-yellow-600 transition">Atualizar</button>
                                </form>
                                <form action="/movie-delete" method="GET" class="inline-block mt-1">
                                    <input type="number" name="movie-id" value="<?= $movie->id ?>" hidden>
                                    <button type="submit" class="pl-6 px-5 py-2 bg-red-500 text-white text-center font-semibold rounded-md hover:bg-red-600 transition">Deletar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>