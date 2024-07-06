<?php
if(isset($_GET['idLop'])){
    $idLop=$_GET['idLop'];
}

require_once '../folderconnect/connect.php';

$xoa_sql = "DELETE FROM lop WHERE idLop = '$idLop'";
try {
    if (!mysqli_query($conn,$xoa_sql)) {
        throw new Exception(mysqli_error($conn));
    }
    header("location:Quan_ly_thong_tin_lop.php");
} catch (Exception $e) {
    // Nếu có lỗi, hiển thị thông báo và quay về trang list
    echo '<script>alert("Không thể xóa do khóa ngoại"); window.location.href = "Quan_ly_thong_tin_lop.php";</script>';
    exit();
}
?>