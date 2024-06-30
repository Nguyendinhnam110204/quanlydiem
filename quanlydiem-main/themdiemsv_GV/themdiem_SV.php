<?php
session_start();
$vaiTro = $_SESSION['VaiTro'];
require_once '../folderconnect/connect.php';

$sql_hocky ="SELECT * FROM hocky";
$result = mysqli_query($conn,$sql_hocky);

// $sql_namhoc ="SELECT diem.NamHoc FROM diem";
// $result_namhoc  = mysqli_query($conn,$sql_namhoc);

$sql_giangvien = "SELECT * FROM giangvien";
$result_giangvien = mysqli_query($conn,$sql_giangvien);

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
     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
<!-- bootrap 4  -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <title>Admin</title>
    
    <style>
        .dash-content {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding-top: 30px;
        }
        h3 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 10px;
            vertical-align: top;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
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
                <?php endif; ?>


                <!-- Dành cho giáo viên và admin -->
            <?php if ($vaiTro == 'giao_vien' || $vaiTro == 'admin'): ?>
                <li><a href="#">
                    <i class="uil uil-table"></i>
                    <span class="link-name">Bảng điểm</span>
                </a></li>
                <li><a href="../baocaovathongke/baocao.php">
                    <i class="uil uil-analytics"></i>
                    <span class="link-name">Báo cáo và thống kê</span>
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
        <h3>Nhập điểm</h3>
        <form action="nhaptuexcel.php" method="post" enctype="multipart/form-data">
            <table>
            <tr>
                <td>
                    <h4>Thông tin chung</h4>
                    <div class="form-group">
                        <label for="hocKy">Học kỳ:</label>
                         <select class="form-control" id="hocKy" name="hocKy"> 
                            <option value="0">---</option>
                            <!-- Add more options as needed -->
                            <?php 
                             while($row_hocky = mysqli_fetch_assoc($result)){

                                echo '<option value=" '.$row_hocky['idHocKy'].'"> '.$row_hocky['TenHocKy'].' </option>';
                             }
                             
                             ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="namHoc">Năm học:</label>
                        <select class="form-control" id="namHoc" name="namHoc">
                            <option value="0">---</option>
                            <option value="2022-2023_1">2022-2023_1</option>
                            <option value="2023-2024_2">2023-2024_2</option>
                            <option value="2024-2025_1">2024-2025_1</option>
                            <option value="2024-2025_2">2024-2025_2</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="giangVien">Giảng viên:</label>
                        <select class="form-control" id="giangVien" name="giangVien" >
                            <option value="0">---</option>
                            <!-- Add more options as needed -->
                             <?php 
                             while($row_giangvien = mysqli_fetch_assoc($result_giangvien)){

                                echo '<option value=" '.$row_giangvien['idGiangVien']. '"> '.$row_giangvien['HoTen'].' </option>';
                             }
                             
                             ?>
                        </select>
                    </div>
                    
                </td>
                <td>
                    <h4>Thông tin môn học</h4>
                    <div class="form-group">
                        <label for="monHoc">Môn học:</label>
                        <select class="form-control" id="monHoc" name="monHoc">
                            <option value="0">---</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="soTinChi">Số tín chỉ:</label>
                        <select class="form-control" id="soTinChi" name="soTinChi">
                            <option value="0">---</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lop">Lớp:</label>
                        <select class="form-control" id="lop" name="lop">
                            <option value="0">---</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                </td>
            </tr>
        </table>
        <div class="center-container">
                <div class="excel">
                    <label for="fileUpload" style="margin-right:20px;">Chọn file:</label>
                    <input type="file" class="control-file" id="fileUpload" name="fileUpload">
                </div>
                <button type="submit" class="btn btn-primary" name="btn_xuat_excel" style="margin-top: 10px;">Nhập điểm</button>
            </div>
        </form>
        </div>
    </section>
    <script src="../JS/Admin_Script.js"></script>
    <script>
        $(document).ready(function(){
            $("#giangVien").change(function () {
                var idGiangVien = $(this).val();
                $.post("../timkiem/loclop.php", { idGiangVien: idGiangVien }, function (data) {
                    $("#lop").html(data);
                });
            });
        });


        $(document).ready(function(){
            $("#giangVien").change(function () {
                var idGiangVien = $(this).val();
                $.post("../timkiem/locmonhoc.php", { idGiangVien: idGiangVien }, function (data) {
                    $("#monHoc").html(data);
                });
            });
        });

    </script>

</body>
</html>