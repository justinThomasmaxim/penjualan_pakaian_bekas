<?php 

require 'session/session.php';
require 'functions/function.php';

$nama_barang = $_GET['nama_barang'];
$jumlah      = $_GET['jumlah'];

$query  = "SELECT * FROM barang_bekas WHERE nama_barang LIKE '%$nama_barang%' LIMIT 1";
$query1 = query("SELECT CekHarga('$nama_barang', '$jumlah  ') AS Total_Harga");

$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

// $harga = $row['harga'];
// $total_harga = $harga * $jumlah;

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
    <link rel="stylesheet" href="styles/cek_harga.css" />
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
            <?php 
            if (mysqli_num_rows($result) > 0) : ?>
            <div class="infromation">
                <h1>Harga Barang</h1>
                <div class="kotak"><h2>Nama Barang   : <?= $nama_barang ?></h2></div>
                <div class="kotak"><h2>Jumlah      : <?= $jumlah ?></h2></div>
               
                <?php foreach ($query1 as $total_harga) : 
                $angka1 = $total_harga['Total_Harga'];
                $format_uang1 = number_format($angka1, 0, ',', '.');
                    
                ?>
                <div class="kotak"><h2>Total Harga : Rp. <?= $format_uang1 ?></h2></div>
                <?php endforeach; ?>
            </div>
            <?php else : ?>
            <div class="infromation">
                <h1>Barang yang dicek tidak ada</h1>
            </div>
            <?php endif; ?>
        </div>
    </div>


</body>

</html>