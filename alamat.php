<?php

require 'session/session.php';
require 'functions/function.php';

$id_pengguna = $_SESSION['id_pengguna'];

$selected_items = $_GET['selected_items'];

$query = "SELECT * FROM pelanggan WHERE id_pengguna = '$id_pengguna'";

$result = mysqli_query($conn, $query);

// Memeriksa apakah hasil query tidak null sebelum mengambil nilainya
$pelanggan = mysqli_fetch_assoc($result);

if ($result && mysqli_num_rows($result) > 0) {
    if (isset($_POST['submit'])) {
        if (ubahPelanggan($_POST, $id_pengguna) > 0) {
            echo "
                <script>
                    alert('Alamat pengiriman berhasil diubah');

                    let selectedItems = '" . $selected_items . "';
                    document.location.href = 'checkout.php?selected_items=' + selectedItems;
                </script>
            ";
        }
    }

} else {
    $pelanggan['nama_pelanggan'] = '';
    $pelanggan['nomor_telepon']  = '';
    $pelanggan['alamat']         = '';

    if (isset($_POST['submit'])) {
        if (tambahPelanggan($_POST, $id_pengguna) > 0) {
            echo "
                <script>
                    alert('Alamat pengiriman berhasil ditambahkan');

                    let selectedItems = '" . $selected_items . "';
                    document.location.href = 'checkout.php?selected_items=' + selectedItems;
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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="styles/alamat.css">
    <title>Document</title>
</head>

<body>
    <div class="container-alamat">
        <div class="bg-alamat">
            <div class="icon-back">
                <a href="checkout.php?selected_items=<?= $selected_items?>">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h2>Kembali</h2>
            </div>
            <div class="title">
                <h2>Alamat Pengiriman</h2>
            </div>
            <div class="alamat">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" id="nama" name="nama_pelanggan" value="<?=$pelanggan['nama_pelanggan']?>" required>
                        <label for="no-telp">Nomor Telepon</label>
                        <input type="text" id="no-telp" name="nomor_telepon"  value="<?=$pelanggan['nomor_telepon']?>" required>
                        <label for="alamat">Alamat</label>
                        <input type="text" id="alamat" name="alamat"  value="<?=$pelanggan['alamat']?>" required>
                    </div>
                    <div class="simpan-alamat">
                        <button type="submit" name="submit">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    
</body>

</html>
