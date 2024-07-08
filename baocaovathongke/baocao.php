<?php 
session_start();
require_once '../folderconnect/connect.php';
$vaiTro = $_SESSION['VaiTro'];
// Lấy dữ liệu từ bảng hocky
$sql_hocky = "SELECT * FROM hocky";
$result_hocky = mysqli_query($conn, $sql_hocky);

// Lấy dữ liệu từ bảng Khoa
$sql_Khoa = "SELECT * FROM Khoa";
$result_Khoa = mysqli_query($conn, $sql_Khoa);

$result = null;
$loaibaocao = '';
if(isset($_POST['Khoa']) && $_POST['Khoa'] != '0' && isset($_POST['NamHoc']) && isset($_POST['loaiBaoCao']) && isset($_POST['btntaobaocao'])){
    $idKhoa = $_POST['Khoa'];
    $idHocKy = $_POST['NamHoc'];
     $_SESSION['idKhoa'] = $_POST['Khoa'];
     $_SESSION['idHocKy'] = $_POST['NamHoc'];
    $loaibaocao = $_POST['loaiBaoCao'];
    if( $loaibaocao === 'hocbong'){
        $sql_hocbong = "SELECT lop.*, khoa.*, sinhvien.*, gpa.*, hocky.*
            FROM lop
            JOIN khoa ON khoa.idKhoa = lop.idKhoa
            JOIN sinhvien ON lop.idLop = sinhvien.idLop
            JOIN gpa ON gpa.idSinhVien = sinhvien.idSinhVien
            JOIN hocky ON gpa.idHocKy = hocky.idHocKy
            WHERE lop.idKhoa = '$idKhoa' AND gpa.GPA <= 4.0 AND gpa.GPA > 2.5  AND gpa.idHocKy = '$idHocKy'";
            $result_hocbong = mysqli_query($conn, $sql_hocbong);
    }
    else if($loaibaocao === 'thilai'){
        $sql_thilai = "SELECT lop.*, khoa.*, sinhvien.*, diem.*, hocky.*
        FROM lop
        JOIN khoa ON khoa.idKhoa = lop.idKhoa
        JOIN sinhvien ON lop.idLop = sinhvien.idLop
        JOIN diem ON diem.idSinhVien = sinhvien.idSinhVien
        JOIN hocky ON diem.idHocKy = hocky.idHocKy
        WHERE lop.idKhoa = '$idKhoa' AND diem.TongKetHocPhan < 4.0  AND diem.idHocKy = '$idHocKy'";
        $result_thilai = mysqli_query($conn, $sql_thilai);
    }
//     // Construct SQL query
//     $result = mysqli_query($conn, $sql);
//     //   // In ra số hàng trả về
//     // echo "Number of rows: " . mysqli_num_rows($result);

//    if (!$result) {
//         echo "Query error: " . mysqli_error($conn);}
//     // } else {
//     //     echo "Number of rows: " . mysqli_num_rows($result);
//     // }
}



mysqli_close($conn);
?>

<!DOCTYPE html>
<!--=== Coding by CodingLab | www.codinglabweb.com === -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../CSS/Admin_Style.css?v = <?php echo time(); ?>">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- bootrap 4  -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <title>Báo Cáo và Thống Kê</title> 
    <style>
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            border: 1px solid #000;
            font-family: Arial, sans-serif;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: inline-block;
            width: 150px;
            font-weight: bold;
        }
        .form-group select, .form-group input {
            width: calc(100% - 160px);
            padding: 5px;
        }
        .form-actions {
            text-align: center;
            margin-top: 20px;
        }
        .form-actions button {
            margin: 0 10px;
            padding: 10px 20px;
            font-size: 16px;
        }
        .form-actions button:hover{
            background-color: orange;

        }
        .full-width-table {
      width: 100%;
    }
    .full-width-table th, .full-width-table td {
      text-align: center;
      vertical-align: middle;/* Căn giữa theo chiều dọc */
    }
    .full-width-table th {
      background-color: #343a40;
      color: white;
    }
    .full-width-table thead tr th{
        text-align: center;
        vertical-align: middle; 
    }

    select option[disabled] {
            display: none;
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="http://utt.edu.vn/home/images/stories/logo-utt-border.png" alt="">
            </div>

            <span class="logo_name" style="color: orange;">UTT SCHOOL</span>
        </div>

        <div class="menu-items">
        <ul class="nav-links">
            <!-- Dành cho admin -->
            <?php if ($vaiTro == 'admin'): ?>
                <li><a href="../NguoiDung/index_NguoiDung.php">
                    <i class="uil uil-user"></i>
                    <span class="link-name">Tài khoản</span>
                </a></li>
                <li><a href="../sinhvien/Index_sinhvien.php">
                    <i class="uil uil-book-reader"></i>
                    <span class="link-name">Thông tin sinh viên</span>
                </a></li>
                <li><a href="../giangvien/Index_giangvien.php">
                    <i class="uil uil-file-info-alt"></i>
                    <span class="link-name">Thông tin giảng viên</span>
                </a></li>
                <li><a href="../MonHoc/index_MonHoc.php">
                    <i class="uil uil-subject"></i>
                    <span class="link-name">Môn học</span>
                </a></li>
                <li><a href="../Lop/Quan_ly_thong_tin_lop.php">
                    <i class="uil uil-book-open"></i>
                    <span class="link-name">Lớp</span>
                </a></li>
                <li><a href="../Khoa/Quan_ly_thong_tin_khoa.php">
                    <i class="uil uil-atom"></i>
                    <span class="link-name">Khoa ngành</span>
                </a></li>
                <li><a href="../Hedaotao/Quan_ly_he_dao_tao.php">
                    <i class="uil uil-books"></i>
                    <span class="link-name">Hệ đào tạo</span>
                </a></li>
                <li><a href="../Hocky/Quan_ly_hocky.php">
                    <i class="uil uil-bell-school"></i>
                    <span class="link-name">Học kỳ</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-analytics"></i>
                    <span class="link-name">Báo cáo và thống kê</span>
                </a></li>
                <?php endif; ?>


                    <!-- Dành cho giáo viên và admin -->
            <?php if ($vaiTro == 'giao_vien' ): ?>
                <li><a href="../themdiemsv_GV/themdiem_SV.php">
                    <i class="uil uil-table"></i>
                    <span class="link-name">Thêm điểm</span>
                </a></li>
                <li><a href="../bang_diem/bang_diem_sv.php">
                    <i class="uil uil-table"></i>
                    <span class="link-name">Cập Nhật điểm</span>
                </a></li>
              
                <?php endif; ?>
            </ul>
            
            <ul class="logout-mode">
                <li><a href="../Login/DangNhap_Index.php">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Đăng xuất</span>
                </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Chế độ</span>
                </a>

                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            
            <img src="../Img/profile.jpg" alt="">
        </div>

        <div class="dash-content">
            <!-- Chứa chi tiết các chức năng ở đây -->
            <!-- <input type="hidden" id="loaibaocao" name="txtbaocao" value = ""> -->
            <input type="hidden" name = "txtloaibaocao" id ="txtloaibaocao" value="<?php echo $loaibaocao ; ?>">
<div class="container">
        <h1>Báo Cáo và Thống Kê</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="NamHoc">Năm Học:</label>
                <select id="NamHoc" name="NamHoc">
                    <option value="0">---</option>
                    <?php 
                    while($rows = mysqli_fetch_assoc($result_hocky)){
                      ?>
                      <option value="<?php echo $rows['idHocKy']; ?>"><?php echo $rows['NamHoc']; ?></option>
                      <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Khoa">Khoa:</label>
                <select class="form-control" id="Khoa" name="Khoa">
                    <option value="0">---</option>
                    <?php 
                    while($rows = mysqli_fetch_assoc($result_Khoa)){
                      ?>
                      <option value="<?php echo $rows['idKhoa']; ?>"><?php echo $rows['TenKhoa']; ?></option>
                      <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="loaiBaoCao">Loại Báo Cáo:</label>
                <select id="loaiBaoCao" name="loaiBaoCao">
                    <option value="0">---</option>
                    <option value="thilai">Báo Cáo Sinh Viên phải thi lại</option>
                    <option value="hocbong">Báo Cáo Sinh Viên ĐƯỢC HỌC BỔNG</option>
                    <!-- Thêm các loại báo cáo khác ở đây -->
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" name = "btntaobaocao">Tạo Báo Cáo</button>
                <button type="button" onclick="showResults()">Hiện ra</button>
            </div>
        </form>
        <form action="XUATEXCEL.PHP" method="post" >
          <div id="ketQuahocbong" style="display: none;">
            <h2>Kết Quả</h2>
            <?php if ($result_hocbong && mysqli_num_rows($result_hocbong) > 0) : ?>
                <table class="table table-bordered table-striped full-width-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Mã Sinh Viên</th>
                            <th>Họ Và Tên</th>
                            <th>Tên Lớp</th>
                            <th>Năm Học</th>
                            <th>GPA</th>
                            <th>Loại Học Bổng</th>
                        </tr>
                    </thead>
                    <tbody>    
                        <?php while ($row = mysqli_fetch_assoc($result_hocbong)) :
                            
                            $gpa = $row['GPA'];
                            if($gpa >= 3.6 && $gpa <= 4.0){
                                $loaiHocBong = 'Xuất Sắc';
                            }elseif($gpa >= 3.2 && $gpa <= 3.59){
                                $loaiHocBong = 'Giỏi';
                            }
                            elseif($gpa >= 2.5 && $gpa <= 3.19){
                                $loaiHocBong = 'Khá';
                            }

                            ?>
                        <tr>
                            <td><?php echo $row['MaSinhVien']; ?></td>
                            <td><?php echo $row['HoTen']; ?></td>
                            <td><?php echo $row['TenLop']; ?></td>
                            <td><?php echo $row['NamHoc']; ?></td>
                            <td><?php echo $row['GPA']; ?></td>
                            <td><?php echo $loaiHocBong; ?></td>
                        </tr>
                        <?php endwhile; ?>    
                    </tbody>
                </table>
            <?php else : ?>
                <p>Không tìm thấy kết quả mong đợi.</p>
            <?php endif; ?>
             <div class="form-actions">
             <button type="submit" name="btnxuatexcel"
             >Xuất Excel</button>
             </div>
         </div>
        </form>
   
        <form action="xuatexcelsvthilai.php" method="post">
           <div id="ketQuathilai" style="display: none;" >
           <h2>Kết Quả</h2>
            <?php if ($result_thilai && mysqli_num_rows($result_thilai) > 0) : ?>
                <table class="table table-bordered table-striped full-width-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Mã Sinh Viên</th>
                            <th>Họ Và Tên</th>
                            <th>Tên Lớp</th>
                            <th>Năm Học</th>
                            <th>Tổng Kết Học Phần</th>
                            <th>Đánh Giá</th>
                        </tr>
                    </thead>
                    <tbody>    
                        <?php while ($rows = mysqli_fetch_assoc($result_thilai)) : ?>
                        <tr>
                            <td><?php echo $rows['MaSinhVien']; ?></td>
                            <td><?php echo $rows['HoTen']; ?></td>
                            <td><?php echo $rows['TenLop']; ?></td>
                            <td><?php echo $rows['NamHoc']; ?></td>
                            <td><?php echo $rows['TongKetHocPhan']; ?></td>
                            <td><?php echo $rows['DanhGia']; ?></td>
                        </tr>
                        <?php endwhile; ?>    
                    </tbody>
                </table>
            <?php else : ?>
                <p>Không tìm thấy kết quả mong đợi.</p>
            <?php endif; ?>
            <div class="form-actions">
             <button type="submit" name="btnxuatexcel_thilai">Xuất Excel</button>
            </div>
           </div> 
        </form>
         </div>
 </div>
    </section>
    <script src="../JS/Admin_Script.js"></script>

    <script>
        function showResults() {
            const loaibaocao = document.getElementById('txtloaibaocao').value;
            var resultsDiv = document.getElementById('ketQuahocbong');
            var resultsDivthilai = document.getElementById('ketQuathilai');
            if(loaibaocao === 'hocbong'){
                resultsDivthilai.style.display = 'none';    
            resultsDiv.style.display = 'block';
            }
            else if(loaibaocao === 'thilai'){
                resultsDivthilai.style.display = 'block';    
                resultsDiv.style.display = 'none';
            }
        }
    </script>
</body>
</html>

