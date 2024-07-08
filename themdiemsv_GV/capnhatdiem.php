<?php
require_once '../folderconnect/connect.php';
require_once '../Classes/Classes/PHPExcel.php';
require_once '../Classes/Classes/PHPExcel/IOFactory.php';

// Hệ thống chuyển đổi điểm thành GPA theo hệ 4
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

// Xử lý khi nhấn nút "Nhập điểm từ Excel"
if(isset($_POST['btn_xuat_excel']) && isset($_POST['hocKy'])  && isset($_POST['giangVien']) && isset($_POST['monHoc']) && isset($_POST['soTinChi']) && isset($_POST['lop']) && isset($_FILES['fileUpload'])) {
    $idHocKy = $_POST['hocKy'];
    $idGiangVien = $_POST['giangVien'];
    $idMonHoc = $_POST['monHoc'];
    $soTinChi = $_POST['soTinChi'];
    $lop = $_POST['lop'];
    $file = $_FILES['fileUpload']['tmp_name'];

    // Kiểm tra file có tồn tại và có thể đọc được không
    if (!empty($file) && file_exists($file)) {
        $objReader = PHPExcel_IOFactory::createReaderForFile($file);
        $objReader->setLoadSheetsOnly('73dctt24');

        try {
            $objExcel = $objReader->load($file);
            $sheetData = $objExcel->getActiveSheet()->toArray(null, true, true, true);
            $highestRow = $objExcel->getActiveSheet()->getHighestRow();

            // Tạo ánh xạ từ MaSinhVien sang idSinhVien
            $sinhVienMapping = [];
            $result = $conn->query("SELECT idSinhVien, MaSinhVien FROM sinhvien");
            while ($row = $result->fetch_assoc()) {
                $sinhVienMapping[$row['MaSinhVien']] = $row['idSinhVien'];
            }

            // Biến để tính tổng số tín chỉ và tổng điểm trung bình trọng số
            $tongtinchi  = 0;
            $tongdiemtrungbinh= 0;

            // Duyệt qua các dòng dữ liệu từ file Excel
            for($row = 2; $row <= $highestRow; $row++){
                $maSinhVien = $sheetData[$row]['A'];
                $diemChuyenCan = $sheetData[$row]['C'];
                $diemGiuaKy = $sheetData[$row]['D'];
                $diemCuoiKy = $sheetData[$row]['E'];

                // Chuyển MaSinhVien sang idSinhVien 
                $idSinhVien = $sinhVienMapping[$maSinhVien] ?? null;

                if ($idSinhVien) {
                    $tongKetHocPhan = ($diemChuyenCan * 0.1 + $diemGiuaKy * 0.3 + $diemCuoiKy * 0.6);

                    // Xác định điểm chữ
                    if ($tongKetHocPhan < 4) {
                        $diemChu = 'F';
                    } elseif ($tongKetHocPhan >= 4 && $tongKetHocPhan < 4.4) {
                        $diemChu = 'D';
                    } elseif ($tongKetHocPhan >= 4.5 && $tongKetHocPhan < 5.0) {
                        $diemChu = 'D+';
                    } elseif ($tongKetHocPhan >= 5.1 && $tongKetHocPhan < 6.0) {
                        $diemChu = 'C';
                    } elseif ($tongKetHocPhan >= 6.1 && $tongKetHocPhan < 6.9) {
                        $diemChu = 'C+';
                    } elseif ($tongKetHocPhan >= 7.0 && $tongKetHocPhan <= 7.9) {
                        $diemChu = 'B';
                    } elseif ($tongKetHocPhan >= 8.0 && $tongKetHocPhan <= 8.4) {
                        $diemChu = 'B+';
                    } else {
                        $diemChu = 'A';
                    }
                    
                    // Tính điểm GPA theo hệ 4
                    $gpaH4 = $gpaSystem4[$diemChu];
                    // Xác định đánh giá
                    $danhGia = ($tongKetHocPhan < 4) ? 'Thi Lai' : 'DAT';

                    // Thực hiện câu lệnh INSERT
                    $sql = "INSERT INTO diem (idSinhVien,idGiangVien, idMonHoc, idHocKy, DiemChuyenCan, DiemGiuaKy, DiemCuoiKy, TongKetHocPhan, DiemChu, DanhGia) VALUES ('$idSinhVien','$idGiangVien', '$idMonHoc', '$idHocKy', '$diemChuyenCan', '$diemGiuaKy', '$diemCuoiKy', '$tongKetHocPhan', '$diemChu', '$danhGia')";
                    $result = mysqli_query($conn, $sql);

                    // Kiểm tra và xử lý kết quả INSERT
                    if ($result) {
                        // Lấy id của bản ghi vừa chèn vào
                        $lastInsertedId = mysqli_insert_id($conn);

                        // Cập nhật GPA vào bảng `gpa`
                        $sqlGPA = "INSERT INTO gpa ( idSinhVien,idHocKy, GPA ) VALUES ('$idSinhVien','$idHocKy','$gpaH4')";
                        $resultGPA = mysqli_query($conn, $sqlGPA);

                        // Lấy id của GPA vừa cập nhật
                        $idGPA = mysqli_insert_id($conn);

                        // Cập nhật idGPA vào bảng `diem`
                        $sqlUpdateDiem = "UPDATE diem SET idGPA = '$idGPA', idSinhVien= '$idSinhVien', idHocKy='$idHocKy'   WHERE idDiem = '$lastInsertedId'";
                        $resultUpdateDiem = mysqli_query($conn, $sqlUpdateDiem);

                        if ($resultUpdateDiem) {
                            echo "Thêm dữ liệu thành công cho sinh viên có mã: $maSinhVien<br>";
                        } else {
                            echo "Lỗi khi cập nhật idGPA cho bảng diem: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Lỗi khi thêm dữ liệu vào bảng diem: " . mysqli_error($conn);
                    }
                } else {
                    echo "Không tìm thấy ánh xạ cho MaSinhVien: $maSinhVien <br>";
                }
            }
        } catch (Exception $e) {
            echo 'Lỗi khi đọc file Excel: ',  $e->getMessage(), "\n";
        }
    } else {
        echo "File không tồn tại hoặc không thể đọc được.";
    }
}

// // Đảm bảo không có output trước khi redirect
// ob_end_flush();

header('Location: themdiem_SV.php');
exit;
?>
