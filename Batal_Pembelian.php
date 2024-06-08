<?php 
require 'session/session.php';
require 'functions/function.php';

$id_pembelian = $_GET["id_pembelian"];

// cek apakah data berhasil dihapus atau tidak
if( hapusPembelianBarang($id_pembelian) > 0) {
    echo "
        <script> 
            alert('Data berhasil dihapus');
            document.location.href = 'index.php';
        </script>
    ";
} else {
    echo "
        <script> 
            alert('Data gagal dihapus');
            document.location.href = 'index.php';
        </script>
    ";

}