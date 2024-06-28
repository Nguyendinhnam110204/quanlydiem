<?php
require_once '../folderconnect/connect.php';
require_once  'Sua_thong_tin_lop.php';
$idLop = $_POST['txtidLop'];
$MaLop = $_POST['txtMaLop'];
$TenLop = $_POST['txtTenLop'];
$idKhoa = $_POST['sidKhoa'];
$idHeDT = $_POST['sidHeDT'];
$idGiangvien = $_POST['sidGiangvien'];

$sql = "UPDATE lop SET MaLop='$MaLop',TenLop='$TenLop',idKhoa='$idKhoa',idHeDT='$idHeDT',idGiangvien='$idGiangvien' WHERE idLop='$idLop'";
mysqli_query($conn,$sql);
echo "<script>alert('Cập nhật thành công!'); location.href ='Quan_ly_thong_tin_lop.php'</script>";

?>