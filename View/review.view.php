<div class="max-w-6xl mx-auto flex flex-col md:flex-row gap-8">
    <!-- Seção do Filme (lado esquerdo) -->
    <div class="md:w-1/3">
        <div class="sticky top-4">
            <img src="<?= htmlspecialchars($movie->poster) ?>" 
                 alt="<?= htmlspecialchars($movie->title) ?>" 
                 class="w-full rounded-lg shadow-xl mb-4">
            <h2 class="text-2xl font-bold text-white"><?= htmlspecialchars($movie->title) ?></h2>
            <p class="text-gray-300"><?= htmlspecialchars($movie->year) ?></p>
            
            <?php if (isset($review) && $review->rate): ?>
                <div class="mt-4">
                    <span class="text-yellow-400 text-lg">
                        Sua avaliação atual: <?= str_repeat('★', $review->rate) . str_repeat('☆', 5 - $review->rate) ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Seção do Formulário (lado direito) -->
    <div class="md:w-2/3">
        <form action="/review" method="POST" class="bg-slate-800 p-6 rounded-lg">
            <?php if (isset($review)): ?>
                <input type="hidden" name="review-id" value="<?= $review->id ?>">
            <?php endif; ?>
            <input type="hidden" name="movie-id" value="<?= $movie->id ?>">

            <h1 class="text-2xl font-bold text-blue-400 mb-6">
                <?= isset($review) ? 'Editar Avaliação' : 'Sua Avaliação' ?>
            </h1>

            <div class="flex items-center justify-between mb-6">
                <label class="text-white font-medium">Sua nota:</label>
                <div class="flex items-center">
                    <div class="flex" id="star-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <input type="radio" id="rate-<?= $i ?>" name="rate" value="<?= $i ?>"
                                class="hidden peer/rate-<?= $i ?>" 
                                <?= (isset($review) && $i == $review->rate) || (!isset($review) && $i == 3) ? 'checked' : '' ?>>
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
                <textarea id="review" name="review" rows="12"
                    class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="O que você achou deste filme?"
                    ><?= isset($review) ? htmlspecialchars($review->review) : '' ?></textarea>
            </div>

            <div class="flex justify-between items-center">
                <?php if (isset($review)): ?>
                    <form action="/review" method="POST">
                        <input type="hidden" name="review-id" value="<?= $review->id ?>">
                        <button type="submit" name="delete-review"
                                class="text-red-500 hover:text-red-400 font-medium flex items-center"
                                onclick="return confirm('Tem certeza que deseja excluir esta review permanentemente?')">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Excluir Review
                        </button>
                    </form>
                <?php else: ?>
                    <div></div> <!-- Espaçador vazio para alinhamento -->
                <?php endif; ?>

                <div class="space-x-4">
                    <a href="/movie?movie-id=<?= $movie->id ?>"
                       class="px-4 py-2 border border-gray-600 text-gray-300 rounded-lg hover:bg-gray-700 transition">
                        Cancelar
                    </a>
                    <button type="submit" name="<?= isset($review) ? 'edit-review' : 'review-movie' ?>"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                        <?= isset($review) ? 'Salvar Alterações' : 'Enviar Avaliação' ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const starLabels = document.querySelectorAll('.star-label');
    const ratingValue = document.getElementById('rating-value');

    starLabels.forEach(label => {
        label.addEventListener('mouseover', function() {
            const value = parseInt(this.getAttribute('data-value'));
            highlightStars(value);
        });
        
        label.addEventListener('click', function() {
            const value = parseInt(this.getAttribute('data-value'));
            document.getElementById(`rate-${value}`).checked = true;
            ratingValue.textContent = `${value}/5`;
        });
    });
    
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
    
    // Inicializa a nota padrão ou do usuário, se houver
    highlightStars(<?= isset($review) ? $review->rate : 3 ?>);
});
</script>