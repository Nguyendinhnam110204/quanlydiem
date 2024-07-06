<?php
//Nhan du lieu
$ma=$_POST['MaSinhVien'];
$ten=$_POST['HoTen'];
$ns=$_POST['NgaySinh'];
$dc=$_POST['DiaChi'];
$email=$_POST['Email'];
$sdt=$_POST['DienThoai'];

//ket noi sql
require_once '../folderconnect/connect.php';
// Kiểm tra mã sinh viên có trùng hay không
$sql_check = "SELECT * FROM sinhvien WHERE MaSinhVien = '$ma'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    // Mã sinh viên đã tồn tại
    echo "<script>alert('Mã sinh viên đã tồn tại! Vui lòng nhập mã khác.'); window.location.href='them_sinhvien.php';</script>";
} else{
//viet lech sql
$them_sql="INSERT INTO sinhvien(MaSinhVien,HoTen,NgaySinh,DiaChi,Email,DienThoai) VALUES ('$ma','$ten','$ns','$dc','$email','$sdt')";
}
if(mysqli_query($conn,$them_sql))
{
    //in thong bao thanh cong
    //tro ve trang liet ke
header("Location: Insert_sinhvien.php");
}
?>

