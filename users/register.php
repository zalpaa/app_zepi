<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Form Register</h1>
    <form action="proses_register.php" method="post">
        <label for="">Nama</label><br>
        <input type="text" name="nama" id=""><br>

        <label for="">Username</label><br>
        <input type="text" name="username" id=""><br>

        <label for="">Password</label><br>
        <input type="password" name="password" id=""><br>

        <input type="submit" value="Register">

        <p>Sudah punya akun?  <a href="login.php">login</a></p>
        
    </form>
</body>
</html>