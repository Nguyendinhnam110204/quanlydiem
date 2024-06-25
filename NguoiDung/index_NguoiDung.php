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
                <li><a href="../NguoiDung/index_NguoiDung.php">
                    <i class="uil uil-user"></i>
                    <span class="link-name">Quản lý tài khoản</span>
                </a></li>
                <li><a href="#">
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
                <li><a href="../MonHoc/index_MonHoc.php">
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
            
            <div class="user-avatar" id="avatar" onclick="toggleDropdown()">
                <img src="../Img/profile.jpg" alt="Avatar" style="margin-right: 50px;">
                <div class="dropdown-menu" id="dropdown-menu">
                    <a href="#" onclick="logout()" style="text-decoration: none;">Đăng xuất</a>
                </div>
            </div>
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
                        require_once '../connect.php';
                        // Câu lệnh SQL

                        // Câu lệnh SQL có điều kiện tìm kiếm
                        $searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

                        // Câu lệnh SQL có điều kiện tìm kiếm
                        if ($searchTerm) {
                            $list_sql = "SELECT * FROM nguoidung WHERE TenDangNhap LIKE '%$searchTerm%' ORDER BY VaiTro, TenDangNhap";
                        } else {
                            $list_sql = "SELECT * FROM nguoidung ORDER BY VaiTro, TenDangNhap";
                        }
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
                                        Update
                                    </button>
                                    <a onclick="return confirm('Bạn có muốn xóa môn học này không')" href="delete_NguoiDung.php?idNguoiDung=<?php echo $row["idNguoiDung"] ;?>" class="btn btn-danger" style="margin-right: -15px">Delete</a>
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

    <script src="../JS/NguoiDung_Script.js?v = <?php echo time(); ?>"></script>
</body>
</html>