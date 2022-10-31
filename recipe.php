<?php 
$getResep = $_GET['key'];

// Url Api
$urlResep = "https://masak-apa-tomorisakura.vercel.app/api/recipe/".$getResep;
$urlKategori = "https://masak-apa-tomorisakura.vercel.app/api/category/recipes";
$urlKategoriArtikel = "https://masak-apa-tomorisakura.vercel.app/api/category/article";

// get content
$getContentsResep = file_get_contents($urlResep);
$getContentsKategori = file_get_contents($urlKategori);
$getContentsKategoriArtikel = file_get_contents($urlKategoriArtikel);

// Json Decode
$jsonDecodeResep = json_decode($getContentsResep, true);
$jsonDecodeKategori = json_decode($getContentsKategori , true);
$jsonDecodeKategoriArtikel = json_decode($getContentsKategoriArtikel , true);

// Mengubah Variabel Hasil
$rowResep = $jsonDecodeResep['results'];
$rowResepAuthor = $rowResep['author'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="image/Logo-foodies.png">
    <title>Foodies Recipes Website</title>
    <!-- style -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/lightslider.css">
    <!-- js -->
    <script src="js/JQuery3.3.1.js"></script>
    <script src="js/lightslider.js"></script>

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
    <main class="page">
        <div class="recipe-page">
            <section class="recipe-hero">
                <?php if($rowResep['thumb'] == null) {?>
                    <img src="image/load.png" class="img recipe-hero-img">
                <?php }else{ ?>
                    <img src="<?= $rowResep['thumb'] ?>" class="img recipe-hero-img">
                <?php }; ?>
                <article class="recipe-info">
                    <h2><?= $rowResep['title']; ?></h2>
                    <p class="sub-head"><?= $rowResep['desc']; ?></p>
                        <div class="recipe-icon">
                            <article>
                                <i class="fas fa-concierge-bell"></i>
                                <h5>Penyajian</h5>
                                <?php if(isset($rowResep['servings'])){ ?>
                                    <p><?= $rowResep['servings']; ?></p>
                                <?php }else{ ?>
                                    <p>-</p>
                                <?php } ?>
                            </article>
                            <article>
                                <i class="fas fa-hourglass-half"></i>
                                <h5>Waktu Pembuatan</h5>
                                <?php if(isset($rowResep['times'])){ ?>
                                    <p><?= $rowResep['times']; ?></p>
                                <?php }else{ ?>
                                    <p>-</p>
                                <?php } ?>
                            </article>
                            <article>
                                <i class="fas fa-poll"></i>
                                <h5>Tingkat Kesulitan</h5>
                                <?php if(isset($rowResep['difficulty'])){ ?>
                                    <p><?= $rowResep['difficulty']; ?></p>
                                <?php }else{ ?>
                                    <p>-</p>
                                <?php } ?>
                            </article>
                        </div>
                        <p class="recipe-tags">
                            <span class="author">Author : <?= $rowResepAuthor['user']; ?></span>
                            <span class="date-publish">Tanggal Publish : <?= $rowResepAuthor['datePublished']; ?></span>
                        </p>
                </article>
            </section>
            <section class="recipe-content">
                <article>
                    <h4>Instruksi Pembuatan</h4>
                    <div class="single-instruction">
                        <?php foreach ($rowResep['step'] as $row) { ?>
                            <p>
                                <?= $row; ?>
                            </p>
                        <?php } ?>
                    </div>
                </article>
                <article class="second-column">
                    <div>
                        <h4>Ingredients / Bahan</h4>
                        <?php foreach ($rowResep['ingredient'] as $row) { ?>
                            <p class="single-ingredient"><?= $row; ?></p>
                        <?php } ?>
                    </div>
                    <div>
                        <h4>Bahan Tambahan</h4>
                        <?php foreach ($rowResep['needItem'] as $row) { ?>
                            <p class="single-tool"><?= $row['item_name']; ?></p>
                        <?php } ?>
                    </div>
                </article>
            </section>
        </div>
    </main>
</body>
</html>

