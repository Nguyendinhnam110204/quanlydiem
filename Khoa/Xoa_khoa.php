<?php
if(isset($_GET['idKhoa'])){
    $idKhoa=$_GET['idKhoa'];
}

require_once '../connect.php';

$xoa_sql = "DELETE FROM khoa WHERE idKhoa = '$idKhoa'";
$qr= mysqli_query($conn,$xoa_sql);
header("location:Quan_ly_thong_tin_khoa.php");
?>