<?php 
session_start();

require 'config/connect_db.php';

if ( isset($_POST["submit"]) ) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM pengguna WHERE username = '$username' AND password = '$password'";

    $result = mysqli_query($conn, $query);
 
    $row = mysqli_fetch_assoc($result);

    if ($username == $row['username'] && $password == $row['password']) {
        $_SESSION["id_pengguna"] = $row['id_pengguna'];

        header("Location: index.php");
        exit;
    }  else {
        echo "<script>alert('Usename atau password tidak terdaftar!')</script>";
    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Input Username dan Password</title>
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
    <div class="container">
        <h1>LOGIN</h1>
        <form method="post">
            <!-- <label for="username">Username (Maksimal 7 Karakter):</label> -->
            <input type="text" name="username" id="username" placeholder="Enter Your Username" autofocus required>

            <br>
            <!-- <label for="password">Password (Minimal 10 Karakter, Harus terdiri dari huruf kapital, huruf kecil, angka, dan karakter khusus):</label> -->
            <input type="text" name="password" id="password" placeholder="Enter Your Password" required>
            <!-- <input type="button" name="show" id="show" class="mt-1 mb-6 text-right cursor-pointer" value="Show"> -->

            <br>
            <div class="button-link">
                <button name="submit">LOGIN</button>
                <a href="sign.php">Sign Up</a>
            </div>
            <!-- <input type="submit" name="submit" value="LOGIN"> -->
        </form>
    </div>

<script>
    const show = document.getElementById('show');
    const pass = document.getElementById('password');

    show.addEventListener('click', () => {
        if(show.value === "Show"){
            show.value = 'Hide';
            pass.setAttribute('type', 'text');
        } else {
            show.value = 'Show';
            pass.setAttribute('type', 'password');
        }
    })
</script>

</body>
</html>