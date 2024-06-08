<?php 

require 'session/session.php';
require 'functions/function.php';

$id_pengguna = $_SESSION['id_pengguna'];

$id_barang_bekas = $_GET['id_barang_bekas'];
$jumlah = $_GET['jumlah'];

$query = "SELECT * FROM barang_bekas WHERE id_barang_bekas = '$id_barang_bekas'";

$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

$harga = $row['harga'];

$total_harga = $jumlah * $harga;

if (isset($_POST['konfirmasi'])) {

    if (tambahTransaksi($total_harga) > 0) {

        $query1 = "SELECT id_transaksi FROM transaksi ORDER BY id_transaksi DESC LIMIT 1";
        $result = mysqli_query($conn, $query1);
        $row = mysqli_fetch_assoc($result);
        $id_transaksi = $row['id_transaksi'];
    
        if (tambahPembelianBarangLangsung($id_transaksi, $id_pengguna, $id_barang_bekas, $jumlah) > 0) {
            echo "
                <script>
                    alert('Pembayaran selesai');
                    document.location.href = 'index.php';
                </script>
            ";
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>keranjang</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

    <!-- FILE CSS -->
    <link rel="stylesheet" href="styles/pembayaran.css">

</head>

<body>
    <section class="container-pembayaran">
        <div class="pembayaran">
            <div class="content">
                <div class="icon-back">
                    <a href="tambah_barang.php?id_barang_bekas=<?= $id_barang_bekas?>">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h2>Kembali</h2>
                </div>
                <p>Bayar Sekarang</p>
                <div class="total-pembayaran">
                    <p>Total yang harus dibayarkan</p>
                    <?php 
                    $angka = $total_harga;
                    $format_uang = number_format($angka, 0, ',', '.');

                    ?>

                    <span>Rp. <?= $format_uang ?></span>
                </div>

                <div class="btn-pembayaran">
                    <form action="" method="post">
                        <button type="submit" name="konfirmasi">Konfirmasi</button>
                    </form>
                    <p>Laman ini akan otomatis tertutup saat pembayaran di konfirmasi</p>
                </div>
            </div>
    </section>


</body>

</html>