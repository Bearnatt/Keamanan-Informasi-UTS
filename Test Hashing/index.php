<?php
require_once "db-conn.php";
session_start();  
global $connect;

if(isset($_SESSION["username"])) {  
    header("location:entry.php");
}

    //Register
    if(isset($_POST["register"]))  {  
        if(empty($_POST["username"]) || empty($_POST["password"])) {  
            echo '<script>alert("Kolom tidak boleh kosong!")</script>';  
        }else {
            //mencegah sql injection
            $username = mysqli_real_escape_string($connect, $_POST["username"]);  
            $password = mysqli_real_escape_string($connect, $_POST["password"]);  

            //hashing password
            $password = password_hash($password, PASSWORD_DEFAULT);  
            $query = "INSERT INTO users(username, password) VALUES('$username', '$password')";  

            if(mysqli_query($connect, $query)) {  
                    echo '<script>alert("Pendaftaran Berhasil")</script>';  
            }  
        }
    }

    //Login
    if(isset($_POST["login"])) {  
        if(empty($_POST["username"]) || empty($_POST["password"])) {  
            echo '<script>alert("Kolom tidak boleh kosong!")</script>';  
        }else {
            //mencegah sql injection
            $username = mysqli_real_escape_string($connect, $_POST["username"]);  
            $password = mysqli_real_escape_string($connect, $_POST["password"]);  

            //mengecek data pada database
            $query = "SELECT * FROM users WHERE username = '$username'";  
            $result = mysqli_query($connect, $query);  

            if(mysqli_num_rows($result) > 0) {  
                    while($row = mysqli_fetch_array($result)) {  
                        if(password_verify($password, $row["password"])) { 
                            //return true;  
                            $_SESSION["username"] = $username;  
                            header("location:entry.php");  
                        }else {  
                            //return false;  
                            echo '<script>alert("Data pengguna salah")</script>';  
                        }  
                    }  
            }else {
                echo '<script>alert("Data pengguna salah")</script>';  
            }  
        }  
    }

?>  

<!DOCTYPE html>  
<html>  
    <head>  
        <title>Session Login - Pemrograman Web</title>  
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
    </head>  
    <body>  
        <br /><br />  
        <div class="container" style="width:500px;">  
            <h3 align="center">Session Login menggunakan PHP</h3>  
            <br />  
            <?php  
                if(isset($_GET["action"]) == "login") {  
            ?>  

            <h3 align="center">Login</h3>  
            <br />  
            <form method="post">  
                <label>Username</label>  
                <input type="text" name="username" class="form-control" placeholder="Masukan Username" />  
                <br />  
                <label>Password</label>  
                <input type="text" name="password" class="form-control" placeholder="Masukan Password" />  
                <br />  
                <input type="submit" name="login" value="Login" class="btn btn-info" />  
                <br />  
                <p align="center"><a href="index.php">Register</a></p>  
            </form>  

            <?php       
                }else {  
            ?>  
                
            <h3 align="center">Register</h3>  
            <br />  
            <form method="post">  
                <label>Username</label>  
                <input type="text" name="username" class="form-control" placeholder="Masukan Username" />  
                <br />  
                <label>Password</label>  
                <input type="text" name="password" class="form-control" placeholder="Masukan Password" />  
                <br />  
                <input type="submit" name="register" value="Register" class="btn btn-info" />  
                <br />  
                <p align="center"><a href="index.php?action=login">Login</a></p>  
            </form>  
            <?php  
            }  
            ?>

        </div>  
    </body>  
</html>  