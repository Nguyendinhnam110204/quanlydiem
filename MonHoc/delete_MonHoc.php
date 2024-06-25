<?php
    //lay du lieu id can xoa
    $idMonHoc = $_GET['idMonHoc'];
    // echo $matheloai;
    //ket noi
    require_once '../connect.php';

    //cau lenh sql
    $delete_sql = "DELETE FROM monhoc WHERE idMonHoc = $idMonHoc";

    mysqli_query($conn, $delete_sql);

    //tro ve trang list
    header("Location: index_MonHoc.php");
?>