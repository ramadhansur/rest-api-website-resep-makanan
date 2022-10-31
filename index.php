<?php 
// Url Api
$urlSarapan = "https://masak-apa-tomorisakura.vercel.app/api/category/recipes/sarapan";
$urlHariRaya = "https://masak-apa-tomorisakura.vercel.app/api/category/recipes/masakan-hari-raya";
$urlKategori = "https://masak-apa-tomorisakura.vercel.app/api/category/recipes";
$urlKategoriArtikel = "https://masak-apa-tomorisakura.vercel.app/api/category/article";
$urlRekomendasi = "https://masak-apa-tomorisakura.vercel.app/api/recipes-length/?limit=4";

// get content
$getContentsSarapan = file_get_contents($urlSarapan);
$getContentsHariRaya = file_get_contents($urlHariRaya);
$getContentsKategori = file_get_contents($urlKategori);
$getContentsKategoriArtikel = file_get_contents($urlKategoriArtikel);
$getContentsRekomendasi = file_get_contents($urlRekomendasi);

// Json Decode
$jsonDecodeSarapan = json_decode($getContentsSarapan , true);
$jsonDecodeHariRaya = json_decode($getContentsHariRaya , true);
$jsonDecodeKategori = json_decode($getContentsKategori , true);
$jsonDecodeKategoriArtikel = json_decode($getContentsKategoriArtikel , true);
$jsonDecodeRekomendasi = json_decode($getContentsRekomendasi , true);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodies Recipes Website</title>
    <!-- style -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/lightslider.css">
    <!-- js -->
    <script src="js/JQuery3.3.1.js"></script>
    <script src="js/lightslider.js"></script>

    <link rel="shortcut icon" href="image/Logo-foodies.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- navigasi -->
    <nav>
        <a href="index.php" class="logo">
            <img src="image/logo-navfood.png">
        </a>
        <input type="checkbox" class="menu-btn" id="menu-btn">
        <label class="menu-icon" for="menu-btn">
            <span class="nav-icon"></span>
        </label>
        <ul class="menu">
            <li><a href="#">Home</a></li>
            <li><a href="#">Category</a>
                <ul class="menu-2">
                    <?php foreach ($jsonDecodeKategori['results'] as $row) {
                    ?>
                    <li><a href="category.php?key=<?= $row['key']; ?>"><?= $row['category']; ?></a></li>
                    <?php } ?>
                </ul>
            </li>
            <li><a href="#">Article</a>
                <ul class="menu-3">
                    <?php foreach ($jsonDecodeKategoriArtikel['results'] as $row) {
                    ?>
                        <li><a href="my-list.php?key=<?= $row['key']; ?>"><?= $row['title']; ?></a></li>
                    <?php } ?>
                </ul>
            </li>
        </ul>
        <form action="search.php" method="get">
            <div class="search">
                <input type="text" placeholder="Lapar ya? cari kenyang disini" name="search">
                <button type="submit" hidden></button>
                <i class="fas fa-search"></i>
            </div>
        </form>
    </nav>

    <section id="main" class="main">
        <!-- Top Chart -->
        <h1 class="topchart-head">Hidangan nikmat untuk sarapan</h1>

        <ul id="autoWidth" class="cs-hidden">
            <?php foreach ($jsonDecodeSarapan['results'] as $row) {
            ?>
            <a href="recipe.php?key=<?= $row['key'] ?>">
                <li class="item-a">
                    <div class="topchart-bx">
                        <h5 class="food-title"><?= $row['title'] ?></h5>
                        <img src="<?= $row['thumb'] ?>" alt="">
                    </div>
                </li>
            </a>
            <?php } ?>
        </ul>
    </section>

    <section id="most-populer" class="most-populer">
        <h2 class="populer">Nikmat di Hari Raya</h2>
        <ul id="autoWidth2" class="cs-hidden">
            <?php foreach ($jsonDecodeHariRaya['results'] as $row) {
            ?>
            <a href="recipe.php?key=<?= $row['key'] ?>">
                <li class="item-a">
                    <div class="populer-bx">
                        <div class="populer-poster">
                            <img src="<?= $row['thumb'] ?>" alt="<?= $row['title'] ?>">
                        </div>
                        <div class="populer-text">
                            <strong><?= $row['title'] ?></strong>
                            <p>Waktu Memasak : <?= $row['times'] ?></p>
                        </div>
                    </div>
                </li>
            </a>
            <?php } ?>
        </ul>
    </section>

    <div class="all-tracks-head">
        <h2>Rekomendasi</h2>
    </div>
    <section id="all-tracks" class="all-tracks">
        <?php foreach ($jsonDecodeRekomendasi['results'] as $row) {
        ?>
            <a href="recipe.php?key=<?= $row['key'] ?>" class="tracks-bx">
                <div class="tracks-img">
                    <img src="<?= $row['thumb'] ?>" alt="<?= $row['title'] ?>">
                </div>
                <div class="tracks-sub">
                    <h3><?= $row['title'] ?></h3>
                    <p class="artist">Lama Memasak : <?= $row['times'] ?></p>
                    <p class="album"><?= $row['serving'] ?></p>
                    <p class="realesed">Kesulitan : <?= $row['difficulty'] ?></p>
                </div>
            </a>
        <?php } ?>
    </section>

    <div class="tombol">
        <a href="rekomendasi.php">Lihat Lainnya...</a>
    </div>


    <script>
        $(document).ready(function () {
            $('#autoWidth, #autoWidth2').lightSlider({
                autoWidth: true,
                loop: true,
                onSliderLoad: function () {
                    $('#autoWidth, #autoWidth2').removeClass('cS-hidden');
                }
            });
        });
    </script>
</body>

</html>