<form action="" class="">
    <input type="text" name="search"
        class=""
        placeholder="Pesquisar..." />
    <button type="submit">Pesquisar</button>
</form>
<section class="">
    <?php foreach ($movies as $movie): ?>
                <div class=""><a href="#"><img src="#" alt="">movie poster</a></div>
    <?php endforeach; ?>
</section>