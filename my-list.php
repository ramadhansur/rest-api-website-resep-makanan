<?php 
$getCategory = $_GET['key'];

// Url Api
$urlKategoriCotent = "https://masak-apa-tomorisakura.vercel.app/api/category/article/".$getCategory;
$urlKategori = "https://masak-apa-tomorisakura.vercel.app/api/category/recipes";
$urlKategoriArtikel = "https://masak-apa-tomorisakura.vercel.app/api/category/article";

// get content
$getContentsCategory = file_get_contents($urlKategoriCotent);
$getContentsKategori = file_get_contents($urlKategori);
$getContentsKategoriArtikel = file_get_contents($urlKategoriArtikel);

// Json Decode
$jsonDecodeCategory = json_decode($getContentsCategory, true);
$jsonDecodeKategori = json_decode($getContentsKategori , true);
$jsonDecodeKategoriArtikel = json_decode($getContentsKategoriArtikel , true);

?>

<!DOCTYPE html>
<html lang="en">
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
            <li><a href="index.php">Home</a></li>
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

    <section class="article-list">
        <h2>Artikel Hari Ini</h2>
        <div class="artikel-container">
            <?php foreach ($jsonDecodeCategory['results'] as $row) {
                $urlArtikelRow = "https://masak-apa-tomorisakura.vercel.app/api/article/".$getCategory."/".$row['key'];
                $getContentsArtikelRow = file_get_contents($urlArtikelRow);
                $jsonDecodeArtikelRow = json_decode($getContentsArtikelRow, true);
                $ArtikelRow = $jsonDecodeArtikelRow['results'];
            ?>
                <div class="article-listing">
                    <div class="artikel-bx">
                        <div class="artikel-poster">
                            <img src="<?= $ArtikelRow['thumb']; ?>" alt="">
                        </div>
                        <div class="artikel-texting">
                            <h3 class="title-head"><?= $ArtikelRow['title']; ?></h3>
                            <h4 class="author-sub"><?= $ArtikelRow['author']; ?></h4>
                            <p class="pub-sub"><?= $ArtikelRow['date_published']; ?></p>
                            <a href="article.php?key=<?= $row['key']; ?>&tag=<?= $getCategory; ?>">Selangkapnya</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

</body>
</html>