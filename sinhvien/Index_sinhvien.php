<?php 
session_start();
$vaiTro = $_SESSION['VaiTro'];
if (!isset($_SESSION['VaiTro'])) {
    // Chưa đăng nhập
    echo "<script>
            alert('Bạn chưa đăng nhập.');
            window.location.href = '../Login/DangNhap_Index.php';
        </script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../CSS/Admin_Style.css?v=<?php echo time(); ?>">
     
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
            <!-- Dành cho admin -->
            <?php if ($vaiTro == 'admin'): ?>
                <li><a href="../NguoiDung/index_NguoiDung.php">
                    <i class="uil uil-user"></i>
                    <span class="link-name">Tài khoản</span>
                </a></li>
                <li><a href="#">
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
                <li><a href="../baocaovathongke/baocao.php">
                    <i class="uil uil-analytics"></i>
                    <span class="link-name">Báo cáo và thống kê</span>
                </a></li>
                <?php endif; ?>

                <!-- Dành cho giáo viên và admin -->
            <?php if ($vaiTro == 'giao_vien'): ?>
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

            <img src="./Img/profile.jpg" alt="">
        </div>

        <div class="dash-content">
            <!-- Chứa chi tiết các chức năng ở đây -->
            <?php
            // Kết nối
            require_once '../folderconnect/connect.php';
            // Câu lệnh
            $lietke_sql = "SELECT sv.*, l.MaLop FROM sinhvien sv JOIN lop l ON sv.idLop = l.idLop ORDER BY sv.idSinhVien";
            // Thực thi câu lệnh
            $result = mysqli_query($conn, $lietke_sql);
            // Duyệt qua result và in ra
            if (isset($_POST['timkiem'])) {
                $ma = $_POST['ma'];
                $ten = $_POST['ten'];
                $result = mysqli_query($conn, "SELECT sv.*, l.MaLop FROM sinhvien sv JOIN lop l ON sv.idLop = l.idLop WHERE sv.MaSinhVien LIKE '%$ma%' AND sv.HoTen LIKE '%$ten%'");
            }
            mysqli_close($conn);
            ?>
            <div class="container">
                <h1>Danh sách sinh viên</h1>
                <a href="Insert_sinhvien.php" class="btn btn-outline-primary">Thêm</a>
                <form method="post">
                    <div style="text-align:right;">
                        <input type="text" name="ten" placeholder="Tên sinh viên">
                        <input type="text" name="ma" placeholder="Mã">
                        <button type="submit" class="btn btn-secondary" name="timkiem">Tìm kiếm</button>
                    </div>
                </form>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Mã sinh viên</th>
                            <th>Mã lớp</th>
                            <th>Họ tên</th>
                            <th>Ngày sinh</th>
                            <th>Địa chỉ</th>
                            <th>Email</th>
                            <th>Điện thoại</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($result) && mysqli_num_rows($result) > 0) {
                            while ($r = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $r['MaSinhVien']; ?></td>
                                    <td><?php echo $r['MaLop']; ?></td>
                                    <td><?php echo $r['HoTen']; ?></td>
                                    <td><?php echo $r['NgaySinh']; ?></td>
                                    <td><?php echo $r['DiaChi']; ?></td>
                                    <td><?php echo $r['Email']; ?></td>
                                    <td><?php echo $r['DienThoai']; ?></td>
                                    <td>
                                        <a href="Update_sinhvien.php?sid=<?php echo $r['idSinhVien']; ?>" class="btn btn-info">Sửa</a>
                                        <a onclick="return confirm('Bạn có muốn xóa không');" href="xoa_sinhvien.php?sid=<?php echo $r['idSinhVien']; ?>" class="btn btn-danger">Xóa</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script src="../JS/Admin_Script.js"></script>
    
</body>
</html>