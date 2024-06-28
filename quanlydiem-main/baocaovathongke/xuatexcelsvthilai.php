<?php
require_once '../folderconnect/connect.php';
require_once '../Classes/Classes/PHPExcel.php';
require_once '../Classes/Classes/PHPExcel/IOFactory.php';
session_start();
//xuat excel
$tieudebaocao = '';
if(isset($_POST['btnxuatexcel_thilai']) && isset($_SESSION['idKhoa']) && isset($_SESSION['idHocKy']) && isset($_POST['namHoc'])){
    // code xuất excel
    $objExcel = new PHPExcel();
    $objExcel->setActiveSheetIndex(0);
    $sheet = $objExcel->getActiveSheet()->setTitle('DS HOC BONG');//đặt tên cho sheet
    $rowCount = 1;
  // Tạo tiêu đề cho cột trong excel
   
    $sheet->setCellValue('A'.$rowCount,'Mã Sinh Viên');
    $sheet->setCellValue('B'.$rowCount,'Họ Và Tên');
    $sheet->setCellValue('C'.$rowCount,'Tên Lớp');
    $sheet->setCellValue('D'.$rowCount,'Học Kỳ');
    $sheet->setCellValue('E'.$rowCount,'Tổng Kết Học Phần');
    $sheet->setCellValue('F'.$rowCount,'Năm Học');
    // định dạng cột tiêu đề
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);
    // gán màu nền
    $sheet->getStyle('A1:F1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00FF00');
    // căn giữa tiêu đề
    $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   
    $idKhoa = $_SESSION['idKhoa'];
    $idHocKy = $_SESSION['idHocKy'];
    $namHoc = $_POST['namHoc'];
    // Điền dữ liệu vào các dòng. Dữ liệu lấy từ DB
    $sql = "SELECT lop.*, khoa.*, sinhvien.*, hocky.*, diem.*
                       FROM lop
                       JOIN khoa ON khoa.idKhoa = lop.idKhoa
                       JOIN sinhvien ON lop.idLop = sinhvien.idLop
                       JOIN diem ON diem.idSinhVien = sinhvien.idSinhVien
                       JOIN hocky ON diem.idHocKy = hocky.idHocKy
                       WHERE lop.idKhoa = '$idKhoa' 
                       AND diem.idHocKy = '$idHocKy' 
                       AND diem.TongKetHocPhan < 4.0 
                       AND hocky.namHoc = '$namHoc'";
    $result_excel = mysqli_query($conn, $sql); 
    // Kiểm tra xem truy vấn có thành công không
    if (!$result_excel) {
        die('Query failed: ' . mysqli_error($conn));  
    }
  
    while($row = mysqli_fetch_array($result_excel)){
      $rowCount++;
      $sheet->setCellValue('A'.$rowCount, $row['MaSinhVien']);
      $sheet->setCellValue('B'.$rowCount, $row['HoTen']);
      $sheet->setCellValue('C'.$rowCount, $row['TenLop']);
      $sheet->setCellValue('D'.$rowCount, $row['TenHocKy']);
      $sheet->setCellValue('E'.$rowCount, $row['TongKetHocPhan']);
      $sheet->setCellValue('F'.$rowCount, $namHoc);
      
    }
    
    // Kẻ bảng 
    $styleAray = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );
    $sheet->getStyle('A1:'.'F'.($rowCount))->applyFromArray($styleAray);
    $fileName = 'Danh_sach_sinh_vien_THI_LAI.xlsx';
    $objWriter = new PHPExcel_Writer_Excel2007($objExcel);
    $objWriter->save($fileName);
    
    if (file_exists($fileName)) {
      header('Content-Disposition: attachment; filename="' . $fileName . '"');
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Length: ' . filesize($fileName));
      header('Content-Transfer-Encoding: binary');
      header('Cache-Control: must-revalidate');
      header('Pragma: no-cache');
      readfile($fileName);
      unlink($fileName); // Xóa tệp sau khi tải xuống
      exit;
    } else {
      echo 'File not found';
    }
  }
  mysqli_close($conn);

?>