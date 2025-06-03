<?php
include('../../koneksi.php');
$id = $_GET['id_produk'];
$query = "DELETE FROM produk WHERE id_produk = '$id'";
header("Location: list_menu.php");
?>