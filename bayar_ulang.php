<?php 

require 'session/session.php';
require 'functions/function.php';

$id_pengguna = $_SESSION['id_pengguna'];

$id_pembelian = $_GET['id_pembelian'];
$jumlah       = $_GET['jumlah'];

$daftar_pembelian_barang = query("SELECT * FROM daftar_pembelian_barang WHERE id_pembelian = '$id_pembelian'");

if (isset($_POST['konfirmasi'])) {

    if (tambahTransaksi($subTotal) > 0) {

        $query1 = "SELECT id_transaksi FROM transaksi ORDER BY id_transaksi DESC LIMIT 1";
        $result = mysqli_query($conn, $query1);
        $row = mysqli_fetch_assoc($result);
        $id_transaksi = $row['id_transaksi'];
    
        if (tambahPembelianBarangDariKeranjang($selected_items, $id_transaksi, $id_pengguna) > 0) {
            echo "
                <script>
                    alert('Pembayaran selesai');
                    document.location.href = 'index.php';
                </script>
            ";
        }

    }
}

if (isset($_POST['bayar_tambahan'])) {
    // echo "bayar_tambahan";
    if (ubahJumlahBeli($_GET) > 0) {
        echo "
            <script>
                alert('Pembayaran tambahan selesai');
                document.location.href = 'index.php';
            </script>
        ";
    }

} elseif (isset($_POST['pengembalian']))
    // echo "pengembalian";
    if (ubahJumlahBeli($_GET) > 0) {
        echo "
            <script>
                alert('Pengembalian uang selesai');
                document.location.href = 'index.php';
            </script>
        ";
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
                    <a href="ubah_jumlah_beli.php?id_pembelian=<?= $id_pembelian?>">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h2>Kembali</h2>
                </div>
                <?php foreach ($daftar_pembelian_barang as $dpb) :?>
                    
                    <!-- Membayar uang tambahan -->
                    <?php if ($jumlah > $dpb['jumlah']) :?>
                        <?php 
                        $sisa_jumlah = $jumlah - $dpb['jumlah'];
                        $subtotal = $dpb['harga'] * $sisa_jumlah;
                        
                        ?>
                        <p>Bayar Sekarang</p>
                        <div class="total-pembayaran">
                            <p>Bayaran Tambahan</p>
                            <?php 
                            $angka = $subtotal;
                            $format_uang = number_format($angka, 0, ',', '.');

                            ?>

                            <span>Rp. <?= $format_uang ?></span>
                        </div>

                        <div class="btn-pembayaran">
                            <form action="" method="post">
                                <button type="submit" name="bayar_tambahan">Konfirmasi</button>
                            </form>
                            <p>Laman ini akan otomatis tertutup saat pembayaran di konfirmasi</p>
                        </div>

                    <!-- pengembalian uang -->
                    <?php else : ?>
                        <?php 
                        $sisa_jumlah = $dpb['jumlah'] - $jumlah;
                        $subtotal = $dpb['harga'] * $sisa_jumlah;
                        
                        ?>
                        <p>Proses Pengembalian</p>
                        <div class="total-pembayaran">
                            <p>Pengembalian Uang</p>
                            <?php 
                            $angka = $subtotal;
                            $format_uang = number_format($angka, 0, ',', '.');

                            ?>

                            <span>Rp. <?= $format_uang ?></span>
                        </div>

                        <div class="btn-pembayaran">
                            <form action="" method="post">
                                <button type="submit" name="pengembalian">Konfirmasi</button>
                            </form>
                            <p>Laman ini akan otomatis tertutup saat pembayaran di konfirmasi</p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
    </section>


</body>

</html>