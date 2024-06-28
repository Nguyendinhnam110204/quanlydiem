<?php
        $maMonHoc = $_POST['MaMonHoc'];
        $tenMonHoc = $_POST['TenMonHoc'];
        $soTinChi = $_POST['SoTinChi'];
        $moTa = $_POST['MoTa'];
        $hocKy = $_POST['HocKy'];

        //ket noi csdl
        require_once '../folderconnect/connect.php';

        $sql_check = "SELECT * FROM monhoc WHERE MaMonHoc = '$maMonHoc'";
        $result = $conn->query($sql_check);

        if ($result->num_rows == 0) {
            $themsql = "INSERT INTO monhoc (MaMonHoc, TenMonHoc, SoTinChi, MoTa, idHocKy) VALUES ('$maMonHoc', '$tenMonHoc', '$soTinChi', '$moTa', '$hocKy')";
            // echo $themsql; exit;

            //thuc thi cau lenh them
            mysqli_query($conn, $themsql);

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