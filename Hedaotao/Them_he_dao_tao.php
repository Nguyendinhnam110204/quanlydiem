<?php
require_once '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaHeDT = $_POST['MaHeDT'];
    $TenHeDT = $_POST['TenHeDT'];

    $addsql = "INSERT INTO hedaotao (MaHeDT, TenHeDT) VALUES ('$MaHeDT', '$TenHeDT')";
    $qr = mysqli_query($conn, $addsql);

    if ($qr) {
        $message = "Thêm khoa thành công";
        header("Location: Quan_ly_he_dao_tao.php");
        exit();
    } else {
        $message = "Lỗi: " . $addsql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>