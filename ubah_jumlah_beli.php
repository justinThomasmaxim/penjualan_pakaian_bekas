<?php 

require 'session/session.php';
require 'functions/function.php';

$id_pembelian = $_GET['id_pembelian'];

$daftar_pembelian_barang = query("SELECT * FROM daftar_pembelian_barang WHERE id_pembelian = '$id_pembelian'");

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
                <a href="index.php">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h2>Kembali</h2>
            </div>
            <?php foreach($daftar_pembelian_barang as $dpb) : ?>
            <div class="img-deskripsi">
                <div class="img">
                    <img src="images/<?= $dpb['image'] ?>">
                </div>
                <div class="information">
                    <h1><?= $dpb['nama_barang'] ?></h1>
                    <p><?= $dpb['deskripsi'] ?></p>
                    <div class="terjual-harga">
                        <p><?= $dpb['terjual'] ?> terjual</p>
                        <?php
                        $angka = $dpb['harga'];
                        $format_uang = number_format($angka, 0, ',', '.');
                        ?>
                        <h2>Rp. <?= $format_uang ?> </h2>
                    </div>

                    <input type="number" id="jumlah" value="<?= $dpb['jumlah']?>" min="1">

                    <div class="button">
                        <form action="bayar_ulang.php" method="get">
                            <input type="hidden" name="id_pembelian" value="<?= $dpb['id_pembelian']?>">
                            <input type="hidden" name="jumlah" id="jumlah_dikeranjang">
                            <button onclick="addToCart()">
                               Ubah Jumlah Beli
                            </button>
                        </form>
                        
                    </div>

                </div>
            </div>
            <?php endforeach; ?>
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