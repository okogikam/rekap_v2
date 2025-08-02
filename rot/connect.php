<?php
$hn = 'localhost';
$un = 'root';
$pw = '';
$db = 'rekap_data';
$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error)die("Akses Gagal : ". $conn->connect_error);
?>