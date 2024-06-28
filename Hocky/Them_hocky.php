<?php
require_once '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $NamHoc = $_POST['NamHoc'];
    $TenHocKy = $_POST['TenHocKy'];

    $addsql = "INSERT INTO hocky (NamHoc, TenHocKy) VALUES ('$NamHoc', '$TenHocKy')";
    $qr = mysqli_query($conn, $addsql);

    if ($qr) {
        $message = "Thêm khoa thành công";
        header("Location: Quan_ly_hocky.php");
        exit();
    } else {
        $message = "Lỗi: " . $addsql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>