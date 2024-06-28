<?php
if(isset($_GET['idHeDT'])){
    $idHeDT=$_GET['idHeDT'];
}

require_once '../connect.php';

$xoa_sql = "DELETE FROM hedaotao WHERE idHeDT = '$idHeDT'";
try {
    if (!mysqli_query($conn,$xoa_sql)) {
        throw new Exception(mysqli_error($conn));
    }
    header("location:Quan_ly_he_dao_tao.php");
} catch (Exception $e) {
    // Nếu có lỗi, hiển thị thông báo và quay về trang list
    echo '<script>alert("Không thể xóa do khóa ngoại"); window.location.href = "Quan_ly_he_dao_tao.php";</script>';
    exit();
}
?>