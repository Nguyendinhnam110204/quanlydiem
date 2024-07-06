<?php
       require_once '../folderconnect/connect.php';

        $idMonHoc = $_POST['idMonHoc'];
        $MaMonHoc = $_POST['MaMonHoc'];
        $TenMonHoc = $_POST['TenMonHoc'];
        $SoTinChi = $_POST['SoTinChi'];
        $idHocKy = $_POST['idHocKy'];
        $MoTa = $_POST['MoTa'];

        $update_sql = "UPDATE monhoc SET MaMonHoc = '$MaMonHoc', TenMonHoc = '$TenMonHoc', SoTinChi = '$SoTinChi', idHocKy='$idHocKy', MoTa = '$MoTa' WHERE idMonHoc = '$idMonHoc'";

        mysqli_query($conn, $update_sql);
        
        header("Location: index_MonHoc.php");    
?>
