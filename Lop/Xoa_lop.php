<?php
if(isset($_GET['idLop'])){
    $idLop=$_GET['idLop'];
}

require_once '../connect.php';

$xoa_sql = "DELETE FROM lop WHERE idLop = '$idLop'";
$qr= mysqli_query($conn,$xoa_sql);
header("location:Quan_ly_thong_tin_lop.php");
?>