<?php
session_start();  //memulai session

//mengecek session, jika ada session bernama "username" maka pindah ke halaman utama
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
            //mengirim data ke database
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

            //mengecek data pada database, jika ada maka lakukan login
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