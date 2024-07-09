<?php
require_once '../folderconnect/connect.php';
if (isset($_POST['idLop']) && isset($_POST['idHocKy'])) {
    $idLop = $_POST['idLop'];
    $idHocKy = $_POST['idHocKy'];
    
    $sql = "SELECT mh.idMonHoc, mh.TenMonHoc 
            FROM monhoc mh
            JOIN diem d ON d.idMonHoc = mh.idMonHoc
            JOIN sinhvien sv ON sv.idSinhVien = d.idSinhVien
            WHERE sv.idLop = '$idLop' AND d.idHocKy = '$idHocKy'";
    
    $result = mysqli_query($conn, $sql);
    $options = "";
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $options .= '<option value="' . $row['idMonHoc'] . '">' . $row['TenMonHoc'] . '</option>';
        }
    }
    echo $options;
}
mysqli_close($conn);
?>
