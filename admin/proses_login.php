<?php
session_start();
include "koneksi.php";
$username= $_POST['username'];
$password= $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$username' AND password = md5('$password') LIMIT 1";
$query = mysqli_query($koneksi,$sql);

if (mysqli_num_rows($query) == 1) {
    $users = mysqli_fetch_assoc($query);
    $_SESSION['id'] = $users['id_users'];
    header("location:admin-dashboard.php?login=sukses");
    exit;
} else {
    header("location:login.php?login=gagal");
exit;
}
?>