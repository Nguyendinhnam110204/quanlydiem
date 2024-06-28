<?php
require_once '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaKhoa = $_POST['MaKhoa'];
    $TenKhoa = $_POST['TenKhoa'];

    $sql_check = "SELECT * FROM khoa WHERE MaKhoa = '$MaKhoa'";
        $result = $conn->query($sql_check);

        if ($result->num_rows == 0) {
            $addsql = "INSERT INTO khoa (MaKhoa, TenKhoa) VALUES ('$MaKhoa', '$TenKhoa')";
            $qr = mysqli_query($conn, $addsql);

            header("Location: Quan_ly_thong_tin_khoa.php");
        } else {
            echo "<script>
                if (confirm('Trùng mã đã tồn tại. Không thể chèn bản ghi. Quay lại trang trước?')) {
                    window.location.href = 'Quan_ly_thong_tin_khoa.php';
                } else {
                    window.location.href = 'Quan_ly_thong_tin_khoa.php';
                }
              </script>";
        }
}
mysqli_close($conn);
?>