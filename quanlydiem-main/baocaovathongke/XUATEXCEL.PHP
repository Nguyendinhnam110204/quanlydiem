<?php
require_once '../folderconnect/connect.php';
require_once '../Classes/Classes/PHPExcel.php';
require_once '../Classes/Classes/PHPExcel/IOFactory.php';
session_start();
//xuat excel
if(isset($_POST['btnxuatexcel']) && isset($_SESSION['idKhoa']) && isset($_SESSION['idHocKy'])){
    // code xuất excel
    $objExcel = new PHPExcel();
    $objExcel->setActiveSheetIndex(0);
    $sheet = $objExcel->getActiveSheet()->setTitle('DS Hoc Bong');//đặt tên cho sheet
    $rowCount = 1;
  // Tạo tiêu đề cho cột trong excel
   
    $sheet->setCellValue('A'.$rowCount,'Mã Sinh Viên');
    $sheet->setCellValue('B'.$rowCount,'Họ Và Tên');
    $sheet->setCellValue('C'.$rowCount,'Tên Lớp');
    $sheet->setCellValue('D'.$rowCount,'Học Kỳ');
    $sheet->setCellValue('E'.$rowCount,'GPA');
    // định dạng cột tiêu đề
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    // gán màu nền
    $sheet->getStyle('A1:E1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00FF00');
    // căn giữa tiêu đề
    $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   
    $idKhoa = $_SESSION['idKhoa'];
    $idHocKy = $_SESSION['idHocKy'];
    // Điền dữ liệu vào các dòng. Dữ liệu lấy từ DB
    $sql = "SELECT lop.*, khoa.*, sinhvien.*, gpa.*, hocky.*
    FROM lop
    JOIN khoa ON khoa.idKhoa = lop.idKhoa
    JOIN sinhvien ON lop.idLop = sinhvien.idLop
    JOIN gpa ON gpa.idSinhVien = sinhvien.idSinhVien
    JOIN hocky ON gpa.idHocKy = hocky.idHocKy
    WHERE lop.idKhoa = '$idKhoa' AND gpa.GPA < 4.0 AND gpa.GPA > 2.5  AND gpa.idHocKy = '$idHocKy'";
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
      $sheet->setCellValue('E'.$rowCount, $row['GPA']);
      
    }
    
    // Kẻ bảng 
    $styleAray = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );
    $sheet->getStyle('A1:'.'E'.($rowCount))->applyFromArray($styleAray);
    $fileName = 'Danh_sach_sinh_vien_được_hoc_bong.xlsx';
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