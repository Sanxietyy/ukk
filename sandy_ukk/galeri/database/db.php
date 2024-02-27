<?php
    $hostname = "localhost";
    $userdb = "root";
    $pwdb = "";
    $database = "gallery";

    $db = mysqli_connect($hostname, $userdb, $pwdb, $database);

    if($db->connect_error) {
        echo "koneksi database gagal";
        die("error!");
    }
?>
