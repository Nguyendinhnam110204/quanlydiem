<?php
require_once '../folderconnect/connect.php';

if (isset($_POST['idGiangVien'])) {
    $idGiangVien = $_POST['idGiangVien'];
    $sql = "SELECT * FROM lop WHERE idGiangVien = '$idGiangVien'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['idLop']}'>{$row['TenLop']}</option>";
        }
    } else {
        echo "<option value='' disabled>Không có lớp</option>";
    }
}

mysqli_close($conn);

?>
