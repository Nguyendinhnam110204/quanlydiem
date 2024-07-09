<?php
require_once '../folderconnect/connect.php';
require_once '../Classes/Classes/PHPExcel.php';
require_once '../Classes/Classes/PHPExcel/IOFactory.php';
session_start();
//xuat excel
if(isset($_POST['btnxuatexcel_thilai']) && isset($_SESSION['idKhoa']) && isset($_SESSION['idHocKy'])){
  $idKhoa = $_SESSION['idKhoa'];
  $idhocky = $_SESSION['idHocKy'];
      // từ id suy ra tên Khoa tương ứng.
$sql_khoa = "SELECT * FROM khoa WHERE khoa.idKhoa = '$idKhoa'";
$result_Khoa = mysqli_query($conn,$sql_khoa);
while($row_khoa = mysqli_fetch_assoc($result_Khoa)){
    $Tenkhoa = $row_khoa['TenKhoa'];
}
    // từ id suy ra tên học kỳ tương ứng.
    $sql_hocky = "SELECT * FROM hocky WHERE hocky.idHocKy = '$idhocky'";
    $result_hocky = mysqli_query($conn,$sql_hocky);
    while($row_hocky = mysqli_fetch_assoc($result_hocky)){
        $NamHoc = $row_hocky['NamHoc'];
    }
    // code xuất excel
    $objExcel = new PHPExcel();
    $objExcel->setActiveSheetIndex(0);
    $sheet = $objExcel->getActiveSheet()->setTitle('DS THI LẠI');//đặt tên cho sheet
    // Tạo tiêu đề cho cột trong excel
   $sheet->setCellValue('A1', 'TRƯỜNG ĐẠI HỌC CÔNG NGHỆ GTVT');
   $sheet->setCellValue('E1', 'CỘNG HOÀ XÃ HỘI CHỦ NGHĨA VIỆT NAM');
   $sheet->setCellValue('A2', 'PHÒNG ĐÀO TẠO');
   $sheet->setCellValue('E2', 'Độc lập - Tự do - Hạnh phúc');

   $sheet->setCellValue('A4', 'DANH SÁCH SINH VIÊN THI LẠI');
   $sheet->setCellValue('A5', '(Kèm theo QĐ số...../QĐ-ĐHCNGTVT, ngày.....tháng.....năm.....)');
   $sheet->setCellValue('A6', $Tenkhoa);
   $sheet->setCellValue('E6', ' NĂM HỌC :'. $NamHoc);
   // Gộp các ô tiêu đề
   $sheet->mergeCells('A1:C1');
    $sheet->mergeCells('E1:H1');
    $sheet->mergeCells('A2:C2');
    $sheet->mergeCells('E2:H2');
    $sheet->mergeCells('A4:H4');
    $sheet->mergeCells('A5:H5');
    $sheet->mergeCells('A6:D6');
    $sheet->mergeCells('E6:H6');
   // Định dạng tiêu đề
   $sheet->getStyle('A1:H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   $sheet->getStyle('A1:H6')->getFont()->setBold(true);
    $rowCount = 8;
  // Tạo tiêu đề cho cột trong excel

    $sheet->setCellValue('A'.$rowCount,'Mã Sinh Viên');
    $sheet->setCellValue('B'.$rowCount,'Họ Và Tên');
    $sheet->setCellValue('C'.$rowCount,'Tên Lớp');
    $sheet->setCellValue('D'.$rowCount,'Năm Học');
    $sheet->setCellValue('E'.$rowCount,'Tổng Kết Học Phần');
    $sheet->setCellValue('F'.$rowCount,'Đánh Giá');
    // định dạng cột tiêu đề
    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);
    // gán màu nền
    $sheet->getStyle('A1:G1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFFFF');
    // căn giữa tiêu đề
    $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
   


    $idKhoa = $_SESSION['idKhoa'];
    $idHocKy = $_SESSION['idHocKy'];
    //$namHoc = $_POST['NamHoc'];
    // Điền dữ liệu vào các dòng. Dữ liệu lấy từ DB
    $sql = "SELECT lop.*, khoa.*, sinhvien.*, diem.*, hocky.*
        FROM lop
        JOIN khoa ON khoa.idKhoa = lop.idKhoa
        JOIN sinhvien ON lop.idLop = sinhvien.idLop
        JOIN diem ON diem.idSinhVien = sinhvien.idSinhVien
        JOIN hocky ON diem.idHocKy = hocky.idHocKy
        WHERE lop.idKhoa = '$idKhoa' AND diem.TongKetHocPhan < 4.0  AND diem.idHocKy = '$idHocKy'";
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
      $sheet->setCellValue('D'.$rowCount, $row['NamHoc']);
      $sheet->setCellValue('E'.$rowCount, $row['TongKetHocPhan']);
      $sheet->setCellValue('F'.$rowCount,$row['DanhGia'] );
      
    }
    // Căn giữa tất cả các ô từ hàng 2 đến hàng cuối cùng
   $highestRow = $sheet->getHighestRow(); // Lấy số hàng cao nhất có dữ liệu
    // Kẻ bảng 
    $styleAray = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );
    $sheet->getStyle('A8:'.'F'.($rowCount))->applyFromArray($styleAray);
    // Thêm phần  chữ ký ngày tháng năm
    $highestRow  = $highestRow + 2 ; // Lấy số hàng cao nhất có dữ liệu
     $sheet->mergeCells('D'.$highestRow.':F'.$highestRow);
 $sheet->setCellValue('D'.$highestRow, 'Ngày         tháng         năm');
$sheet->getStyle('A2:F' . $highestRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
 $highestRow++;
 $sheet->mergeCells('A'.$highestRow.':B'.$highestRow);
 $sheet->setCellValue('A'.$highestRow, 'NGƯỜI BÁO CÁO : ');
 $sheet->mergeCells('D'.$highestRow.':F'.$highestRow);
 $sheet->setCellValue('D'.$highestRow, 'HỌ TÊN, CHỮ KÝ NGƯỜI BÁO CÁO ');
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