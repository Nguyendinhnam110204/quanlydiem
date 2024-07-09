<?php
require_once '../folderconnect/connect.php';
if (isset($_POST['idLop2']) && isset($_POST['idHocKy2'])) {
    $idLop2 = $_POST['idLop2'];
    $idHocKy2 = $_POST['idHocKy2'];
    
    $sql = "SELECT mh.idMonHoc, mh.TenMonHoc 
            FROM monhoc mh
            JOIN diem d ON d.idMonHoc = mh.idMonHoc
            JOIN sinhvien sv ON sv.idSinhVien = d.idSinhVien
            WHERE sv.idLop = '$idLop2' AND d.idHocKy = '$idHocKy2'";
    
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
