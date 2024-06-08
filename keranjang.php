<?php 

require 'session/session.php';
require 'functions/function.php';

$id_pengguna = $_SESSION["id_pengguna"];

$query = "SELECT k.id_keranjang, k.id_barang_bekas, b.image, b.nama_barang, k.jumlah, b.harga FROM keranjang AS k
INNER JOIN barang_bekas AS b ON (k.id_barang_bekas = b.id_barang_bekas) WHERE k.id_pengguna = '$id_pengguna'";

$keranjang   = query($query);

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
    <link rel="stylesheet" href="styles/keranjang.css">

</head>

<body>
    <div class="header">
        <h1>Keranjang</h1>
        <h3>
            <a href="index.php">
                Beranda
            </a> /
            <span>
                Keranjang
            </span>
        </h3>
    </div>

    <main>
        <div class="header-table">
            <h1 class="barang">Barang</h1>
            <h1 class="jumlah">Jumlah</h1>
            <h1 class="harga">Harga</h1>
            <h1 class="aksi">Aksi</h1>
        </div>
        <div class="body-table">
            <?php foreach($keranjang as $data): ?>
            <div class="body">
                <div class="image-barang barang">
                    <input type="checkbox" name="checkbox-barang" value="<?= $data['id_keranjang']?>">
                    <img src="images/<?= $data['image']?>">
                    <p><?= $data['nama_barang']?></p>
                </div>
                <div class="vertikal">
                    <p class="jumlah"><?= $data['jumlah']?></p>
                </div>
                <div class="vertikal">
                    <?php 
                    $angka = $data['harga'];
                    $format_uang = number_format($angka, 0, ',', '.');
                    
                    ?>
                    <p class="harga">Rp. <?= $format_uang ?></p>
                </div>
                <div class="update-delete-barang">
                    <!-- <form action="">
                        <button name="ubah">Ubah</button>
                    </form>
                    <form action="">
                        <button name="hapus">Hapus</button>
                    </form> -->
                    <div class="border ubah">
                        <a href="update_barang.php?id_keranjang=<?= $data['id_keranjang']?>">Ubah</a>

                    </div>
                    <div class="border hapus">
                        <a href="hapus_barang.php?id_keranjang=<?= $data['id_keranjang']?>" onclick="return confirm('Yakin ingin menghapus barang pada keranjang');">Hapus</a>

                    </div>
                </div>
            </div>        
            <?php endforeach; ?>
            
        </div>
        <div class="button-pembelian">
            <!-- <a href="checkout.php">Checkout</a> -->
            <button onclick="handleCheckout()">Checkout</button>
        </div>
    </main>

    <script>
    function handleCheckout() {
        var checkboxes = document.getElementsByName('checkbox-barang');
        var selectedItems = [];

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selectedItems.push(checkboxes[i].value);
            }
        }

        var checkoutUrl = 'checkout.php?selected_items=' + selectedItems.join(',');
        window.location.href = checkoutUrl;
    }
    </script>



</body>

</html>