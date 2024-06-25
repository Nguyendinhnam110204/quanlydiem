<?php
        require_once '../connect.php';

        $idMonHoc = $_POST['idMonHoc'];
        $MaMonHoc = $_POST['MaMonHoc'];
        $TenMonHoc = $_POST['TenMonHoc'];
        $SoTinChi = $_POST['SoTinChi'];
        $MoTa = $_POST['MoTa'];
        $HocKy = $_POST['HocKy'];

        $sql_check = "SELECT * FROM monhoc WHERE MaMonHoc = '$maMonHoc'";
        $result = $conn->query($sql_check);

        if ($result->num_rows == 0) {
                $update_sql = "UPDATE monhoc SET MaMonHoc = '$MaMonHoc', TenMonHoc = '$TenMonHoc', SoTinChi = '$SoTinChi', MoTa = '$MoTa', idHocKy = '$HocKy' WHERE idMonHoc = '$idMonHoc'";

                mysqli_query($conn, $update_sql);
        
                header("Location: index_MonHoc.php");
        } else {
            echo "<script>
                if (confirm('Trùng mã đã tồn tại. Không thể chèn bản ghi. Quay lại trang trước?')) {
                    window.location.href = 'index_MonHoc.php';
                } else {
                    window.location.href = 'index_MonHoc.php';
                }
              </script>";
        }

        
?>
