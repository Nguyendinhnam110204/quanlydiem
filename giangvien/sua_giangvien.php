<?php
//Nhan du lieu
$id=$_POST['sid'];
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
// Kiểm tra mã giảng viên có bị trùng không
$check_sql = "SELECT * FROM giangvien WHERE MaGiangVien = '$ma' AND idGiangVien != '$id'";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) > 0) {
    // Nếu mã giảng viên đã tồn tại và không phải của giảng viên hiện tại
    echo "Mã giảng viên đã tồn tại. Vui lòng nhập mã khác.";
    exit;
}
//viet lenh sql de them du lieu
$updatesql = "UPDATE giangvien SET MaGiangVien='$ma',HoTen='$ten', NgaySinh='$ns', DiaChi='$dc', Email='$email', DienThoai='$sdt',TrinhDoHV='$td',ChuyenMon='$cm' WHERE idGiangVien='$id'";
//echo $themsql; exit;
//thuc thi cau lenh them
if(mysqli_query($conn,$updatesql))
{
    //in thong bao thanh cong
    //tro ve trang liet ke
header("Location: Index_giangvien.php");
}