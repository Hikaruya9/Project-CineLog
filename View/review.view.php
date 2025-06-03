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


<!-- review.view.php -->
<div class="max-w-6xl mx-auto flex flex-col md:flex-row gap-8">
    <!-- Seção do Filme (lado esquerdo) -->
    <div class="md:w-1/3">
        <div class="sticky top-4">
            <img src="<?= htmlspecialchars($movie->poster) ?>"
                alt="<?= htmlspecialchars($movie->title) ?>"
                class="w-full rounded-lg shadow-xl mb-4">
            <h2 class="text-2xl font-bold text-white"><?= htmlspecialchars($movie->title) ?></h2>
            <p class="text-gray-300"><?= htmlspecialchars($movie->year) ?></p>
        </div>
    </div>

    <!-- Seção do Formulário (lado direito) -->
    <div class="md:w-2/3">
        <form action="/review" method="POST" class="bg-slate-800 p-6 rounded-lg">

            <input type="number" name="movie-id" value=<?= $movie->id ?> hidden>

            <h1 class="text-2xl font-bold text-white mb-6">Sua avaliação</h1>

            <div class="flex items-center justify-between mb-6">
                <label class="text-white font-medium">Sua nota:</label>
                <div class="flex items-center">
                    <div class="flex" id="star-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <input type="radio" id="rate-<?= $i ?>" name="rate" value="<?= $i ?>"
                                class="hidden peer/rate-<?= $i ?>" <?= $i == 3 ? 'checked' : '' ?>>
                            <label for="rate-<?= $i ?>"
                                class="text-2xl cursor-pointer mr-1 star-label"
                                data-value="<?= $i ?>">
                                <span class="text-gray-400 peer-checked/rate-<?= $i ?>:text-yellow-400">★</span>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label for="review" class="block text-white font-medium mb-2">Comentário</label>
                <textarea id="review" name="review" rows="15"
                    class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="O que você achou deste filme?"></textarea>
            </div>

            <div class="flex justify-end gap-4">
                <a href="/movie?movie-id=<?= $movie->id ?>"
                    class="px-4 py-2 border border-gray-600 text-gray-300 rounded-lg hover:bg-gray-700 transition">
                    Cancelar
                </a>
                <button type="submit" name="review-movie"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                    Enviar Avaliação
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const starLabels = document.querySelectorAll('.star-label');
            const ratingValue = document.getElementById('rating-value');

            starLabels.forEach(label => {
                // Hover
                label.addEventListener('mouseover', function() {
                    const value = parseInt(this.getAttribute('data-value'));
                    highlightStars(value);
                });

                // Click
                label.addEventListener('click', function() {
                    const value = parseInt(this.getAttribute('data-value'));
                    document.getElementById(`rate-${value}`).checked = true;
                    ratingValue.textContent = `${value}/5`;
                });
            });

            // Retorna ao valor selecionado quando o mouse se distancia
            document.getElementById('star-rating').addEventListener('mouseleave', function() {
                const checkedInput = document.querySelector('input[name="rate"]:checked');
                if (checkedInput) {
                    highlightStars(parseInt(checkedInput.value));
                }
            });

            function highlightStars(count) {
                starLabels.forEach(label => {
                    const starValue = parseInt(label.getAttribute('data-value'));
                    const star = label.querySelector('span');

                    if (starValue <= count) {
                        star.classList.add('text-yellow-400');
                        star.classList.remove('text-gray-400');
                    } else {
                        star.classList.add('text-gray-400');
                        star.classList.remove('text-yellow-400');
                    }
                });
            }

            // Valor padrão a ser inicializado
            highlightStars(3);
        });
    </script>