<?php
//Nhan du lieu
$ma=$_POST['MaGiangVien'];
$ten=$_POST['HoTen'];
$ns=$_POST['NgaySinh'];
$dc=$_POST['DiaChi'];
$email=$_POST['Email'];
$sdt=$_POST['DienThoai'];
$td=$_POST['TrinhDoHV'];
$cm=$_POST['ChuyenMon'];
//ket noi sql
require_once '../folderconnect/connect.php';
$sql_check = "SELECT * FROM giangvien WHERE MaGiangVien = '$ma'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    // Mã giảng viên đã tồn tại
    echo "<script>alert('Mã giảng viên đã tồn tại! Vui lòng nhập mã khác.'); window.location.href='them_sinhvien.php';</script>";
} else{
//viet lech sql
$them_sql="INSERT INTO giangvien(MaGiangVien,HoTen,NgaySinh,DiaChi,Email,DienThoai,TrinhDoHV,ChuyenMon) VALUES ('$ma','$ten','$ns','$dc','$email','$sdt','$td','$cm')";
}
if(mysqli_query($conn,$them_sql))
{
    //in thong bao thanh cong
    //tro ve trang liet ke
header("Location: Index_giangvien.php");
}
?>
