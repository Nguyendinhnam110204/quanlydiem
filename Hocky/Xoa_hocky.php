<?php
if(isset($_GET['idHocKy'])){
    $idHocKy=$_GET['idHocKy'];
}

require_once '../connect.php';

$xoa_sql = "DELETE FROM hocky WHERE idHocKy = '$idHocKy'";
$qr= mysqli_query($conn,$xoa_sql);
header("location:Quan_ly_hocky.php");
?>