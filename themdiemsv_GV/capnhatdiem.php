<?php
require_once '../folderconnect/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idDiem = $_POST['id'];
    $DiemChuyenCan = $_POST['DiemChuyenCan'];
    $DiemGiuaKy = $_POST['DiemGiuaKy'];
    $DiemCuoiKy = $_POST['DiemCuoiKy'];
    $selected_khoa = $_POST['khoa'];
    $selected_lop = $_POST['Lop'];
    $selected_mon = $_POST['mon'];
    
    if ($DiemChuyenCan !== '' && $DiemGiuaKy !== '' && $DiemCuoiKy !== '') {
        // Tính toán TongKetHocPhan
        $TongKetHocPhan = ($DiemChuyenCan * 0.1 + $DiemGiuaKy * 0.3 + $DiemCuoiKy * 0.6);
        

        // Tính toán DiemChu
        if ($TongKetHocPhan < 4) {
            $DiemChu = 'F';
        } elseif ($TongKetHocPhan < 5) {
            $DiemChu = 'E';
        } elseif ($TongKetHocPhan < 7) {
            $DiemChu = 'C';
        } elseif ($TongKetHocPhan < 8.5) {
            $DiemChu = 'B';
        } elseif ($TongKetHocPhan <= 10) {
            $DiemChu = 'A';
        } else {
            $DiemChu = ''; // Trường hợp không hợp lệ
        }

        // Tính toán DanhGia
        if ($TongKetHocPhan < 4) {
            $DanhGia = 'Thi Lai';
        } else {
            $DanhGia = 'DAT';
        }
    } else {
        // Để trống nếu bất kỳ điểm nào bị trống
        $TongKetHocPhan = '';
        $DiemChu = '';
        $DanhGia = '';
    }
    
    // Câu truy vấn để cập nhật điểm
    $sql_update = "UPDATE diem SET DiemChuyenCan = '$DiemChuyenCan', DiemGiuaKy = '$DiemGiuaKy', DiemCuoiKy = '$DiemCuoiKy',TongKetHocPhan = '$TongKetHocPhan', DiemChu = '$DiemChu', DanhGia = '$DanhGia'  WHERE idDiem = '$idDiem'  ";

    if (mysqli_query($conn, $sql_update)) {
        //echo "Cập nhật điểm thành công!";
        header('Location: danhsach_sv.php?khoa=' . $selected_khoa . '&lop=' . $selected_lop . '&mon=' . $selected_mon);
        //header('Location: themdiemsv.php');
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
