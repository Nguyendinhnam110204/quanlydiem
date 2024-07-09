<?php
require_once '../folderconnect/connect.php';

if (isset($_POST['idMonHoc'])) {
    $idMonHoc = $_POST['idMonHoc'];
    $sql_monhoc="SELECT * FROM monhoc WHERE idMonHoc = '$idMonHoc'";
  $resulr_monhoc = mysqli_query($conn,$sql_monhoc);
  if (mysqli_num_rows($resulr_monhoc) > 0) {
    while ($row = mysqli_fetch_assoc($resulr_monhoc)) {
        echo "<option value='{$row['idMonHoc']}'>{$row['SoTinChi']}</option>";
    }
} else {
    echo "<option value='' disabled>Không có môn nào </option>";
}

}
   
mysqli_close($conn);

?>
