<?php
require_once '../folderconnect/connect.php';

if (isset($_POST['idGiangVien'])) {
    $idGiangVien = $_POST['idGiangVien'];
    $sql_monhoc="SELECT * FROM monhoc
    JOIN diem d ON d.idMonHoc = monhoc.idMonHoc
    WHERE d.idGiangVien = '$idGiangVien'";
  $resulr_monhoc = mysqli_query($conn,$sql_monhoc);
  if (mysqli_num_rows($resulr_monhoc) > 0) {
    while ($row = mysqli_fetch_assoc($resulr_monhoc)) {
        echo "<option value='{$row['idMonHoc']}'>{$row['TenMonHoc']}</option>";
    }
} else {
    echo "<option value='' disabled>Không có môn nào </option>";
}

}
   
mysqli_close($conn);

?>
