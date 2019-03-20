<?php
session_start();
require_once 'functions/database_functions.php';
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prodavnica mobilnih telefona - Pocetna</title>
    <link rel="stylesheet" href="cssmenu/style.css">
    <link rel="stylesheet" type="text/css" href="cssmenu/styleGallery.css">
</head>
<body>
<?php require_once "header.php"; ?>

<?php
$imagesTotal = 5;
?>

<div class="galleryContainer">
    <div class="galleryPreviewContainer">
        <div class="galleryPreviewImage">
            <?php
            for ($j = 1; $j <= $imagesTotal; $j++) {
                echo '<img class="previewImage' . $j . '" src="img/gallery/img' . $j . '.jpg" width="auto" height="370" alt="">';
            }
            ?>
        </div>
    </div>
    <div class="galleryNavigationBullets">
        <?php
        for ($k = 1; $k <= $imagesTotal; $k++) {
            echo '<a href="javascript: changeimage(' . $k . ')" class="galleryBullet' . $k . '"><span>Bullet</span></a>';
        }
        ?>
    </div>
</div>
<h3>Izaberi najnovije</h3>
<div id="latestPro">
    <?php
    poslednjiPro();
    ?>
</div>
<br>
<div id="brands">
    <img src="img/brands/brand1.png">
    <img src="img/brands/brand2.png">
    <img src="img/brands/brand3.png">
    <img src="img/brands/brand4.png">
    <img src="img/brands/brand5.png">
    <img src="img/brands/brand6.png">
</div>
<?php require_once "footer.php"; ?>
<?php if (isset($_SESSION['idKor'])) { ?>
    <script src="js/jquery-3.1.1.js"></script>
    <script>
        var imageTotal =<?php echo $imagesTotal; ?>;
        var currentImage = 1;

        $('a.galleryBullet' + currentImage).addClass("active");


        function changeimage(imageNumber) {
            $('img.previewImage' + currentImage).hide();
            currentImage = imageNumber;
            $('img.previewImage' + currentImage).show();
            $('.galleryNavigationBullets a').removeClass("active");
            $('a.galleryBullet' + currentImage).addClass("active");
        }
        function autoChangeSlider() {
            $('img.previewImage' + currentImage).hide();
            $('a.galleryBullet' + currentImage).removeClass("active");

            currentImage++;

            if (currentImage == imageTotal + 1) {
                currentImage = 1;
            }

            $('a.galleryBullet' + currentImage).addClass("active");
            $('img.previewImage' + currentImage).show();

        }
        var slideTimer = setInterval(function () {
            autoChangeSlider();
        }, 5000);

        $(document).on('click', '.dodajUKorpu', function () {
            var idPro = $(this).attr("data-korpa");
            var idKor = <?php echo $_SESSION['idKor']; ?>;
            $.get("functions/funkcije.php?dodajUKorpu=true", {
                idPro: idPro,
                idKor: idKor
            }).done(function (odgovor) {
                if (odgovor = 'true') {
                    $('.korpa').load(location.href + ' .korpa>*', '');
                    /*alert('Proizvod je dodat u korpu!');
                    location.reload();*/
                }
                else {
                    alert('Greška pri dodavanju proizvoda u korpu!');
                    return false;
                }
            });
        });
    </script>
<?php } else { ?>
    <script src="js/jquery-3.1.1.js"></script>
    <script>
        var imageTotal =<?php echo $imagesTotal; ?>;
        var currentImage = 1;

        $('a.galleryBullet' + currentImage).addClass("active");


        function changeimage(imageNumber) {
            $('img.previewImage' + currentImage).hide();
            currentImage = imageNumber;
            $('img.previewImage' + currentImage).show();
            $('.galleryNavigationBullets a').removeClass("active");
            $('a.galleryBullet' + currentImage).addClass("active");
        }
        function autoChangeSlider() {
            $('img.previewImage' + currentImage).hide();
            $('a.galleryBullet' + currentImage).removeClass("active");

            currentImage++;

            if (currentImage == imageTotal + 1) {
                currentImage = 1;
            }

            $('a.galleryBullet' + currentImage).addClass("active");
            $('img.previewImage' + currentImage).show();

        }
        var slideTimer = setInterval(function () {
            autoChangeSlider();
        }, 5000);
    </script>
<?php } ?>
</body>
</html>