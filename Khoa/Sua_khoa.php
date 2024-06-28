<?php
require_once '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $idKhoa = $_POST['txtidKhoa'];
    $MaKhoa = $_POST['txtMaKhoa'];
    $TenKhoa = $_POST['txtTenKhoa'];
// Câu lệnh SQL để cập nhật dữ liệu vào bảng NguoiDung
$update_sql = "UPDATE khoa SET TenKhoa = '$TenKhoa', MaKhoa = '$MaKhoa' WHERE idKhoa = '$idKhoa'";

// Thực thi câu lệnh SQL
if (mysqli_query($conn, $update_sql)) {
    // Nếu thêm thành công, thông báo và đóng modal
    echo '<script>alert("Sửa thành công!"); window.location.href = "Quan_ly_thong_tin_khoa.php";</script>';
} else {
    // Nếu có lỗi, thông báo lỗi
    echo "Error: " . $update_sql . "<br>" . mysqli_error($conn);
}
}

// Đóng kết nối
mysqli_close($conn);
?>