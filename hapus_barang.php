<?php 
require 'session/session.php';
require 'functions/function.php';

$id_keranjang = $_GET["id_keranjang"];

// cek apakah data berhasil dihapus atau tidak
if( hapusKeranjang($id_keranjang) > 0) {
    echo "
        <script> 
            alert('Data berhasil dihapus');
            document.location.href = 'keranjang.php';
        </script>
    ";
} else {
    echo "
        <script> 
            alert('Data gagal dihapus');
            document.location.href = 'keranjang.php';
        </script>
    ";

}