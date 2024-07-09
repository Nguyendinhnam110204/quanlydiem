<?php
require_once '../folderconnect/connect.php';

if (isset($_POST['idKhoa'])) {
    $idKhoa = $_POST['idKhoa'];
    $sql = "SELECT * FROM giangvien WHERE idKhoa = '$idKhoa '";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['idGiangVien']}'>{$row['HoTen']}</option>";
        }
    } else {
        echo "<option value='' disabled>Không có lớp</option>";
    }
}

mysqli_close($conn);

?>
