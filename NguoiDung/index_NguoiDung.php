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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Admin</title>
    <style>
        * {
            font-family: "Ubuntu", sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
            
            <img src="../Img/profile.jpg" alt="Avatar" style="margin-right: 50px;">
        </div>

        <div class="dash-content" style="margin-top: 20px;">
            <div class="container" style=" text-align:center" >
            <h1 style="font-family: 'Times New Roman', Times, serif;"><b>Quản lý Người dùng</b></h1>

            <div class="input-group mb-3" style="margin-top: 50px; width: 400px;">
                <form action="index_NguoiDung.php" method="get" style="display: flex; width: 100%;">
                    <input type="search" class="form-control" placeholder="Search" name="searchTerm">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit" style="width: 100px;">Tìm Kiếm</button>
                    </div>
                </form>
            </div>

            <br>
            <table class="table" style="margin: -15px 0 0 -10px; width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th>Tên đăng nhập</th>
                        <th>Mât khẩu</th>
                        <th>Vai trò</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //ketnoi
                        require_once '../folderconnect/connect.php';
                        // Câu lệnh SQL

                        // Câu lệnh SQL có điều kiện tìm kiếm
                        $searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

                        // Số môn học trên mỗi trang
                        $limit = 6;

                        // Trang hiện tại, mặc định là trang 1
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

                        // Tính offset
                        $offset = ($current_page - 1) * $limit;

                        // Câu lệnh SQL có điều kiện tìm kiếm
                        if ($searchTerm) {
                            $count_sql = "SELECT COUNT(*) AS total FROM nguoidung";
                            $list_sql = "SELECT * FROM nguoidung WHERE TenDangNhap
                                         LIKE '%$searchTerm%'
                                         ORDER BY VaiTro, TenDangNhap
                                         LIMIT $limit OFFSET $offset";
                        } else {
                            $count_sql = "SELECT COUNT(*) AS total FROM nguoidung";
                            $list_sql = "SELECT * FROM nguoidung
                                         ORDER BY VaiTro, TenDangNhap
                                         LIMIT $limit OFFSET $offset";
                        }

                        // Thực hiện truy vấn lấy tổng số môn học
                        $result_count = mysqli_query($conn, $count_sql);
                        $row_count = mysqli_fetch_assoc($result_count);
                        $total_records = $row_count['total'];

                        // Tính số trang
                        $total_pages = ceil($total_records / $limit);

                        //thuc thi cau lenh
                        $result = mysqli_query($conn, $list_sql);

                        //duyet qua result va in ra
                        while($row = mysqli_fetch_assoc($result)){
                            ?>
                            <tr>
                                <td><?php echo $row["TenDangNhap"] ?></td>
                                <td><?php echo $row["MatKhau"] ?></td>
                                <td><?php echo $row["VaiTro"] ?></td>
                                <td>
                                    <button
                                        type="button" 
                                        class="btn btn-success btn-update" 
                                        data-idNguoiDung="<?php echo $row["idNguoiDung"]; ?>"
                                        data-TenDangNhap="<?php echo $row["TenDangNhap"]; ?>"
                                        data-MatKhau="<?php echo $row["MatKhau"]; ?>" 
                                        data-VaiTro="<?php echo $row["VaiTro"]; ?>" 
                                        data-toggle="modal" 
                                        data-target="#myModal-update"
                                        style="margin-right: 10px">
                                        Sửa
                                    </button>
                                    <a onclick="return confirm('Bạn có muốn xóa môn học này không')" href="delete_NguoiDung.php?idNguoiDung=<?php echo $row["idNguoiDung"] ;?>" class="btn btn-danger" style="margin-right: -15px">Xóa</a>
                                </td>
                            </tr>
                        <?php
                        }
                    ?>
                    <tr>
                        <td colspan="9"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Thêm</button></td>
                    </tr>
                </tbody>
            </table>

            <ul class="pagination justify-content-center" style="margin-left: -40px;">
                <!-- Nút Previous -->
                <li class="page-item <?php echo ($current_page == 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="index_NguoiDung.php?page=<?php echo ($current_page > 1) ? ($current_page - 1) : 1; ?>&searchTerm=<?php echo $searchTerm; ?>">Trước</a>
                </li>

                <!-- Các nút số trang -->
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php echo ($current_page == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="index_NguoiDung.php?page=<?php echo $i; ?>&searchTerm=<?php echo $searchTerm; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Nút Next -->
                <li class="page-item <?php echo ($current_page == $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="index_NguoiDung.php?page=<?php echo ($current_page < $total_pages) ? ($current_page + 1) : $total_pages; ?>&searchTerm=<?php echo $searchTerm; ?>">Sau</a>
                </li>
            </ul>

        </div>

        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" style="font-family: 'Times New Roman', Times, serif;">Thêm môn học</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal Thêm -->
                    <div class="modal-body">
                        <form action="insert_NguoiDung.php" method="post">
                            <div class="form-group">
                                <label for="TenDangNhap">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="TenDangNhap" name="TenDangNhap" required>
                            </div>
                            <div class="form-group">
                                <label for="MatKhau">Mật khẩu</label>
                                <input type="text" class="form-control" id="MatKhau" name="MatKhau" required>
                            </div>
                            <div class="form-group">
                                <label for="VaiTro">Vai trò</label>
                                <select class="form-control" id="VaiTro" name="VaiTro" required>
                                    <option value="admin">Admin</option>
                                    <option value="giao_vien">Giảng viên</option>
                                    <option value="sinh_vien">Sinh viên</option>
                                    <option value="khac">Khác</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Thêm</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-left: 275px;">Đóng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="modal" id="myModal-update">
            <div class="modal-dialog">
                <div class="modal-content">

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Lấy tất cả các nút "Update"
                        const updateButtons = document.querySelectorAll('.btn-update');

                        updateButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                // Lấy giá trị từ thuộc tính data-
                                const idNguoiDung = this.getAttribute('data-idNguoiDung');
                                const TenDangNhap = this.getAttribute('data-TenDangNhap');
                                const MatKhau = this.getAttribute('data-MatKhau');
                                const VaiTro = this.getAttribute('data-VaiTro');

                                // Điền giá trị vào các trường trong modal
                                document.getElementById('update_idNguoiDung').value = idNguoiDung;
                                document.getElementById('update_TenDangNhap').value = TenDangNhap ;
                                document.getElementById('update_MatKhau').value = MatKhau;
                                document.getElementById('update_VaiTro').value = VaiTro;
                            });
                        });
                    });
                </script>

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" style="font-family: 'Times New Roman', Times, serif;">Sửa Thông tin tài khoản</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal Sửa -->
                    <div class="modal-body">
                        <form action="update_NguoiDung.php" method="post">
                            <input type="hidden" name="idNguoiDung" id="update_idNguoiDung">
                            <div class="form-group">
                                <label for="update_TenDangNhap">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="update_TenDangNhap" name="TenDangNhap" required>
                            </div>
                            <div class="form-group">
                                <label for="update_MatKhau">Mật khẩu</label>
                                <input type="text" class="form-control" id="update_MatKhau" name="MatKhau" required>
                            </div>
                            <div class="form-group">
                                <label for="update_VaiTro">Vai trò</label>
                                <select class="form-control" id="update_VaiTro" name="VaiTro" required>
                                    <option value="admin">Admin</option>
                                    <option value="giao_vien">Giảng viên</option>
                                    <option value="sinh_vien">Sinh viên</option>
                                    <option value="khac">Khác</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Cập nhật</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-left: 275px;">Đóng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <script src="../JS/Admin_Script.js?v = <?php echo time(); ?>"></script>
</body>
</html>