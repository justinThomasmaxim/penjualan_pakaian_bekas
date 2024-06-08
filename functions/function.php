<?php 
require './config/connect_db.php';

function query($query): array
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// HALAMAN INDEX

// Cari berdasarkan MERK LAPTOP
function cariSesuaiJenis($data)
{
    global $conn;

    $nama_kategori = $_GET['jenis'];

    $query1 = "SELECT id_kategori FROM kategori WHERE nama_kategori = '$nama_kategori'";

    $result = mysqli_query($conn, $query1);

    $row = mysqli_fetch_assoc($result);

    $id_kategori = $row['id_kategori'];

    $query = "SELECT * FROM barang_bekas WHERE id_kategori LIKE '$id_kategori'";

    return query($query);
}

// HALAMAN SIGN

function registrasi($data)
{
    global $conn;

    $username = $data["username"];
    $email = $data["email"];
    $password = $data["password"];

    // cek username sudah ada atau belum
    $query = "SELECT username FROM pengguna WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Username sudah terdaftar!')
             </script>";
        return false;
    }

    // insert data ke database
    $query1 = "INSERT INTO pengguna (username, password, email) VALUES ('$username', '$password', '$email')";

    mysqli_query($conn, $query1);

    return mysqli_affected_rows($conn);
}

// TABEL PELANGGAN 
function tambahPelanggan($data, $id_pengguna)
{   
    global $conn;

    $nama_pelanggan = $data["nama_pelanggan"];
    $alamat         = $data["alamat"];
    $nomor_telepon  = $data["nomor_telepon"];

    $query = "CALL insert_pelanggan('$id_pengguna', '$nama_pelanggan', '$alamat', '$nomor_telepon')";


    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function ubahPelanggan($data, $id_pengguna)
{
    global $conn;

    $id_pelanggan   = $id_pengguna;
    $nama_pelanggan  = $data['nama_pelanggan'];
    $alamat         = $data['alamat'];
    $nomor_telepon        = $data['nomor_telepon'];

    $query = "CALL update_pelanggan('$id_pelanggan', '$nama_pelanggan', '$alamat', '$nomor_telepon')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


// TABEL KERANJANG

function tambahKeranjang($data, $id_pengguna)
{   
    global $conn;

    $jumlah          = $data["jumlah"];
    $id_barang_bekas = $data["id_barang_bekas"];

    $query = "CALL insert_keranjang('$id_pengguna', '$id_barang_bekas', '$jumlah')";


    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function updateKeranjang($data)
{   
    global $conn;

    $id_keranjang = $data["id_keranjang"];
    $jumlah       = $data["jumlah"];

    $query = "CALL update_keranjang('$id_keranjang', '$jumlah')";


    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusKeranjang($id_keranjang) {
    global $conn;

    mysqli_query($conn, "CALL Delete_All_Data('$id_keranjang', 'keranjang')");
    
     // Jika gagal mengembalikan nilai -1, 
    // jika berhasil mengembalikan nilai 1
    return  mysqli_affected_rows($conn);

}

// TABEL PERMBELIAN BARANG BEKAS

function tambahPembelianBarangDariKeranjang($data, $id_transaksi, $id_pengguna)
{   
    global $conn;

    $selectedItemsArray = explode(',', $data);

    foreach($selectedItemsArray as $item) {
        $query = "SELECT k.id_keranjang, k.id_barang_bekas, k.jumlah FROM keranjang AS k
                INNER JOIN barang_bekas AS b ON (k.id_barang_bekas = b.id_barang_bekas)
                WHERE k.id_keranjang = '$item'";
        
        $result = mysqli_query($conn, $query);

        $row = mysqli_fetch_assoc($result);

        $id_keranjang    = $row['id_keranjang'];
        $id_barang_bekas = $row['id_barang_bekas'];
        $jumlah          = $row['jumlah'];

        $query1 = "CALL insert_pembelian_barang_bekas('$id_transaksi', '$id_pengguna', '$id_barang_bekas', '$jumlah')";

        $query2 = "CALL Delete_All_Data('$id_keranjang', 'keranjang')";

        mysqli_query($conn, $query1);

        mysqli_query($conn, $query2);

    }

    return mysqli_affected_rows($conn);
}

function tambahPembelianBarangLangsung($id_transaksi, $id_pengguna, $id_barang_bekas, $jumlah)
{   
    global $conn;

    $query = "CALL insert_pembelian_barang_bekas('$id_transaksi', '$id_pengguna', '$id_barang_bekas', '$jumlah')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function ubahJumlahBeli($data)
{   
    global $conn;

    $id_pembelian = $data['id_pembelian'];
    $jumlah       = $data['jumlah'];

    $query = "CALL update_pembelian_barang_bekas('$id_pembelian', '$jumlah')";


    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusPembelianBarang($id_pembelian) {
    global $conn;

    mysqli_query($conn, "CALL Delete_All_Data('$id_pembelian', 'pembelian_barang_bekas')");
    
     // Jika gagal mengembalikan nilai -1, 
    // jika berhasil mengembalikan nilai 1
    return  mysqli_affected_rows($conn);

}

// TABEL TRANSAKSI 

function tambahTransaksi($subTotal)
{   
    global $conn;

    $query = "CALL insert_transaksi('$subTotal')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


?>
