<?php 
$getSearch = $_GET['search'];

// Url Api
$urlSearch = "https://masak-apa-tomorisakura.vercel.app/api/search/?q=".urlencode($getSearch);
$urlKategori = "https://masak-apa-tomorisakura.vercel.app/api/category/recipes";
$urlKategoriArtikel = "https://masak-apa-tomorisakura.vercel.app/api/category/article";

// get content
$getContentsSearch = file_get_contents($urlSearch);
$getContentsKategori = file_get_contents($urlKategori);
$getContentsKategoriArtikel = file_get_contents($urlKategoriArtikel);

// Json Decode
$jsonDecodeSearch = json_decode($getContentsSearch, true);
$jsonDecodeKategori = json_decode($getContentsKategori , true);
$jsonDecodeKategoriArtikel = json_decode($getContentsKategoriArtikel , true);

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

    <div class="all-tracks-head" style="margin-top: 100px;">
        <h2>Search "<?php echo urldecode($getSearch); ?>"</h2>
    </div>
    <section id="all-tracks" class="all-tracks">
        <?php foreach ($jsonDecodeSearch['results'] as $row) {
        ?>
            <a href="" class="tracks-bx">
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