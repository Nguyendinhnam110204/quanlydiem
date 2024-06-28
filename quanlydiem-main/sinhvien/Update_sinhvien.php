<?php
// Lấy id của sinh viên cần chỉnh sửa từ URL
$ma = $_GET['sid'];

// Kết nối tới CSDL
require_once '../folderconnect/connect.php';

// Truy vấn để lấy thông tin sinh viên
$edit_sql = "SELECT * FROM sinhvien WHERE idSinhVien = '$ma'";
$result = mysqli_query($conn, $edit_sql);
$row = mysqli_fetch_assoc($result);

// Kiểm tra nếu không có kết quả
if (!$row) {
    die("Không tìm thấy sinh viên với id: $ma");
}
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
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Admin</title> 
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
                <li><a href="#">
                    <i class="uil uil-table"></i>
                    <span class="link-name">Bảng điểm</span>
                </a></li>
                <li><a href="Index_sinhvien.php">
                    <i class="uil uil-book-reader"></i>
                    <span class="link-name">Thông tin sinh viên</span>
                </a></li>
                <li><a href="Index_giangvien.php">
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
            
            <img src="./Img/profile.jpg" alt="">
        </div>

        <div class="dash-content">
        <h1>Sửa sinh viên</h1>
        <form action="sua_sinhvien.php" method="post">
            <div class="form-group">
            <input type="hidden" name="sid" value="<?php echo $row['idSinhVien']; ?>">
                <label for="">Mã sinh viên</label>
                <input type="text" id="MaSinhVien" name="MaSinhVien" class="form-control" value="<?php echo $row['MaSinhVien']?>">
            </div>
            <div class="form-group">
                <label for="">Mã lớp</label>
                <input type="text" name="idlop" id="idlop" class="form-control" value="<?php echo $row['idLop']?>">
            </div>
            <div class="form-group">
                <label for="">Họ Tên</label>
                <input type="text" name="HoTen" id="HoTen" class="form-control" value="<?php echo $row['HoTen']?>">
            </div>
            <div class="form-group">
                <label for="">Ngày Sinh</label>
                <input type="date" id="NgaySinh" name="NgaySinh" class="form-control" value="<?php echo $row['NgaySinh']?>">
            </div>
            <div class="form-group">
                <label for="">Địa chỉ</label>
                <input type="text" id="DiaChi" name="DiaChi" class="form-control" value="<?php echo $row['DiaChi']?>">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" id="Email" name="Email" class="form-control" value="<?php echo $row['Email']?>">
            </div>
            <div class="form-group">
                <label for="">Điện thoại</label>
                <input type="text" id="DienThoai" name="DienThoai" class="form-control" value="<?php echo $row['DienThoai']?>">
            </div>
            <button class="btn btn-success">Thêm</button>
            <a href="Index_sinhvien.php" class="btn btn-danger">Thoát</a>
        </form>
        </div>
    </section>

    <script src="../JS/Admin_Script.js"></script>
</body>
</html>