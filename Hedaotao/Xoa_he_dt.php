<?php
if(isset($_GET['idHeDT'])){
    $idHeDT=$_GET['idHeDT'];
}

require_once '../connect.php';

$xoa_sql = "DELETE FROM hedaotao WHERE idHeDT = '$idHeDT'";
$qr= mysqli_query($conn,$xoa_sql);
header("location:Quan_ly_he_dao_tao.php");
?>