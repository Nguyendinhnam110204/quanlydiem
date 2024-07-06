<?php
    //lay du lieu id can xoa
    $idMonHoc = $_GET['idMonHoc'];
    // echo $matheloai;
    //ket noi
    require_once '../folderconnect/connect.php';

    //cau lenh sql
    $delete_sql = "DELETE FROM monhoc WHERE idMonHoc = $idMonHoc";

    try {
        if (!mysqli_query($conn,$delete_sql)) {
            throw new Exception(mysqli_error($conn));
        }
        header("location:index_MonHoc.php");
    } catch (Exception $e) {
        // Nếu có lỗi, hiển thị thông báo và quay về trang list
        echo '<script>alert("Không thể xóa do khóa ngoại"); window.location.href = "index_MonHoc.php";</script>';
        exit();
    }
?>