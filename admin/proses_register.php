<?php
include "koneksi.php";

$nama = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "INSERT INTO users (nama, username, password) VALUES ('$nama', '$username', md5('$password') )";

$query = mysqli_query($koneksi, $sql);

if ($query) {
    header("location:login.php?register=sukses");
    exit;
} else {
    header("location:login.php?register=gagal");
    exit;
}
?>