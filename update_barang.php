<?php 

require 'session/session.php';
require 'functions/function.php';

$id_keranjang = $_GET['id_keranjang'];

$keranjang = "SELECT k.id_keranjang, k.id_barang_bekas, b.image, b.nama_barang, k.jumlah, b.harga, b.terjual, b.deskripsi FROM keranjang AS k
INNER JOIN barang_bekas AS b ON (k.id_barang_bekas = b.id_barang_bekas) WHERE id_keranjang = '$id_keranjang'";

$result = mysqli_query($conn, $keranjang);
 
$row = mysqli_fetch_assoc($result);

if (isset($_GET['keranjang'])) {
    if (updateKeranjang($_GET)) {
        echo "
            <script>
                alert('Barang pada keranjang berhasil diubah');
                document.location.href = 'keranjang.php';
            </script>
        ";
    }
} 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ThriftShopTZM</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="styles/barang.css" />
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="icon-back">
                <a href="keranjang.php">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h2>Kembali</h2>
            </div>
            <div class="img-deskripsi">
                <div class="img">
                    <img src="images/<?= $row['image'] ?>">
                </div>
                <div class="information">
                    <h1><?= $row['nama_barang'] ?></h1>
                    <p><?= $row['deskripsi'] ?></p>
                    <div class="terjual-harga">
                        <p><?= $row['terjual'] ?> terjual</p>
                        <?php
                        $angka = $row['harga'];
                        $format_uang = number_format($angka, 0, ',', '.');
                        ?>
                        <h2>Rp. <?= $format_uang ?> </h2>
                    </div>

                    <input type="number" id="jumlah" value="<?= $row['jumlah']?>" min="1">

                    <div class="button">
                        <form action="#" method="get">
                            <input type="hidden" name="id_keranjang" value="<?= $row['id_keranjang']?>">
                            <input type="hidden" name="jumlah" id="jumlah_dikeranjang">
                            <button class="keranjang" name="keranjang" onclick="addToCart()">
                               Ubah Jumlah Barang
                            </button>
                        </form>
                        
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function getInputValue() {
            return document.getElementById("jumlah").value;
        }

        function addToCart() {
            let jumlah = getInputValue();
            // console.log("Jumlah yang dimasukkan ke keranjang: " + jumlah);
            document.getElementById('jumlah_dikeranjang').value = jumlah;

        }

    </script>

</body>

</html>