<?php
require_once '../folderconnect/connect.php'; // Đảm bảo kết nối đến cơ sở dữ liệu

// Kiểm tra xem idMonHoc có tồn tại trong URL không
if (isset($_GET['idMonHoc'])) {
    $idMonHoc = $_GET['idMonHoc'];

    // Xây dựng câu truy vấn xóa môn học
    $sql = "DELETE FROM khoamonhoc WHERE idMonHoc='$idMonHoc'";
    if (mysqli_query($conn, $sql)) {
        // Chuyển hướng người dùng về trang Quan_ly_mon_hoc_trong_khoa.php với idKhoa
        header("Location: ../Khoa/Quan_ly_mon_hoc_trong_khoa.php?idKhoa={$_GET['idKhoa']}");
        exit(); // Đảm bảo không thực thi mã HTML bên dưới khi chuyển hướng
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
} else {
    echo "Không có thông tin môn học để xóa.";
}
?>