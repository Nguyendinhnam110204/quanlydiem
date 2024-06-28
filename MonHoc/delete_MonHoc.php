<?php
// Lấy dữ liệu id cần xóa
$idMonHoc = $_GET['idMonHoc'];
// Kết nối
require_once '../connect.php';

// Câu lệnh SQL
$delete_sql = "DELETE FROM monhoc WHERE idMonHoc = $idMonHoc";

try {
    if (!mysqli_query($conn, $delete_sql)) {
        throw new Exception(mysqli_error($conn));
    }
    // Nếu xóa thành công, quay về trang list
    header("Location: index_MonHoc.php");
} catch (Exception $e) {
    // Nếu có lỗi, hiển thị thông báo và quay về trang list
    echo '<script>alert("Không thể xóa do khóa ngoại"); window.location.href = "index_MonHoc.php";</script>';
    exit();
}
?>
