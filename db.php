<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "db_akademik";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("<div style='color: #d9534f; font-weight: bold;'>Koneksi database gagal: " . mysqli_connect_error() . "</div>");
}

?>