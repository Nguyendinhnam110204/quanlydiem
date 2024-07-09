<?php 
require_once './folderconnect/connect.php';
//Truy vấn SQL để chọn tất cả học viên
$sql = "SELECT * FROM sinhvien";
$result = mysqli_query($conn, $sql);
//Đếm số lượng học sinh
$total_students = mysqli_num_rows($result);
//Truy vấn SQL để chọn tất cả giảng viên
$sql_giangvien = "SELECT * FROM giangvien";
$result_giangvien = mysqli_query($conn, $sql_giangvien);
//Đếm số lượng giangvien
$total_giangvien = mysqli_num_rows($result_giangvien);

//Truy vấn SQL để chọn tất cả khoa
$sql_khoa = "SELECT * FROM khoa";
$result_khoa = mysqli_query($conn, $sql_khoa);
//Đếm số lượng khoa
$total_khoa = mysqli_num_rows($result_khoa);

//Truy vấn SQL để chọn tất cả lop
$sql_lop = "SELECT * FROM lop";
$result_lop = mysqli_query($conn, $sql_lop);
//Đếm số lượng lop
$total_lop = mysqli_num_rows($result_lop);


$conn->close();
?>
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


    <style>
        /* Thêm CSS sau vào tệp Admin_Style.css hiện có của bạn hoặc bao gồm nó trong thẻ <kiểu> */
        .dashboard-cards {
            display: flex;
            justify-content: space-around;
            padding: 20px;
        }

        .dashboard-card {
            width: 350px;
            padding: 20px;
            color: white;
            border-radius: 8px;
            text-align: center;
        }

        .dashboard-card.blue {
            background-color: #007bff;
        }

        .dashboard-card.green {
            background-color: #28a745;
        }

        .dashboard-card.yellow {
            background-color: #ffc107;
        }

        .dashboard-card .number {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .dashboard-card .label {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .dashboard-card .view-more {
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            display: inline-block;
        }

        .dashboard-card .view-more:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
    <title>Giảng viên</title> 
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
                <li><a href="./themdiemsv_GV/themdiem_SV.php">
                    <i class="uil uil-table"></i>
                    <span class="link-name">Thêm điểm</span>
                </a></li>
                <li><a href="./bang_diem/bang_diem_sv.php">
                    <i class="uil uil-table"></i>
                    <span class="link-name">Cập Nhật  điểm</span>
                </a></li>
            </ul>
            
            <ul class="logout-mode">
                <li><a href="./Login/DangXuat.php">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Đăng xuất</span>
                </a></li>
                
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            
            <img src="./Img/profile.jpg" alt="Avatar" style="margin-right: 50px;">
        </div>

        <div class="dash-content">
             <!-- Chứa chi tiết các chức năng ở đây -->
             <div class="dashboard-cards">
                <div class="dashboard-card blue">
                    <div class="number"><?php echo $total_khoa;  ?></div>
                    <div class="label">Khoa</div>
                    <a href="#" class="view-more">Xem thêm</a>
                </div>
                <div class="dashboard-card yellow">
                    <div class="number"><?php echo $total_lop;  ?></div>
                    <div class="label">Lớp</div>
                    <a href="#" class="view-more">Xem thêm</a>
                </div>
                <div class="dashboard-card green">
                    <div class="number"><?php echo $total_students;  ?></div>
                    <div class="label">Sinh Viên</div>
                    <a href="#" class="view-more">Xem thêm</a>
                </div>
                <div class="dashboard-card yellow">
                    <div class="number"><?php echo $total_giangvien;  ?></div>
                    <div class="label">Giảng Viên</div>
                    <a href="#" class="view-more">Xem thêm</a>
                </div>
            </div>
        </div>
    </section>

    <script src="./JS/Admin_Script.js?v = <?php echo time(); ?>"></script>
</body>
</html>