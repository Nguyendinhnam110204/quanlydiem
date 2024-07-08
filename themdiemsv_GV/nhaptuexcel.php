<?php
session_start();
require_once '../folderconnect/connect.php';
require_once '../Classes/Classes/PHPExcel.php';
require_once '../Classes/Classes/PHPExcel/IOFactory.php';

// Xử lý khi nhấn nút "Nhập điểm từ Excel"
if(isset($_POST['btn_xuat_excel']) && isset($_POST['hocKy']) && isset($_POST['giangVien']) && isset($_POST['monHoc']) && isset($_POST['lop']) && isset($_FILES['fileUpload'])) {
    $idHocKy = $_POST['hocKy'];
    $idGiangVien = $_POST['giangVien'];
    $idMonHoc = $_POST['monHoc'];
    // $soTinChi = $_POST['soTinChi'];
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

            // Duyệt qua các dòng dữ liệu từ file Excel
            for($row = 2; $row <= $highestRow; $row++){
                $maSinhVien = $sheetData[$row]['A'];
                $diemChuyenCan = $sheetData[$row]['C'];
                $diemGiuaKy = $sheetData[$row]['D'];

                // Chuyển MaSinhVien sang idSinhVien 
                $idSinhVien = $sinhVienMapping[$maSinhVien] ?? null;

                if ($idSinhVien) {
                    // Kiểm tra xem điểm đã tồn tại chưa
                    $checkQuery = "SELECT idDiem FROM diem WHERE idSinhVien = '$idSinhVien' AND idMonHoc = '$idMonHoc' AND idHocKy = '$idHocKy'";
                    $checkResult = mysqli_query($conn, $checkQuery);

                    if (mysqli_num_rows($checkResult) > 0) {
                        // Điểm đã tồn tại, thực hiện cập nhật
                        $updateQuery = "UPDATE diem SET DiemChuyenCan = '$diemChuyenCan', DiemGiuaKy = '$diemGiuaKy' WHERE idSinhVien = '$idSinhVien' AND idMonHoc = '$idMonHoc' AND idHocKy = '$idHocKy'";
                        $updateResult = mysqli_query($conn, $updateQuery);

                        if ($updateResult) {
                            echo "Cập nhật dữ liệu thành công cho sinh viên có mã: $maSinhVien<br>";
                        } else {
                            echo "Lỗi khi cập nhật dữ liệu cho sinh viên có mã: $maSinhVien - " . mysqli_error($conn);
                        }
                    } else {
                        // Điểm chưa tồn tại, thực hiện chèn mới
                        $insertQuery = "INSERT INTO diem (idSinhVien, idGiangVien, idMonHoc, idHocKy, DiemChuyenCan, DiemGiuaKy) VALUES ('$idSinhVien', '$idGiangVien', '$idMonHoc', '$idHocKy', '$diemChuyenCan', '$diemGiuaKy')";
                        $insertResult = mysqli_query($conn, $insertQuery);
                        if ($insertResult) {
                            $idDiemArray[] = mysqli_insert_id($conn);
                        }
                          // Kiểm tra và xử lý kết quả INSERT
                    if ($insertResult) {
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

                        if ($insertResult) {
                            echo "Thêm dữ liệu thành công cho sinh viên có mã: $maSinhVien<br>";
                        } else {
                            echo "Lỗi khi thêm dữ liệu cho sinh viên có mã: $maSinhVien - " . mysqli_error($conn);
                        }
                    }
                } else {
                    echo "Không tìm thấy ánh xạ cho MaSinhVien: $maSinhVien <br>";
                }
            }
            $_SESSION['idDiemArray'] = $idDiemArray; // Lưu trữ idDiem vào session
        } catch (Exception $e) {
            echo 'Lỗi khi đọc file Excel: ',  $e->getMessage(), "\n";
        }
    } else {
        echo "File không tồn tại hoặc không thể đọc được.";
    }
}

// Đảm bảo không có output trước khi redirect
header('Location: themdiem_SV.php');
exit;
?>
