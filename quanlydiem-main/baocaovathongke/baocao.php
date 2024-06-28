<?php 
session_start();
require_once '../folderconnect/connect.php';

// Fetch hocky data
$sql_hocky = "SELECT * FROM hocky";
$result_hocky = mysqli_query($conn, $sql_hocky);

// Fetch Khoa data
$sql_Khoa = "SELECT * FROM Khoa";
$result_Khoa = mysqli_query($conn, $sql_Khoa);

$result = null;

if(isset($_POST['Khoa']) && $_POST['Khoa'] != '0' && isset($_POST['hocKy'])){
    $idKhoa = $_POST['Khoa'];
    $idHocKy = $_POST['hocKy'];
    $_SESSION['idKhoa'] = $_POST['Khoa'];
    $_SESSION['idHocKy'] = $_POST['hocKy'];
    // Construct SQL query
    $sql = "SELECT lop.*, khoa.*, sinhvien.*, gpa.*, hocky.*
            FROM lop
            JOIN khoa ON khoa.idKhoa = lop.idKhoa
            JOIN sinhvien ON lop.idLop = sinhvien.idLop
            JOIN gpa ON gpa.idSinhVien = sinhvien.idSinhVien
            JOIN hocky ON gpa.idHocKy = hocky.idHocKy
            WHERE lop.idKhoa = '$idKhoa' AND gpa.GPA < 4.0 AND gpa.GPA > 2.5  AND gpa.idHocKy = '$idHocKy'";
    $result = mysqli_query($conn, $sql);
    
    if (!$result) {
        // Handle MySQL query error
        echo "Query error: " . mysqli_error($conn);
    }
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
                <li><a href="#">
                    <i class="uil uil-user"></i>
                    <span class="link-name">Tài khoản</span>
                </a></li>
                <li><a href="">
                    <i class="uil uil-table"></i>
                    <span class="link-name">Bảng điểm</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-book-reader"></i>
                    <span class="link-name">Thông tin sinh viên</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-file-info-alt"></i>
                    <span class="link-name">Thông tin giáo viên</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-subject"></i>
                    <span class="link-name">Môn học</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-atom"></i>
                    <span class="link-name">Khoa ngành</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-bell-school"></i>
                    <span class="link-name">Học kỳ</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-analytics"></i>
                    <span class="link-name">Báo cáo và thống kê</span>
                </a></li>
            </ul>
            
            <ul class="logout-mode">
                <li><a href="#">
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

            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Tìm kiếm...">
            </div>
            
            <img src="../Img/profile.jpg" alt="">
        </div>

        <div class="dash-content">
            <!-- Chứa chi tiết các chức năng ở đây -->
<div class="container">
        <h1>Báo Cáo và Thống Kê</h1>
        <form action="#" method="POST">
            <div class="form-group">
                <label for="hocKy">Học kỳ:</label>
                <select id="hocKy" name="hocKy">
                    <option value="0">---</option>
                    <?php 
                    while($rows = mysqli_fetch_assoc($result_hocky)){
                      ?>
                      <option value="<?php echo $rows['idHocKy']; ?>"><?php echo $rows['TenHocKy']; ?></option>
                      <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="monHoc">Môn học:</label>
                <select id="monHoc" name="monHoc">
                    <option value="0">---</option>
                    <!-- Thêm các môn học khác ở đây -->
                </select>
            </div>

            <div class="form-group">
                <label for="namHoc">Năm học:</label>
                <select class="form-control" id="namHoc" name="namHoc">
                    <option value="0">---</option>
                    <option value="2023-2024_1">2023-2024_1</option>
                    <option value="2023-2024_2">2023-2024_2</option>
                    <option value="2024">2024</option>
                    
                    <!-- Add more options as needed -->
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
                    <option value="thiLai">Báo Cáo Sinh Viên phải thi lại</option>
                    <!-- Thêm các loại báo cáo khác ở đây -->
                </select>
            </div>

            <div class="form-group">
                <label for="loaiThongKe">Loại Thống Kê:</label>
                <select id="loaiThongKe" name="loaiThongKe">
                    <option value="tongQuat">Thống Kê Tổng Quát</option>
                    <!-- Thêm các loại thống kê khác ở đây -->
                </select>
            </div>

            <div class="form-actions">
                <button type="submit">Tạo Báo Cáo</button>
                <button type="reset">Làm Mới</button>
                <button type="button" onclick="showResults()">Liệt Kê</button>
            </div>
        </form>
        <form action="XUATEXCEL.PHP" method="post" >
<div id="ketQua" style="display: none;">
            <h2>Kết Quả</h2>
            <?php if ($result && mysqli_num_rows($result) > 0) : ?>
                <table class="table table-bordered table-striped full-width-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Mã Sinh Viên</th>
                            <th>Họ Và Tên</th>
                            <th>Tên Lớp</th>
                            <th>Học kỳ</th>
                            <th>GPA</th>
                        </tr>
                    </thead>
                    <tbody>    
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo $row['MaSinhVien']; ?></td>
                            <td><?php echo $row['HoTen']; ?></td>
                            <td><?php echo $row['TenLop']; ?></td>
                            <td><?php echo $row['TenHocKy']; ?></td>
                            <td><?php echo $row['GPA']; ?></td>
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
    </div>
        </div>
    </section>
    <script src="../JS/Admin_Script.js"></script>
    <script>
        function showResults() {
            var resultsDiv = document.getElementById('ketQua');
            resultsDiv.style.display = 'block';
        }
    </script>
</body>
</html>

