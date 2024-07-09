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
    require_once '../folderconnect/connect.php';
    $idKhoa = $_GET['idKhoa'];
    
    // Fetch the specific department (khoa) based on idKhoa
    $edit_sql = "SELECT * FROM khoamonhoc WHERE idKhoa='$idKhoa'";
    $result_edit = mysqli_query($conn, $edit_sql);

    // Display subjects (monhoc) based on the department (khoa)
    $hienthi_sql = "SELECT khoamonhoc.idKhoa, khoamonhoc.idMonHoc, khoa.TenKhoa, monhoc.TenMonHoc, monhoc.MaMonHoc, monhoc.SoTinChi
                    FROM khoamonhoc
                    JOIN khoa ON khoamonhoc.idKhoa = khoa.idKhoa
                    JOIN monhoc ON khoamonhoc.idMonHoc = monhoc.idMonHoc
                    WHERE khoamonhoc.idKhoa='$idKhoa'";
    $result_hienthi = mysqli_query($conn, $hienthi_sql);

    if (isset($_POST['btntk'])) {
        $mtenmon = $_POST['tktenmon'];
        $sqltk = "SELECT khoamonhoc.idKhoa, khoamonhoc.idMonHoc, khoa.TenKhoa, monhoc.TenMonHoc, monhoc.MaMonHoc, monhoc.SoTinChi
                  FROM khoamonhoc
                  JOIN khoa ON khoamonhoc.idKhoa = khoa.idKhoa
                  JOIN monhoc ON khoamonhoc.idMonHoc = monhoc.idMonHoc
                  WHERE monhoc.TenMonHoc LIKE '%$mtenmon%'
                  AND khoamonhoc.idKhoa='$idKhoa'";
        $result_tk = mysqli_query($conn, $sqltk);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="../CSS/Admin_Style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <li><a href="../baocaovathongke/baocao.php">
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

    
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <img src="./Img/profile.jpg" alt="">
        </div>
        <div class="dash-content">
            <div class="container">
                            <h2 class="text-center my-4">
                    <?php 
                    if (isset($result_hienthi)) {
                        $row_khoa = mysqli_fetch_assoc($result_hienthi);
                        echo "Quản lý môn học của  " . $row_khoa['TenKhoa'];
                    } elseif (isset($result_tk)) {
                        $row_khoa = mysqli_fetch_assoc($result_tk);
                        echo "Quản lý môn học của  " . $row_khoa['TenKhoa'];
                    } else {
                        echo "Quản lý môn học";
                    }
                    ?>
                </h2>
                <div class="input-group mb-3" style="margin-top: 50px; width: 400px;">
                    <form action="" method="POST" style="display: flex; width: 100%;">
                        <input type="search" class="form-control" placeholder="Tên môn học" name="tktenmon">&nbsp;
                        <div class="input-group-append">
                            <button class="btn btn-success" name="btntk" type="submit" style="width: 100px;">Tìm Kiếm</button>
                        </div>
                    </form>
                </div><br>
                <table class="table" style="margin: -15px 0 0 -10px; width: 100%">
                    <thead class="thead-dark">
                        <tr style="text-align: center;">
                            <th scope="col">Mã môn học</th>
                            <th scope="col">Tên môn học</th>
                            <th scope="col">Số tín chỉ</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        <?php 
                        if (isset($result_tk)) {
                            while ($r = mysqli_fetch_assoc($result_tk)) { ?>
                                <tr>
                                    <td><?php echo $r['MaMonHoc']; ?></td>
                                    <td><?php echo $r['TenMonHoc']; ?></td>
                                    <td><?php echo $r['SoTinChi']; ?></td>
                                    <td><a onclick="return confirm('Bạn có muốn xóa không?');" href="../Khoa/Xoa_khoamonhoc.php?idMonHoc=<?php echo $r['idMonHoc'];?>&idKhoa=<?php echo $idKhoa;?>" class="btn btn-danger">Xóa</a></td>
                                </tr>
                        <?php } } else {
                            while ($r = mysqli_fetch_assoc($result_hienthi)) { ?>
                                <tr>
                                    <td><?php echo $r['MaMonHoc']; ?></td>
                                    <td><?php echo $r['TenMonHoc']; ?></td>
                                    <td><?php echo $r['SoTinChi']; ?></td>
                                    <td><a onclick="return confirm('Bạn có muốn xóa không?');" href="../Khoa/Xoa_khoamonhoc.php?idMonHoc=<?php echo $r['idMonHoc'];?>&idKhoa=<?php echo $idKhoa;?>" class="btn btn-danger">Xóa</a></td>
                                </tr>
                        <?php } } ?>
                        <tr>
                            <td colspan="4"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Thêm</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" style="font-family: 'Times New Roman', Times, serif;">Thêm Môn học</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form action="Them_khoamonhoc.php" method="post">
                                <input type="hidden" class="form-control" id="idKhoa" name="idKhoa" value="<?php echo $idKhoa; ?>">
                                <div class="form-group">
                                    <label for="idMonHoc">Tên môn học:</label>
                                    <select class="form-control" id="idMonHoc" name="idMonHoc">
                                        <?php
                                        $sql = "SELECT idMonHoc, TenMonHoc FROM monhoc";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row["idMonHoc"] . '">' . $row["TenMonHoc"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Thêm</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-left: 275px;">Đóng</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="./JS/Admin_Script.js"></script>
</body>
</html>