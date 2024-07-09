<?php
require_once '../folderconnect/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idMonHoc = $_POST['idMonHoc'];
    $idKhoa = $_POST['idKhoa']; // Đảm bảo bạn nhận được idKhoa từ biểu mẫu hoặc tham số URL

    // Câu lệnh SQL để thêm vào bảng khoamonhoc
    $addsql = "INSERT INTO khoamonhoc (idMonHoc, idKhoa) VALUES ('$idMonHoc', '$idKhoa')";
    $qr = mysqli_query($conn, $addsql);

    if ($qr) {
        header("Location: Quan_ly_mon_hoc_trong_khoa.php?idKhoa=$idKhoa");
        exit();
    } else {
        echo "Thêm môn học vào khoa không thành công.";
    }
}

mysqli_close($conn);
?>