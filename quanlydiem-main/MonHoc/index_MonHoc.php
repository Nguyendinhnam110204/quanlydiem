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
                    <span class="link-name">Tài khoản</span>
                </a></li>
                <li><a href="../themdiemsv_GV/themdiem_SV.php">
                    <i class="uil uil-table"></i>
                    <span class="link-name">Bảng điểm</span>
                </a></li>
                <li><a href="../sinhvien/Index_sinhvien.php">
                    <i class="uil uil-book-reader"></i>
                    <span class="link-name">Thông tin sinh viên</span>
                </a></li>
                <li><a href="../giangvien/Index_giangvien.php">
                    <i class="uil uil-file-info-alt"></i>
                    <span class="link-name">Thông tin giảng viên</span>
                </a></li>
                <li><a href="#">
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
            <div class="container" style=" text-align:center">
            <h1 style="font-family: 'Times New Roman', Times, serif;"><b>Quản lý Môn học</b></h1>
            
            <div class="input-group mb-3" style="margin-top: 50px; width: 400px;">
                <form action="index_MonHoc.php" method="get" style="display: flex; width: 100%;">
                    <input type="search" class="form-control" placeholder="Tìm kiếm..." name="searchTerm">
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit" style="width: 100px;">Tìm Kiếm</button>
                    </div>
                </form>
            </div>

            <br>
            <table class="table" style="margin: -15px 0 0 -10px; width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th>Mã môn học</th>
                        <th>Tên môn học</th>
                        <th>Số tín chỉ</th>
                        <th>Mô tả</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //ketnoi
                        require_once '../folderconnect/connect.php';
                        // Câu lệnh SQL
                        
                        $searchTerm = isset($_GET['searchTerm']) ? $_GET['searchTerm'] : '';

                        // Câu lệnh SQL có điều kiện tìm kiếm
                        if ($searchTerm) {
                            $list_sql = "SELECT monhoc.idMonHoc, monhoc.MaMonHoc, monhoc.TenMonHoc, monhoc.SoTinChi, monhoc.MoTa
                                        WHERE monhoc.MaMonHoc LIKE '%$searchTerm%' 
                                        OR monhoc.TenMonHoc LIKE '%$searchTerm%'
                                        ORDER BY MaMonHoc, TenMonHoc";
                        } else {
                            $list_sql = "SELECT monhoc.idMonHoc, monhoc.MaMonHoc, monhoc.TenMonHoc, monhoc.SoTinChi, monhoc.MoTa FROM monhoc ORDER BY MaMonHoc, TenMonHoc";
                        }

                        //thuc thi cau lenh
                        $result = mysqli_query($conn, $list_sql);

                        //duyet qua result va in ra
                        while($row = mysqli_fetch_assoc($result)){
                            ?>
                            <tr>
                                <td><?php echo $row["MaMonHoc"] ?></td>
                                <td><?php echo $row["TenMonHoc"] ?></td>
                                <td><?php echo $row["SoTinChi"] ?></td>
                                <td><?php echo $row["MoTa"] ?></td>
                                <td>
                                    <button
                                        type="button" 
                                        class="btn btn-success btn-update" 
                                        data-idMonHoc="<?php echo $row["idMonHoc"]; ?>"
                                        data-MaMonHoc="<?php echo $row["MaMonHoc"]; ?>" 
                                        data-TenMonHoc="<?php echo $row["TenMonHoc"]; ?>" 
                                        data-SoTinChi="<?php echo $row["SoTinChi"]; ?>" 
                                        data-MoTa="<?php echo $row["MoTa"]; ?>"   
                                        data-toggle="modal" 
                                        data-target="#myModal-update"
                                        style="margin-right: 10px">
                                        Update
                                    </button>
                                    <a onclick="return confirm('Bạn có muốn xóa môn học này không')" href="delete_MonHoc.php?idMonHoc=<?php echo $row["idMonHoc"] ;?>" class="btn btn-danger" style="margin-right: -15px">Delete</a>
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
                        <form action="insert_MonHoc.php" method="post">
                            <div class="form-group">
                                <label for="MaMonHoc">Mã môn học</label>
                                <input type="text" class="form-control" id="MaMonHoc" name="MaMonHoc" required>
                            </div>
                            <div class="form-group">
                                <label for="TenMonHoc">Tên môn học</label>
                                <input type="text" class="form-control" id="TenMonHoc" name="TenMonHoc" required>
                            </div>
                            <div class="form-group">
                                <label for="SoTinChi">Số tín chỉ</label>
                                <input type="text" class="form-control" id="SoTinChi" name="SoTinChi" required>
                            </div>
                            <div class="form-group">
                                <label for="MoTa">Mô tả</label>
                                <input type="text" class="form-control" id="MoTa" name="MoTa" required>
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
                                const idMonHoc = this.getAttribute('data-idMonHoc');
                                const maMonHoc = this.getAttribute('data-MaMonHoc');
                                const tenMonHoc = this.getAttribute('data-TenMonHoc');
                                const soTinChi = this.getAttribute('data-SoTinChi');
                                const moTa = this.getAttribute('data-MoTa');

                                // Điền giá trị vào các trường trong modal
                                document.getElementById('update_idMonHoc').value = idMonHoc;
                                document.getElementById('update_MaMonHoc').value = maMonHoc ;
                                document.getElementById('update_TenMonHoc').value = tenMonHoc;
                                document.getElementById('update_SoTinChi').value = soTinChi;
                                document.getElementById('update_MoTa').value = moTa;
                            });
                        });
                    });
                </script>

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" style="font-family: 'Times New Roman', Times, serif;">Sửa Thông tin môn học</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal Sửa -->
                    <div class="modal-body">
                        <form action="update_MonHoc.php" method="post">
                            <input type="hidden" name="idMonHoc" id="update_idMonHoc">
                            <div class="form-group">
                                <label for="update_MaMonHoc">Mã môn học</label>
                                <input type="text" class="form-control" id="update_MaMonHoc" name="MaMonHoc" readonly>
                            </div>
                            <div class="form-group">
                                <label for="update_TenMonHoc">Tên môn học</label>
                                <input type="text" class="form-control" id="update_TenMonHoc" name="TenMonHoc" required>
                            </div>
                            <div class="form-group">
                                <label for="update_SoTinChi">Số tín chỉ</label>
                                <input type="text" class="form-control" id="update_SoTinChi" name="SoTinChi" required>
                            </div>
                            <div class="form-group">
                                <label for="update_MoTa">Mô tả</label>
                                <input type="text" class="form-control" id="update_MoTa" name="MoTa" required>
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