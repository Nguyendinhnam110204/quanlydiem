<?php
//nhan du lieu tu form
$id=$_POST['sid'];
$ma=$_POST['MaSinhVien'];
$lop=$_POST['idlop'];
$ten=$_POST['HoTen'];
$ns=$_POST['NgaySinh'];
$dc=$_POST['DiaChi'];
$email=$_POST['Email'];
$sdt=$_POST['DienThoai'];

//kết nối csdl
require_once '../folderconnect/connect.php';

//viet lenh sql de them du lieu
$updatesql = "UPDATE sinhvien SET MaSinhVien='$ma',idlop='$lop',HoTen='$ten', NgaySinh='$ns', DiaChi='$dc', Email='$email', DienThoai='$sdt' WHERE idSinhVien='$id'";
//echo $themsql; exit;
//thuc thi cau lenh them
if(mysqli_query($conn,$updatesql))
{
    //in thong bao thanh cong
    //tro ve trang liet ke
header("Location: Index_sinhvien.php");
}