<?php
require_once '../folderconnect/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idDiem = $_POST['id'];
    $DiemCuoiKy = $_POST['DiemCuoiKy'];
    $selected_khoa = $_POST['khoa'];
    $selected_lop = $_POST['Lop'];
    $selected_mon = $_POST['mon'];

    // Lấy các điểm giữa kỳ và chuyên cần hiện tại từ cơ sở dữ liệu
    $query = "SELECT DiemChuyenCan, DiemGiuaKy FROM diem WHERE idDiem = '$idDiem'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    $DiemChuyenCan = $row['DiemChuyenCan'];
    $DiemGiuaKy = $row['DiemGiuaKy'];

    if ($DiemChuyenCan !== '' && $DiemGiuaKy !== '' && $DiemCuoiKy !== '') {
        // Tính toán TongKetHocPhan
        $TongKetHocPhan = ($DiemChuyenCan * 0.1 + $DiemGiuaKy * 0.3 + $DiemCuoiKy * 0.6);

        // Xác định điểm chữ
        if ($TongKetHocPhan < 4) {
            $diemChu = 'F';
        } elseif ($TongKetHocPhan >= 4 && $TongKetHocPhan < 4.4) {
            $diemChu = 'D';
        } elseif ($TongKetHocPhan >= 4.5 && $TongKetHocPhan < 5.0) {
            $diemChu = 'D+';
        } elseif ($TongKetHocPhan >= 5.1 && $TongKetHocPhan < 6.0) {
            $diemChu = 'C';
        } elseif ($TongKetHocPhan >= 6.1 && $TongKetHocPhan < 6.9) {
            $diemChu = 'C+';
        } elseif ($TongKetHocPhan >= 7.0 && $TongKetHocPhan <= 7.9) {
            $diemChu = 'B';
        } elseif ($TongKetHocPhan >= 8.0 && $TongKetHocPhan <= 8.4) {
            $diemChu = 'B+';
        } else {
            $diemChu = 'A';
        }

        // Tính toán DanhGia
        if ($TongKetHocPhan < 4) {
            $DanhGia = 'Thi Lai';
        } else {
            $DanhGia = 'DAT';
        }

        // Tính toán GPA theo hệ 4
        $gpaSystem4 = [
            'A' => 4.0,
            'B+' => 3.5,
            'B' => 3.0,
            'C+' => 2.5,
            'C' => 2.0,
            'D+' => 1.5,
            'D' => 1.0,
            'F' => 0.0
        ];
        $gpaH4 = $gpaSystem4[$diemChu];

        // Cập nhật điểm cuối kỳ và các loại điểm khác
        $sql_update = "UPDATE diem SET DiemCuoiKy = '$DiemCuoiKy', TongKetHocPhan = '$TongKetHocPhan', DiemChu = '$diemChu', DanhGia = '$DanhGia' WHERE idDiem = '$idDiem'";
        if (mysqli_query($conn, $sql_update)) {
            // Lấy idSinhVien và idHocKy từ bảng `diem` để cập nhật GPA
            $query = "SELECT idSinhVien, idHocKy FROM diem WHERE idDiem = '$idDiem'";
            $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
            $idSinhVien = $result['idSinhVien'];
            $idHocKy = $result['idHocKy'];

            // Kiểm tra xem GPA đã tồn tại chưa
            $query = "SELECT * FROM gpa WHERE idSinhVien = '$idSinhVien' AND idHocKy = '$idHocKy'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                // GPA đã tồn tại, thực hiện cập nhật
                $sql_gpa_update = "UPDATE gpa SET idHocKy = '$idHocKy', idSinhVien = '$idSinhVien', idDiem = '$idDiem', gpa_H4 = '$gpaH4' WHERE idSinhVien = '$idSinhVien' AND idHocKy = '$idHocKy'";
                mysqli_query($conn, $sql_gpa_update);
            } else {
                // GPA chưa tồn tại, thực hiện chèn mới
                $sql_gpa_insert = "INSERT INTO gpa (idHocKy, idSinhVien, idDiem, gpa_H4) VALUES ('$idHocKy', '$idSinhVien', '$idDiem', '$gpaH4')";
                mysqli_query($conn, $sql_gpa_insert);
            }
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }

        // Redirect sau khi cập nhật điểm thành công
        header('Location: danhsach_sv.php?khoa=' . $selected_khoa . '&lop=' . $selected_lop . '&mon=' . $selected_mon);
        exit;
    } else {
        echo "Lỗi: Điểm chuyên cần, điểm giữa kỳ hoặc điểm cuối kỳ bị trống.";
    }
}

mysqli_close($conn);
?>
