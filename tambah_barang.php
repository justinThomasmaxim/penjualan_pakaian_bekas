<?php 

require 'session/session.php';
require 'functions/function.php';

$id_pengguna = $_SESSION['id_pengguna'];

$id_barang_bekas = $_GET['id_barang_bekas'];

$barang_berdasarkan_id = "SELECT * FROM barang_bekas WHERE id_barang_bekas = '$id_barang_bekas'";

$result = mysqli_query($conn, $barang_berdasarkan_id);
 
$row = mysqli_fetch_assoc($result);

if (isset($_GET['keranjang'])) {
    if (tambahKeranjang($_GET, $id_pengguna)) {
        echo "
            <script>
                alert('Barang berhasil dimasukkan ke dalam keranjang');
                document.location.href = 'index.php';
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
                <a href="index.php">
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

                    <input type="number" id="jumlah" value="1" min="1">

                    <div class="button">
                        <form action="" method="get">
                            <input type="hidden" name="id_barang_bekas" value="<?= $id_barang_bekas?>">
                            <input type="hidden" name="jumlah" id="jumlah_dikeranjang">
                            <button class="keranjang" name="keranjang" onclick="addToCart()">
                                Masukan di Keranjang
                            </button>
                        </form>
                        
                        <form action="beli_sekarang.php" method="get">
                            <input type="hidden" name="id_barang_bekas" value="<?= $id_barang_bekas?>">
                            <input type="hidden" name="jumlah" id="jumlah_dibeli" value="1">
                            <button class="pembelian" name="pembelian" onclick="buyNow()">
                                Beli Sekarang
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

        function buyNow() {
            let jumlah = getInputValue();
            document.getElementById('jumlah_dibeli').value = jumlah;
            // console.log("Jumlah yang dibeli sekarang: " + jumlah);

        }
    </script>

</body>

</html>