<?php
if(isset($_GET['idKhoa'])){
    $idKhoa=$_GET['idKhoa'];
}

require_once '../connect.php';

$xoa_sql = "DELETE FROM khoa WHERE idKhoa = '$idKhoa'";

try {
    if (!mysqli_query($conn,$xoa_sql)) {
        throw new Exception(mysqli_error($conn));
    }
    header("location:Quan_ly_thong_tin_khoa.php");
} catch (Exception $e) {
    // Nếu có lỗi, hiển thị thông báo và quay về trang list
    echo '<script>alert("Không thể xóa do khóa ngoại"); window.location.href = "Quan_ly_thong_tin_khoa.php";</script>';
    exit();
}
?>