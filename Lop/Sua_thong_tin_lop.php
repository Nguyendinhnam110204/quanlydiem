<?php
require_once '../folderconnect/connect.php';
$idLop=$_GET['idLop'];
$edit_sql="SELECT * FROM lop WHERE idLop='$idLop'";
$result = mysqli_query($conn,$edit_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <li><a href="./MonHoc/index_MonHoc.php">
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
            </ul>
            
            <ul class="logout-mode">
                <li><a href="./Login/DangXuat.php">
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

            <img src="./Img/profile.jpg" alt="Avatar" style="margin-right: 50px;">
        </div>

        <div class="dash-content">
        <div class="container" style="width: 1200px;">
                    <h2 style="text-align: center;padding-top: 20px;">FORM SỬA LỚP</h2>
            <?php 
                if(isset($result) && mysqli_num_rows($result)>0){
                    while($r = mysqli_fetch_assoc($result)){
                ?>
                </div>
            <form class="row g-3" style="margin-top: 30px;" action="Sua_lop.php" method="POST">
            <div class="col-md-6">
                    <label for="idLop" class="form-label">ID:</label>
                    <input type="text" class="form-control" id="idLop" readonly name="txtidLop" value="<?php echo $r['idLop']; ?>">
                </div>
                <div class="col-md-6">
                    <label for="MaLop" class="form-label">Mã lớp:</label>
                    <input type="text" class="form-control" id="MaLop" name="txtMaLop" value="<?php echo $r['MaLop']; ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="TenLop" class="form-label">Tên lớp:</label>
                    <input type="text" class="form-control" id="TenLop" name="txtTenLop" value="<?php echo $r['TenLop']; ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="idKhoa" class="form-label">Khoa:</label>
                    <select class="form-control" id="idKhoa" name="sidKhoa" value="<?php echo $r['TenKhoa']; ?>">
                        <?php
                        $sql = "SELECT idKhoa, TenKhoa FROM khoa";
                        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row["idKhoa"] . '">' . $row["TenKhoa"] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="idHeDT" class="form-label">Hệ đào tạo:</label>
                    <select class="form-control" id="idHeDT" name="sidHeDT" value="<?php echo $r['TenHeDT']; ?>">
                        <?php
                        $sql = "SELECT idHeDT, TenHeDT FROM hedaotao";
                        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row["idHeDT"] . '">' . $row["TenHeDT"] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="idGiangvien" class="form-label">Giảng viên:</label>
                    <select class="form-control" id="idGiangvien" name="sidGiangvien" value="<?php echo $r['Hoten']; ?>">
                        <?php
                        $sql = "SELECT idGiangvien, Hoten FROM giangvien";
                        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row["idGiangvien"] . '">' . $row["Hoten"] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <?php
                }
            }
            ?>
            <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary" style="margin-top: 30px;text-align: center;">Sửa</button>
            </div>
            </form>
        </div>
        </div>
    </section>

</body>
</html>