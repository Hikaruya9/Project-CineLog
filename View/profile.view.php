<div class="max-w-6xl mx-auto">
    <!-- Cabeçalho do Perfil -->
    <div class="flex flex-col md:flex-row items-center gap-6 mb-12 bg-slate-800 p-6 rounded-lg">
        <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-blue-400">
            <?php if ($user->avatar): ?>
                <img src="<?= htmlspecialchars($user->avatar) ?>" 
                     alt="<?= htmlspecialchars($user->username) ?>" 
                     class="w-full h-full object-cover">
            <?php else: ?>
                <div class="w-full h-full bg-blue-900 flex items-center justify-center text-3xl text-white">
                    <?= strtoupper(substr($user->username, 0, 1)) ?>
                </div>
            <?php endif; ?>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-white"><?= htmlspecialchars($user->username) ?></h1>
        </div>
    </div>

    <!-- Seção de Filmes Avaliados -->
    <section class="mb-12">
        <h2 class="text-2xl font-bold text-white mb-6 border-b border-slate-700 pb-2">Filmes Avaliados</h2>
        
        <?php if (!empty($user->rated_movies)): ?>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <?php foreach ($user->rated_movies as $movie): ?>
                    <a href="/movie?movie-id=<?= $movie->id ?>" class="group">
                        <div class="relative">
                            <img src="<?= htmlspecialchars($movie->poster) ?>" 
                                 alt="<?= htmlspecialchars($movie->title) ?>" 
                                 class="w-full h-auto rounded-lg shadow-md group-hover:opacity-80 transition">
                            <div class="absolute bottom-2 left-2 bg-slate-900 bg-opacity-80 px-2 py-1 rounded flex items-center">
                                <span class="text-yellow-400">
                                    <?= str_repeat('★', $movie->user_rating) ?>
                                </span>
                            </div>
                        </div>
                        <p class="mt-2 text-white group-hover:text-blue-400 truncate"><?= htmlspecialchars($movie->title) ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-8 text-gray-400">
                <i class="fas fa-film text-4xl mb-3"></i>
                <p>Nenhum filme avaliado ainda</p>
            </div>
        <?php endif; ?>
    </section>

    <!-- Seção de Reviews Escritas -->
    <section>
        <h2 class="text-2xl font-bold text-white mb-6 border-b border-slate-700 pb-2">Avaliações</h2>
        
        <?php if (!empty($user->reviews_with_comments)): ?>
            <div class="space-y-6">
                <?php foreach ($user->reviews_with_comments as $review): ?>
                    <div class="bg-slate-800 rounded-lg p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <a href="/movie?movie-id=<?= $review->movie_id ?>" class="text-xl font-semibold text-white hover:text-blue-400">
                                    <?= htmlspecialchars($review->movie_title) ?>
                                </a>
                                <div class="text-yellow-400 mt-1">
                                    <?= str_repeat('★', $review->rate) ?><?= str_repeat('☆', 5 - $review->rate) ?>
                                </div>
                            </div>
                            <span class="text-gray-400 text-sm">
                                <?= date('d/m/Y', strtotime($review->date)) ?>
                            </span>
                        </div>
                        <p class="text-gray-300"><?= htmlspecialchars($review->review) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-8 text-gray-400">
                <i class="fas fa-comment-alt text-4xl mb-3"></i>
                <p>Nenhuma review com comentário ainda</p>
            </div>
        <?php endif; ?>
    </section>
</div>