<?php
include "koneksi.php";


$username = $_POST['username'];
$password = $_POST['password'];

$sql = "INSERT INTO admin (username, password) VALUES ('$username', md5('$password') )";

$query = mysqli_query($koneksi, $sql);

if ($query) {
    header("location:login.php?register=sukses");
    exit;
} else {
    header("location:login.php?register=gagal");
    exit;
}
?>