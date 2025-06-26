<?php
session_start();
include "koneksi.php";
$username= $_POST['username'];
$password= $_POST['password'];

$sql = "SELECT * FROM admin WHERE username='$username' AND password = md5('$password') LIMIT 1";
$query = mysqli_query($koneksi,$sql);

if (mysqli_num_rows($query) == 1) {
    $admin = mysqli_fetch_assoc($query);
    $_SESSION['id_admin'] = $admin['id_admin'];
    header("location:admin-dashboard.php?login=sukses");
    exit;
} else {
    header("location:login.php?login=gagal");
exit;
}
?>