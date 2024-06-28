<?php
    //lay du lieu id can xoa
    $idNguoiDung = $_GET['idNguoiDung'];
    // echo $matheloai;
    //ket noi
    require_once '../folderconnect/connect.php';

    //cau lenh sql
    $delete_sql = "DELETE FROM nguoidung WHERE idNguoiDung = $idNguoiDung";

    mysqli_query($conn, $delete_sql);

    //tro ve trang list
    header("Location: index_NguoiDung.php");
?>