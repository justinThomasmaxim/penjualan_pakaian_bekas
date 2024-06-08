<?php 

require 'session/session.php';
require 'functions/function.php';

$id_pengguna = $_SESSION['id_pengguna'];

$subTotal = $_GET['total_pembayaran'];
$selected_items = $_GET['selected_items'];

$total_keseluruhan = 0;

if (isset($_POST['konfirmasi'])) {

    // if (tambahTransaksi($subTotal) > 0) {
    if (tambahTransaksi($total_keseluruhan) > 0) {

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
                    <a href="checkout.php?selected_items=<?= $selected_items?>">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h2>Kembali</h2>
                </div>
                <p>Bayar Sekarang</p>
                <div class="total-pembayaran">
                    <p>Total yang harus dibayarkan</p>
                    <?php 
                    $angka = $subTotal;
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