<!DOCTYPE html>
<!--=== Coding by CodingLab | www.codinglabweb.com === -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="./CSS/Admin_Style.css?v = <?php echo time(); ?>">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Sinh viên</title> 
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
                    <i class="uil uil-table"></i>
                    <span class="link-name">Bảng điểm</span>
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

        <div class="dash-content" style="margin-top: 20px;">
            <div class="container" style=" text-align:center" >
                <h1 style="font-family: 'Times New Roman', Times, serif;"><b>Bảng điểm</b></h1>

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
                            require_once './folderconnect/connect.php';
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
        </div>
    </section>

    <script src="./JS/Admin_Script.js?v = <?php echo time(); ?>"></script>
</body>
</html>