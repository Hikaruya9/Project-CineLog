<div class="max-w-3xl mx-auto bg-slate-800 p-8 rounded-lg shadow-lg mt-12">
    <h2 class="text-3xl font-bold text-white mb-6 text-center">Cadastrar Novo Filme</h2>

    <form action="/movie-add" method="POST" enctype="multipart/form-data" class="space-y-6">
        <!-- Título -->
        <div>
            <label for="title" class="block text-slate-300 mb-2">Título</label>
            <input type="text" name="title"
                class="w-full px-4 py-2 rounded-md bg-slate-700 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Digite o título do filme" required>
        </div>

        <!-- Diretor -->
        <div>
            <label for="director" class="block text-slate-300 mb-2">Diretor</label>
            <input type="text" name="director"
                class="w-full px-4 py-2 rounded-md bg-slate-700 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Digite o nome do diretor" required>
        </div>

        <!-- Ano -->
        <div>
            <label for="year" class="block text-slate-300 mb-2">Ano</label>
            <input type="number" name="year" min="1880" max="2100"
                class="w-full px-4 py-2 rounded-md bg-slate-700 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Ex: 2024" required>
        </div>

        <!-- Gênero -->
        <div>
            <label for="genre" class="block text-slate-300 mb-2">Gênero</label>
            <input type="text" name="genre"
                class="w-full px-4 py-2 rounded-md bg-slate-700 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Ex: Ação, Drama, Comédia..." required>
        </div>

        <!-- Sinopse -->
        <div>
            <label for="synopsis" class="block text-slate-300 mb-2">Sinopse</label>
            <textarea name="synopsis" rows="4"
                class="w-full px-4 py-2 rounded-md bg-slate-700 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Digite a sinopse do filme" required></textarea>
        </div>

        <!-- Poster -->
        <div>
            <label for="poster" class="block text-slate-300 mb-2">Capa do filme</label>
            <input type="file" name="poster" accept="image/*"
                class="w-full px-4 py-2 rounded-md bg-slate-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-400 file:bg-slate-600 file:border-0 file:px-4 file:py-2 file:mr-4 file:text-white file:rounded-md"
                required>
        </div>

        <!-- Botão -->
        <div class="text-center">
            <button type="submit" name="add-movie"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded-md transition">
                Cadastrar Filme
            </button>
        </div>
    </form>
</div>