<?php
//lấy dữ liệu id cần xóa
$sid =$_GET['sid'];
// echo $id;
//ket noi
require_once '../folderconnect/connect.php';
//cau lenh sql
$xoa_sql = "DELETE FROM sinhvien WHERE idSinhVien='$sid'";

try {
    if (!mysqli_query($conn,$xoa_sql)) {
        throw new Exception(mysqli_error($conn));
    }
    header("location:Index_sinhvien.php");
} catch (Exception $e) {
    // Nếu có lỗi, hiển thị thông báo và quay về trang list
    echo '<script>alert("Không thể xóa do khóa ngoại"); window.location.href = "Index_sinhvien.php";</script>';
    exit();
}
?>