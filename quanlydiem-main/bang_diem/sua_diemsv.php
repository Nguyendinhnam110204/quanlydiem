<?php
require_once '../folderconnect/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $id = $_POST['idDiem']; // ID của bản ghi cần cập nhật
// echo "ID received from form: " . $id;
// echo "<pre>";
// print_r($_POST); // Kiểm tra xem các giá trị POST từ form có đúng không
// echo "</pre>";
    $MaSinhVien = $_POST['MaSinhVien'];
    $HoTen = $_POST['HoTen'];
    $TenLop = $_POST['TenLop'];
    $DiemChuyenCan = $_POST['DiemChuyenCan'];
    $DiemGiuaKy = $_POST['DiemGiuaKy'];
    $DiemCuoiKy = $_POST['DiemCuoiKy'];
    $TongKetHocPhan = ($DiemChuyenCan*0.1 + $DiemGiuaKy*0.3  + $DiemCuoiKy*0.6); // Giả sử cách tính tổng kết học phần
    $diemChu = ''; // Tính toán điểm chữ dựa trên tổng kết học phần
    if ($TongKetHocPhan < 4.0) {
        $diemChu = 'F';
    } elseif ($TongKetHocPhan >= 4.0 && $TongKetHocPhan < 4.4) {
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
    if ($DiemCuoiKy == '1') {
        $DanhGia = 'Thi Lai';
    } elseif ($TongKetHocPhan >= 4.0) {
        $DanhGia = 'DAT';
    } else {
        $DanhGia = 'Thi Lai';
    }

    // Cập nhật bảng sinhvien
    $sql_update_sinhvien = "
    UPDATE sinhvien 
    SET MaSinhVien = '$MaSinhVien', HoTen = '$HoTen'
    WHERE idSinhVien = (SELECT idSinhVien FROM diem WHERE idDiem = '$id')";
  

    // Cập nhật bảng lop
    $sql_update_lop = "
    UPDATE lop 
    SET TenLop = '$TenLop'
    WHERE idLop = (SELECT idLop FROM sinhvien WHERE idSinhVien = (SELECT idSinhVien FROM diem WHERE idDiem = '$id'))";  

    // Cập nhật bảng monhoc
    // $sql_update_monhoc = "
    // UPDATE monhoc 
    // SET TenMonHoc = '$TenMonHoc'
    // WHERE idMonHoc = (SELECT idMonHoc FROM diem WHERE idDiem = '$id')";
  

    // Cập nhật bảng diem
    $sql_update_diem = "
    UPDATE diem 
    SET  DiemChuyenCan = '$DiemChuyenCan', DiemGiuaKy = '$DiemGiuaKy', DiemCuoiKy = '$DiemCuoiKy', TongKetHocPhan = '$TongKetHocPhan', DiemChu = '$diemChu', DanhGia = '$DanhGia'
    WHERE idDiem = '$id'";


    // Thực hiện cập nhật
    if (mysqli_query($conn, $sql_update_sinhvien) && mysqli_query($conn, $sql_update_lop)  && mysqli_query($conn, $sql_update_diem)) {
         header('location:bang_diem_sv.php');
        
    } else {
        echo "Lỗi cập nhật: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
