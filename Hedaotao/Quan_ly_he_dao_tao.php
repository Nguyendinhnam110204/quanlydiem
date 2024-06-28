<?php
require_once '../connect.php';
    $hienthi_sql= "SELECT * FROM hedaotao order by MaHeDT,TenHeDT";
    $result = mysqli_query($conn,$hienthi_sql);

    if(isset($_POST['btntk'])){
        $MMaHeDT=$_POST['tkMaHeDT'];
    
        $sqltk = "  SELECT *  FROM hedaotao
         WHERE MaHeDT like '%$MMaHeDT%'";
        $result = mysqli_query($conn,$sqltk);
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

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
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

            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Tìm kiếm...">
            </div>

            <img src="./Img/profile.jpg" alt="Avatar" style="margin-right: 50px;">


            
        </div>

        <div class="dash-content">
        <div class="container">
        <h2 class="text-center my-4">Quản lý hệ đào tạo</h2><div class="input-group mb-3" style="margin-top: 50px; width: 400px;">
                <form action="" method="POST" style="display: flex; width: 100%;">
                    <input type="search" class="form-control" placeholder="Mã hệ đào tạo" name="tkMaHeDT">&nbsp
                    <div class="input-group-append">
                        <button class="btn btn-success" name="btntk" type="submit" style="width: 100px;">Tìm Kiếm</button>
                    </div>
                </form>
            </div><br>

        <table class="table" style="margin: -15px 0 0 -10px; width:100%">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Mã hệ đào tạo</th>
                    <th scope="col">Tên hệ đào tạo</th>
                    <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php while($r = mysqli_fetch_assoc($result)){ ?>
                <tr>
                    <td><?php echo $r['MaHeDT']; ?></td>
                    <td><?php echo $r['TenHeDT']; ?></td>
                    <td>
                    <button
                                        type="button" 
                                        class="btn btn-success btn-update" 
                                        data-idHeDT="<?php echo $r['idHeDT']; ?>"
                                        data-MaHeDT="<?php echo $r['MaHeDT']; ?>"
                                        data-TenHeDT="<?php echo $r['TenHeDT']; ?>"
                                        data-toggle="modal" 
                                        data-target="#myModal-update"
                                        style="margin-right: 10px">
                                        Update
                                    </button>
                                    <a onclick="return confirm('Bạn có muốn xóa không?');" href="Xoa_he_dt.php?idHeDT=<?php echo $r['idHeDT'];?>" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
            <?php } ?>
            <tr>
            <td colspan="4"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Thêm</button></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" style="font-family: 'Times New Roman', Times, serif;">Thêm Hệ đào tạo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal Thêm -->
                    <div class="modal-body">
                        <form action="Them_he_dao_tao.php" method="post">
                            <div class="form-group">
                                <label for="MaHeDT">Mã hệ đào tạo</label>
                                <input type="text" class="form-control" id="MaHeDT" name="MaHeDT" required>
                            </div>
                            <div class="form-group">
                                <label for="TenHeDT">Tên hệ đào tạo</label>
                                <input type="text" class="form-control" id="TenHeDT" name="TenHeDT" required>
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
                                const idHeDT = this.getAttribute('data-idHeDT');
                                const MaHeDT = this.getAttribute('data-MaHeDT');
                                const TenHeDT = this.getAttribute('data-TenHeDT');

                                // Điền giá trị vào các trường trong modal
                                document.getElementById('update_idHeDT').value = idHeDT;
                                document.getElementById('update_MaHeDT').value = MaHeDT;
                                document.getElementById('update_TenHeDT').value = TenHeDT ;
                            });
                        });
                    });
                </script>

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" style="font-family: 'Times New Roman', Times, serif;">Sửa Thông tin Khoa</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal Sửa -->
                    <div class="modal-body">
                        <form action="Sua_he_dao_tao.php" method="post">
                            <input type="hidden" name="txtidHeDT" id="update_idHeDT">
                            <div class="form-group">
                                <label for="MaHeDT">Mã hệ đào tạo:</label>
                                <input type="text" class="form-control" id="update_MaHeDT" name="txtMaHeDT" readonly>
                            </div>
                            <div class="form-group">
                                <label for="TenHeDT">Tên hệ đào tạo:</label>
                                <input type="text" class="form-control" id="update_TenHeDT" name="txtTenHeDT" required>
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