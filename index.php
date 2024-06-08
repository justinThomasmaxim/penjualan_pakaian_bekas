<?php 

require 'session/session.php';
require 'functions/function.php';

$id_pengguna = $_SESSION["id_pengguna"];

$username           = "SELECT username FROM pengguna WHERE id_pengguna = '$id_pengguna'";
$barang             = query("SELECT * FROM barang_bekas");

// $query = "SELECT pb.id_barang_bekas, pb.id_pengguna, b.image, b.nama_barang, pb.jumlah, b.harga 
// FROM pembelian_barang_bekas AS pb
// INNER JOIN barang_bekas AS b ON (pb.id_barang_bekas = b.id_barang_bekas) 
// WHERE pb.id_pengguna = '$id_pengguna'";

$daftar_pembelian_barang = query("SELECT * FROM daftar_pembelian_barang WHERE id_pengguna = '$id_pengguna'");

$riwayat_transaksi       = query("SELECT * FROM riwayat_transaksi WHERE id_pengguna = '$id_pengguna'");

$result  = mysqli_query($conn, $username);

// $result1 = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

if (isset($_GET['jenis'])) {
    $barang = cariSesuaiJenis($_GET);
}

if (isset($_POST['logout'])) {
    $_SESSION = [];
    session_unset();
    session_destroy();

    header('Location: login.php');
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
    
    <!-- FILE CSS -->
    <link rel="stylesheet" href="styles/dataTables.css">
    <link rel="stylesheet" href="styles/style.css" />
</head>

<body>
    <div class="container">
        <nav>
            <div class="header">
                <h1>ThriftShop<span>TZM</span></h1>
            </div>
            <div class="nav-right">
                <div class="icon">
                    <i class="fa-solid fa-bars" id="bar-menu"></i>
                    <a href="keranjang.php">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                </div>
                <div class="button-dark-theme">
                    <i class="fa-solid fa-sun light"></i>
                    <i class="fa-solid fa-moon dark"></i>
                </div>
                <div class="profile" onclick="showProfile()">
                    <i class="fa-solid fa-user"></i>
                    <h1><?= $row['username'] ?></h1>
                </div>
            </div>
        </nav>

        <div id="profile" style="display: none">
            <div class="icon">
               <div class="icon-close" onclick="closeProfile()">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>
            <!-- <div class="border-icon">
                <div class="icon-logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </div>
                <h4>Logout dari akun</h4>
            </div> -->
            <form action="" method="post">
                <button name="logout">
                    <div class="icon-logout">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </div>
                    <h4>Logout dari akun</h4>
                </button>
            </form>
        </div>

        <!-- END NAVBAR -->
        <div class="sidebar">
            <ul>

                <!-- <a href="index.html?page=page_barang" class="item">
                    <i class="fa-solid fa-business-time"></i>
                    <li>Barang</li>
                </a>
                <a href="index.html?page=page_pembelian" class="item">
                    <i class="fa-solid fa-cash-register"></i>
                    <li>Pembelian</li>
                </a>
                <a href="index.html?page=page_cek_harga" class="item">
                    <i class="fa-solid fa-money-bill"></i>
                    <li>Cek Harga</li>
                </a> -->
                <div class="item active" onclick="setPageBarang()">
                    <i class="fa-solid fa-business-time"></i>
                    <li>Barang</li>
                </div>
                <div class="item" onclick="setPagePembelian()">
                    <i class="fa-solid fa-cash-register"></i>
                    <li>Pembelian</li>
                </div>
                <div class="item" onclick="setPageRiwayatTransaksi()">
                    <i class="fa-solid fa-money-check-dollar"></i>
                    <li>Riwayat Transaksi</li>
                </div>
                <div class="item" onclick="setPageCekHarga()">
                    <i class="fa-solid fa-money-bill"></i>
                    <li>Cek Harga</li>
                </div>
            </ul>
        </div>
        <!-- END SIDEBAR -->
        <main>
            <!-- HALAMAN BARANG -->
            <div id="page-barang" style="display: block;">
                <div class="header">
                    <h1>Barang </h1>
                </div>
                <div class="cards-category">
                    <h3>Kategori</h3>
                    <div class="kategori">
                        <div class="img" onclick="sendDataJenis('Jeans')">
                            <p>Jeans</p>
                        </div>
                        <div class="img" onclick="sendDataJenis('Cargo')">
                            <p>Cargo</p>
                        </div>
                        <div class="img" onclick="sendDataJenis('Shorts')">
                            <p>Shorts</p>
                        </div>
                    </div>
                </div>
                <div class="barang">
                    <?php foreach($barang as $products): ?>
                    <div class="card">
                        <a href="tambah_barang.php?id_barang_bekas=<?= $products['id_barang_bekas']?>">
                            <img src="images/<?= $products['image']?>">
                            <div class="information">
                                <p><?= $products['nama_barang']?></p>
                                <div class="harga-terjual">
                                    <?php
                                    $angka = $products['harga'];
                                    $format_uang = number_format($angka, 0, ',', '.');

                                    ?>
                                    <h4>Rp. <?= $format_uang ?></h3>
                                    <h6><?= $products['terjual']?> terjual</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- HALAMAN PEMBELIAN -->
            <div id="page-pembelian" style="display: none;">
                <div class="header">
                    <h1>Pembelian</h1>

                    <div class="body">
                        <div class="card-data-pembelian">
                            <h1>Data Pembelian Barang</h1>
                            <table id="dataTable">
                                <thead>
                                    <tr>
                                        <th><p>Image</p></th>
                                        <th><p>Nama Barang</p></th>
                                        <th><p>Harga</p></th>
                                        <th><p>Jumlah</p></th>
                                        <th><p>Total Harga</p></th>
                                        <th><p>Aksi</p></th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    <?php foreach ($daftar_pembelian_barang as $dpb) :?>
                                    <tr>
                                        <td><img src="images/<?= $dpb['image'] ?>"></td>
                                        <td><p class="nama-barang"><?= $dpb['nama_barang'] ?></p></td>
    
                                        <?php
                                        $angka1 = $dpb['harga'];
                                        $format_uang1 = number_format($angka1, 0, ',', '.');
    
                                        ?>
                                        <td><p class="harga">Rp.<?= $format_uang1?></p></td>
                                        <td><p class="jumlah"><?= $dpb['jumlah'] ?></p></td>
    
                                        <?php
                                        $angka2 = $dpb['harga'] * $dpb['jumlah'];
                                        $format_uang2 = number_format($angka2, 0, ',', '.');
    
                                        ?>
                                        <td><p class="total-harga">Rp. <?= $format_uang2?></p></td>
                                        <td>
                                            <div class="ubah-hapus">
                                                <a href="ubah_jumlah_beli.php?id_pembelian=<?= $dpb['id_pembelian'] ?>" alt="ubah">Ubah Jumlah Beli</a>
                                                <a href="Batal_pembelian.php?id_pembelian=<?= $dpb['id_pembelian'] ?>" 
                                                alt="hapus" onclick="return confirm('Yakin ingin membatalkan pembelian barang ini?')">Batalkan Pembelian</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="page-riwayat-transaksi" style="display: none">
                <div class="header">
                    <h1>Pembelian</h1>

                    <div class="body">
                        <div class="card-riwayat-transaksi">
                            <h1>Riwayat Transaksi</h1>
                            <table id="dataTable1">
                                <thead>
                                    <tr>
                                        <th><p>ID Transaksi</p></th>
                                        <th><p>Tanggal Transaksi</p></th>
                                        <th><p>Subtotal</p></th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    <?php foreach ($riwayat_transaksi as $rt) :?>
                                    <tr>
                                        <td><p class="nama-barang"><?= $rt['id_transaksi'] ?></p></td>
                                        <td><p class="nama-barang"><?= $rt['tanggal_transaksi'] ?></p></td>
                                        <?php
                                        $angka3 = $rt['subtotal'];
                                        $format_uang3 = number_format($angka3, 0, ',', '.');
    
                                        ?>
                                        <td><p class="harga">Rp. <?= $format_uang3?></p></td>
                                    </tr>
                                    <?php endforeach; ?>
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- HALAMAN CEK HARGA -->
            <div id="page-cek-harga" style="display: none;">
                <div class="header">
                    <h1>Cek Harga</h1>
                    <div class="card-cek-harga">
                        <form action="cek_harga.php" method="get">
                            <input type="text"   name="nama_barang" placeholder="Nama Barang" required>
                            <input type="number" name="jumlah" placeholder="Jumlah" required>
                            <button>Cek Harga</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    
        <!-- END MAIN -->
    </div>
    <!-- END CONTAINER -->

    <!-- datatables -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>

    <!-- FILE JS -->
    <script src="js/script.js"></script>

    <script>
        function sendDataJenis(data) {
            // Anda bisa mengarahkan pengguna ke URL dengan data yang ingin dikirimkan

            window.location.href = 'index.php?jenis=' + data;

        }

    </script>

    <script>
        
        function setPageBarang() {
            let pageBarang = document.getElementById('page-barang');
            let pagePembelian = document.getElementById('page-pembelian');
            let pageRiwayatTransaksi = document.getElementById('page-riwayat-transaksi');
            let pageCekHarga = document.getElementById('page-cek-harga');

            pageBarang.style.display = 'block';
            pagePembelian.style.display = 'none';
            pageRiwayatTransaksi.style.display = 'none';
            pageCekHarga.style.display = 'none';

        }

        function setPagePembelian() {
            let pageBarang = document.getElementById('page-barang');
            let pagePembelian = document.getElementById('page-pembelian');
            let pageRiwayatTransaksi = document.getElementById('page-riwayat-transaksi');
            let pageCekHarga = document.getElementById('page-cek-harga');

            pageBarang.style.display = 'none';
            pagePembelian.style.display = 'block';
            pageRiwayatTransaksi.style.display = 'none';
            pageCekHarga.style.display = 'none';

        }

        function setPageRiwayatTransaksi() {
            let pageBarang = document.getElementById('page-barang');
            let pagePembelian = document.getElementById('page-pembelian');
            let pageCekHarga = document.getElementById('page-cek-harga');
            let pageRiwayatTransaksi = document.getElementById('page-riwayat-transaksi');

            pageBarang.style.display = 'none';
            pagePembelian.style.display = 'none';
            pageRiwayatTransaksi.style.display = 'block';
            pageCekHarga.style.display = 'none';

        }

        function setPageCekHarga() {
            let pageBarang = document.getElementById('page-barang');
            let pagePembelian = document.getElementById('page-pembelian');
            let pageCekHarga = document.getElementById('page-cek-harga');
            let pageRiwayatTransaksi = document.getElementById('page-riwayat-transaksi');

            pageBarang.style.display = 'none';
            pagePembelian.style.display = 'none';
            pageRiwayatTransaksi.style.display = 'none';
            pageCekHarga.style.display = 'block';

        }

        function showProfile() {
            let profile = document.getElementById('profile');
            profile.style.display = 'block';
        }

        function closeProfile() {
            let profile = document.getElementById('profile');
            profile.style.display = 'none';
        }

        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        $(document).ready(function() {
            $('#dataTable1').DataTable();
        });
    </script>

</body>

</html>