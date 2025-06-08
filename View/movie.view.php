<!-- movie.view.php -->
<div class="max-w-6xl mx-auto">
    <!-- Cabeçalho do Filme -->
    <div class="flex flex-col md:flex-row gap-8 mb-12">
        <!-- Poster do Filme -->
        <div class="w-full md:w-1/3">
            <img src="<?= htmlspecialchars($movie->poster) ?>"
                alt="<?= htmlspecialchars($movie->title) ?>"
                class="w-full rounded-lg shadow-xl">
        </div>

        <!-- Informações do Filme -->
        <div class="w-full md:w-2/3">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2"><?= htmlspecialchars($movie->title) ?></h1>

            <div class="flex items-center gap-4 mb-4">
                <span class="text-blue-400 font-medium"><?= htmlspecialchars($movie->year) ?></span>
                <span class="text-yellow-400">
                    <?= str_repeat('★', floor($movie->rating)); ?><?= str_repeat('☆', 5 - floor($movie->rating)) ?>
                </span>
            </div>

            <div class="mb-4">
                <h2 class="text-xl font-semibold text-white mb-1">Diretor</h2>
                <p class="text-gray-300"><?= htmlspecialchars($movie->director) ?></p>
            </div>

            <div class="mb-4">
                <h2 class="text-xl font-semibold text-white mb-2">Gêneros</h2>
                <div class="flex flex-wrap gap-2">
                    <?php foreach (explode(',', $movie->genre) as $genre): ?>
                        <span class="bg-blue-900 bg-opacity-40 px-3 py-1 rounded-full text-sm text-blue-200">
                            <?= htmlspecialchars(trim($genre)) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mb-6">
                <h2 class="text-xl font-semibold text-white mb-2">Sinopse</h2>
                <p class="text-gray-300 leading-relaxed"><?= htmlspecialchars($movie->synopsis) ?></p>
            </div>
        </div>
    </div>

    <!-- Seção de Adicionar Review (apenas para usuários logados) -->

        <div class="mb-8 text-right">
            <a href="<?= isset($_SESSION['user-id']) ? '/review?movie-id=' . $movie->id : '/sign-in' ?>"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                <i class="fas fa-plus mr-2"></i>
                Enviar avaliação
            </a>
        </div>

    <!-- Seção de Avaliações -->
    <div class="border-t border-gray-700 pt-8">
        <h2 class="text-2xl font-bold text-white mb-6">Avaliações</h2>

        <?php if (!empty($movie->reviews)): ?>
            <div class="space-y-4">
                <?php foreach ($movie->reviews as $review): ?>
                    <div class="bg-slate-800 p-4 rounded-lg relative">
                        <!-- Controles de Edição/Deleção -->
                        <?php if (isset($_SESSION['user-id']) && ($_SESSION['user-id'] == $review->user_id || $_SESSION['permission_level'] == "1")): ?>
                            <div class="absolute top-4 right-4 flex space-x-2 z-10">
                                <?php if ($_SESSION['user-id'] == $review->user_id): ?>
                                    <a href="/review?review-id=<?= $review->id ?>" 
                                       class="text-blue-400 hover:text-blue-300 transition"
                                       title="Editar review">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <form action="/review" method="POST" class="inline">
                                    <input type="number" name="review-id" value=<?= $review->id ?> hidden>
                                    <button type="submit" name="delete-review"
                                            name="delete-review"
                                            class="text-red-400 hover:text-red-300 transition"
                                            title="Excluir review"
                                            onclick="return confirm('Tem certeza que deseja excluir esta review?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                        
                        <div class="flex items-center gap-4 mb-3">
                            <div class="w-10 h-10 rounded-full bg-slate-700 overflow-hidden flex items-center justify-center">
                                <?php if (!empty($review->avatar)): ?>
                                    <img src="<?= htmlspecialchars($review->avatar) ?>"
                                        alt="<?= htmlspecialchars($review->username) ?>"
                                        class="w-full h-full object-cover">
                                <?php else: ?>
                                    <span class="text-lg font-medium text-blue-300">
                                        <?= strtoupper(substr($review->username, 0, 1)) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div>
                                <a href="/profile?user-id=<?= $review->user_id ?>">
                                    <h3 class="text-lg font-semibold text-white hover:text-blue-400">
                                        <?= htmlspecialchars($review->username) ?>
                                    </h3>
                                </a>
                                <div class="text-yellow-400 text-sm">
                                    <?= str_repeat('★', $review->rate) ?><?= str_repeat('☆', 5 - $review->rate) ?>
                                    <span class="text-gray-400 ml-2">
                                        <?= date('d/m/Y', strtotime($review->date)) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-300 pl-14"><?= htmlspecialchars($review->review) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-8 text-gray-400">
                <i class="fas fa-comment-slash text-3xl mb-3"></i>
                <p>Este filme ainda não possui avaliações</p>
                <p class="text-sm mt-1">Seja o primeiro a compartilhar sua opinião!</p>
            </div>
        <?php endif; ?>
    </div>
</div>