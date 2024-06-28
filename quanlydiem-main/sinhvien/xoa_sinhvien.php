<?php
//lấy dữ liệu id cần xóa
$sid =$_GET['sid'];
// echo $id;
//ket noi
require_once '../connect.php';
//cau lenh sql
$xoa_sql = "DELETE FROM sinhvien WHERE idSinhVien='$sid'";

mysqli_query($conn,$xoa_sql);
//echo "<h1>Xoa thanh cong </h1>";
//tro ve trang liet ke
header("Location: Index_sinhvien.php");