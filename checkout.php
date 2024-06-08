<?php 

require 'session/session.php';
require 'functions/function.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>keranjang</title>

    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />

    <!-- FILE CSS -->
    <link rel="stylesheet" href="styles/checkout.css">

</head>

<body>
    <div class="header">
        <h1>Checkout</h1>
        <h3>
            <a href="index.php">
                Beranda
            </a> /
            <a href="keranjang.php">
                Keranjang
            </a> /
            <span>
                Checkout
            </span>
        </h3>
    </div>


    <main>
        <?php 
        $subTotal = 0;
        
        ?>

        <div class="card-alamat">
            <h3>Alamat Pengiriman</h3>
            <a href="alamat.php?selected_items=<?= $_GET['selected_items']?>"><button id="btn-tambah-alamat">Tambahkan Alamat</button></a>
        </div>
        <div class="barang-pembelian">
            <h3>Barang yang dibeli</h3>
            <div class="header-table">
                <h1 class="barang">Barang</h1>
                <h1 class="harga">Harga</h1>
                <h1 class="jumlah">Jumlah</h1>
                <h1 class="total">Total</h1>
            </div>
            <?php 
            if(isset($_GET['selected_items'])) :
                // Ambil nilai parameter selected_items
                $selectedItems = $_GET['selected_items'];

                echo $selectedItems;
            
                // Pisahkan nilai menjadi array
                $selectedItemsArray = explode(',', $selectedItems);
                
            ?>
            <div class="body-table">
                <?php  
                foreach($selectedItemsArray as $item) :
                    $query = "SELECT k.id_keranjang, k.id_barang_bekas, b.image, b.nama_barang, k.jumlah, b.harga FROM keranjang AS k
                    INNER JOIN barang_bekas AS b ON (k.id_barang_bekas = b.id_barang_bekas)
                    WHERE k.id_keranjang = '$item'";

                    $result = mysqli_query($conn, $query);

                    $row = mysqli_fetch_assoc($result);

                ?>  
                <div class="body">
                    <div class="image-barang barang">
                        <img src="images/<?= $row['image'] ?>">
                        <p><?= $row['nama_barang'] ?></p>
                    </div>
                    <div class="vertikal">
                        <?php
                        $angka = $row['harga'];
                        $format_uang = number_format($angka, 0, ',', '.');

                        ?>
                        <p class="harga">Rp. <?= $format_uang ?></p>
                    </div>
                    <div class="vertikal">
                        <p class="jumlah"><?= $row['jumlah'] ?></p>
                    </div>
                    <div class="vertikal">
                        <?php 
                        $total_harga = $row['harga'] * $row['jumlah'];

                        $subTotal += $total_harga;

                        $angka1 = $total_harga;
                        $format_uang1 = number_format($angka1, 0, ',', '.');

                        ?>
                        <p class="total">Rp. <?= $format_uang1?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
                <p>Tidak ada barang yang dipilih.</p>
            <?php endif; ?>

        </div>
        <div class="bayar">
            <form action="pembayaran_dari_keranjang.php">
                <p>Dengan melanjutkan, Saya setuju dengan Syarat & ketentuan yang berlaku</p>

                <input type="hidden" name="selected_items" value="<?= $_GET['selected_items']; ?>">
                <input type="hidden" name="total_pembayaran" value="<?= $subTotal ?>">

                <button id="btn-bayar">Bayar</button>
            </form>
        </div>
    </main>


</body>

</html>