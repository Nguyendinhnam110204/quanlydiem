<?php
require_once '../folderconnect/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $idHocKy = $_POST['txtidHocKy'];
    $NamHoc = $_POST['txtNamHoc'];
    $TenHocKy = $_POST['txtTenHocKy'];
// Câu lệnh SQL để cập nhật dữ liệu vào bảng NguoiDung
$update_sql = "UPDATE hocky SET NamHoc = '$NamHoc', TenHocKy = '$TenHocKy' WHERE idHocKy = '$idHocKy'";

// Thực thi câu lệnh SQL
if (mysqli_query($conn, $update_sql)) {
    // Nếu thêm thành công, thông báo và đóng modal
    echo '<script>alert("Sửa thành công!"); window.location.href = "Quan_ly_hocky.php";</script>';
} else {
    // Nếu có lỗi, thông báo lỗi
    echo "Error: " . $update_sql . "<br>" . mysqli_error($conn);
}
}

// Đóng kết nối
mysqli_close($conn);
?>