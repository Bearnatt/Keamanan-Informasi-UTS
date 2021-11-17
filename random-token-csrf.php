<?php
//memulai session
session_start();

//cek token bila belum di set, lakukan generate token
if(!isset($_SESSION['token'])){
    //generate random token
    $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
}

if(!empty($_GET['submit']) && $_SESSION['token'] == $_GET['token_Form'] ){
    session_destroy();
    die('Berhasil!');
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>CSRF Token PHP</title>
</head>
<body>
    <form action="" method="get">
        <input type="text" name="data" value="">
        <input type="hidden" name="token_Form" value="<?= $_SESSION['token'] ?>">
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>