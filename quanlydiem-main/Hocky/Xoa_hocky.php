<?php
if(isset($_GET['idHocKy'])){
    $idHocKy=$_GET['idHocKy'];
}

require_once '../folderconnect/connect.php';

$xoa_sql = "DELETE FROM hocky WHERE idHocKy = '$idHocKy'";

try {
    if (!mysqli_query($conn,$xoa_sql)) {
        throw new Exception(mysqli_error($conn));
    }
    header("location:Quan_ly_hocky.php");
} catch (Exception $e) {
    // Nếu có lỗi, hiển thị thông báo và quay về trang list
    echo '<script>alert("Không thể xóa do khóa ngoại"); window.location.href = "Quan_ly_hocky.php";</script>';
    exit();
}
?>