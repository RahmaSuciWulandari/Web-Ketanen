<?php 
$hostname = "localhost";
$username = "root";
$password = "";
$database = "kknketanen";

$koneksi = mysqli_connect($hostname, $username, $password, $database);
if($koneksi->connect_error){
    die("Koneksi gagal". $koneksi->connect_error);
}

?>      