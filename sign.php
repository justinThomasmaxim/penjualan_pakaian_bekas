<?php 

$user = false;
$pass = false;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Input Username dan Password</title>
    <link rel="stylesheet" href="styles/sign.css">
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>
        <form method="post">
            <!-- <label for="username">Username (Maksimal 7 Karakter):</label> -->
            <input type="text" name="username" id="username" placeholder="Enter Your Username" autofocus required>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST["username"];

                $user = true;

                if (strlen($username) > 7) {
                    echo "<p class='error-username'>*Username tidak boleh lebih dari tujuh karakter.</p>";
                    $user = false;
                }
            }

            ?>
            <br>
            <input type="email" name="email" id="username" placeholder="Enter Your Email" autofocus required>

            <br>
            <!-- <label for="password">Password (Minimal 10 Karakter, Harus terdiri dari huruf kapital, huruf kecil, angka, dan karakter khusus):</label> -->
            <input type="text" name="password" id="password" placeholder="Enter Your Password" required>
            <!-- <input type="button" name="show" id="show" class="mt-1 mb-6 text-right cursor-pointer" value="Show"> -->

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $password = $_POST["password"];
                $uppercase = preg_match('@[A-Z]@', $password);
                $lowercase = preg_match('@[a-z]@', $password);
                $number = preg_match('@[0-9]@', $password);
                $specialChars = preg_match('@[^\/_,.w]@', $password);

                $pass = true;

                if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 10) {
                    echo "<p class='error-password'>*Password harus terdiri dari huruf kapital, huruf kecil, angka, dan karakter khusus serta memiliki minimal 10 karakter.</p>";
                    $pass = false;
                }
            }
            ?>
            <br>
            <div class="button-link">
                <button name="submit">Sign Up</button>
                <a href="login.php">Login</a>
            </div>
            <!-- <input type="submit" name="submit" value="LOGIN"> -->
        </form>
    </div>

    <?php 
    
    require 'functions/function.php';

    if($user == true && $pass == true) {
        if (isset($_POST["submit"])) {
            if (registrasi($_POST) > 0) {
                echo "<script>
                    alert('Sign Up Berhasil');
                    document.location.href = 'login.php';
                </script>";
            }
        }
    }
    
    ?>

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