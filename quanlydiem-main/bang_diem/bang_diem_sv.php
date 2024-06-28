<?php
require_once '../folderconnect/connect.php';
session_start();

// if (!isset($_SESSION['VaiTro'])) {
//     // Chưa đăng nhập
//     echo "<script>
//             alert('Bạn chưa đăng nhập.');
//             window.location.href = 'Dangnhap_Index.php';
//         </script>";
//     exit;
// }

// $vaiTro = $_SESSION['VaiTro'];

if (isset($_SESSION['idNguoiDung'])) {
    $idNguoiDung = $_SESSION['idNguoiDung'];

    $sql_lophoc = "SELECT gv.*, lop.* FROM lop 
                   JOIN giangvien gv ON gv.idGiangVien = lop.idGiangVien
                   WHERE gv.idGiangVien = '$idNguoiDung'";
    $result = mysqli_query($conn, $sql_lophoc);
}
$sql_hocky = "SELECT * FROM hocky ";
$result_hocky = mysqli_query($conn, $sql_hocky);

$sql_danhsachdiemsv = "SELECT diem.*, lop.*, sinhvien.* ,HocKy.*
                       FROM diem
                       LEFT JOIN sinhvien ON sinhvien.idSinhVien = diem.idSinhVien
                        LEFT JOIN HocKy ON HocKy.idHocKy = diem.idHocKy
                        LEFT JOIN lop ON lop.idLop = sinhvien.idLop";

if (isset($_POST['loclop']) && $_POST['loclop'] != 0) {
    $idlop = $_POST['loclop'];
    if(isset($_POST['hocky'])){
      $idhocky = $_POST['hocky'];
    $sql_danhsachdiemsv .= " WHERE lop.idLop = '$idlop' AND diem.TongKetHocPhan < 4.0 AND diem.idHocKy ='$idhocky' ";
    }
   
} else {
    $result_danhsach = false;
}
$result_danhsach = mysqli_query($conn, $sql_danhsachdiemsv);

mysqli_close($conn);
?>
<!DOCTYPE html>
<!--=== Coding by CodingLab | www.codinglabweb.com === -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảng Diem</title>
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../CSS/Admin_Style.css?v = <?php echo time(); ?>">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- link bootrap 4  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    .full-width-table {
      width: 100%;
    }
    .full-width-table th, .full-width-table td {
      text-align: center;
      vertical-align: middle;/* Căn giữa theo chiều dọc */
    }
    .full-width-table th {
      background-color: #343a40;
      color: white;
    }
    .full-width-table thead tr th{
        text-align: center;
        vertical-align: middle; 
    }

    select option[disabled] {
            display: none;
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
                <li><a href="#">
                    <i class="uil uil-user"></i>
                    <span class="link-name">Tài khoản</span>
                </a></li>
                <li><a href="">
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
                <li><a href="#">
                    <i class="uil uil-subject"></i>
                    <span class="link-name">Môn học</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-book-open"></i>
                    <span class="link-name">Lớp</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-atom"></i>
                    <span class="link-name">Khoa ngành</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-books"></i>
                    <span class="link-name">Hệ đào tạo</span>
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
            <!-- <form action="" method="post">
              <div class="search-box">
              <button type="submit" name="btnTimkiem"><i class="uil uil-search"></i></button>
                <input type="text" placeholder="Tìm kiếm...">
            </div>
            </form> -->
            <img src="../Img/profile.jpg" alt="">
        </div>

        <div class="dash-content">
        <div  style="display: flex; justify-content: space-between;">
            <div style="display:flex; margin-top:10px;align-items:center;">
                
                <form action="" method="post">
                <div style="display:flex; padding:20px 20px;">
                <button  class="btn btn-success" type="submit" style="margin-top:2px;height:40px;" name="btntkdiem">Bộ Lọc</button>
                <select name="loclop" id="lopSelect" style="width:200px; text-align:center; margin:0 10px;" class="lop">
                    <option value="0">Theo Lớp..</option>
                    <?php 
                    while($r = mysqli_fetch_assoc($result)){
                      ?>
                      <option value="<?php echo $r['idLop']; ?>"><?php echo $r['TenLop']; ?></option>
                      <?php
                    }
                    
                    ?>
                </select>
                <select name="hocky" id="hockySelect" style="width:200px; text-align:center; margin:0 10px;" class="hocky">
                    <option value="0">hocky..</option>
                    <?php 
                    while($rows = mysqli_fetch_assoc($result_hocky)){
                      ?>
                      <option value="<?php echo $rows['idHocKy']; ?>"><?php echo $rows['TenHocKy']; ?></option>
                      <?php
                    }
                    
                    ?>
                </select>
                </div>
                </form>
            </div>
        </div>
        
        <table class="table table-bordered table-striped full-width-table">
      <thead class="thead-dark">
        
        <tr >
          <th>Mã Sinh Viên</th>
          <th> Họ Và Tên</th>
          <th> Tên Lớp</th>
          <th>Năm Học</th>
          <th>Điểm Chuyên Cần</th>
          <th>Điểm Giữa Kỳ</th>
          <th>Điểm Cuối Kỳ</th>
          <th>Tổng Kết Học Phần</th>
          <th>Điểm Chữ</th>
          <th>Đánh Giá</th>
          <th>Thao Tác</th>
        </tr>
      </thead>
      <tbody>
      <?php if ($result_danhsach) {
        if (mysqli_num_rows($result_danhsach) > 0) {
            while($row = mysqli_fetch_assoc($result_danhsach)) { ?>
              <tr>
                  <td><?php echo $row['MaSinhVien']; ?></td>
                  <td><?php echo $row['HoTen']; ?></td>
                  <td><?php echo $row['TenLop']; ?></td>
                  <td><?php echo $row['NamHoc']; ?></td>
                  <td><?php echo $row['DiemChuyenCan']; ?></td>
                  <td><?php echo $row['DiemGiuaKy']; ?></td>
                  <td><?php echo $row['DiemCuoiKy']; ?></td>
                  <td><?php echo $row['TongKetHocPhan']; ?></td>
                  <td><?php echo $row['DiemChu']; ?></td>
                  <td><?php echo $row['DanhGia']; ?></td>
                   <td>
                   <button
          type="button" 
          class="btn btn-success btn-update" 
          data-idDiem = "<?php echo $row['idDiem']; ?>"
          data-MaSinhVien="<?php echo $row['MaSinhVien']; ?>" 
          data-HoTen="<?php echo $row['HoTen']; ?>" 
          data-TenLop="<?php echo $row['TenLop']; ?>" 
          data-DiemChuyenCan="<?php echo $row['DiemChuyenCan']; ?>" 
          data-DiemGiuaKy="<?php echo $row['DiemGiuaKy']; ?>" 
          data-DiemCuoiKy="<?php echo $row['DiemCuoiKy']; ?>" 
          data-toggle="modal" 
          data-target="#myModal-update"
          style="margin-right: 10px">
          <i class="fa-regular fa-pen-to-square"></i>
        </button>
                   </td>
              </tr>
          <?php } 
          }else { ?>
          <tr>
              <td colspan="11">Không tồn tại sinh viên phải thi lại</td>
          </tr>
       <?php  } 
      }?>
                    
 <!-- Kết thúc dữ liệu mẫu -->
  </tbody>
  </table>
   </div>
    </section>
    <script src="../JS/Admin_Script.js"></script>
    <div class="modal" id="myModal-update">
        <div class="modal-dialog">
            <div class="modal-content">
                 <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="font-family: 'Times New Roman', Times, serif;">Cập Nhật Lại Điểm</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal Sửa -->
                <div class="modal-body">
                    <form action="sua_diemsv.php" method="post">
                    <div class="form-group">
                            <input type="hidden" name="idDiem" id="update_idDiem">
                        </div>
                        <div class="form-group">
                            <label for="update_MaSinhVien">Mã sinh viên</label>
                            <input type="text" class="form-control" id="update_MaSinhVien" name="MaSinhVien" required>
                        </div>
                        <div class="form-group">
                            <label for="update_email_HoTen">Tên Sinh Viên</label>
                            <input type="text" class="form-control" id="update_HoTen" name="HoTen" required>
                        </div>
                        <div class="form-group">
                            <label for="update_TenLop">Lớp</label>
                            <input type="text" class="form-control" id="update_TenLop" name="TenLop" required>
                        </div>
                        <div class="form-group">
                            <label for="update_DiemChuyenCan">Diểm Chuyên Cần</label>
                            <input type="text" class="form-control" id="update_DiemChuyenCan" name="DiemChuyenCan" required>
                        </div>
                        <div class="form-group">
                            <label for="update_DiemGiuaKy">Diểm Giữa Kỳ</label>
                            <input type="text" class="form-control" id="update_DiemGiuaKy" name="DiemGiuaKy" required>
                        </div>

                        <div class="form-group">
                            <label for="update_DiemCuoiKy">Diểm Cuối Kỳ</label>
                            <input type="text" class="form-control" id="update_DiemGiuaKy" name="DiemCuoiKy" required>
                        </div>
                        <button type="submit" class="btn btn-success">Cập nhật</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-left: 275px;">Đóng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Lấy tất cả các nút "Update"
                const updateButtons = document.querySelectorAll('.btn-update');

                updateButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Lấy giá trị từ thuộc tính data-
                        const idDiem = this.getAttribute('data-idDiem');
                        const MaSinhVien = this.getAttribute('data-MaSinhVien');
                        const HoTen= this.getAttribute('data-HoTen');
                        const TenLop = this.getAttribute('data-TenLop');
                        const DiemChuyenCan = this.getAttribute('data-DiemChuyenCan');
                        const DiemGiuaKy = this.getAttribute('data-DiemGiuaKy');
                        const DiemCuoiKy= this.getAttribute('data-DiemCuoiKy');
                        // Điền giá trị vào các trường trong modal
                        document.getElementById('update_idDiem').value= idDiem;
                        document.getElementById('update_MaSinhVien').value = MaSinhVien;
                        document.getElementById('update_HoTen').value = HoTen;
                        document.getElementById('update_TenLop').value = TenLop;
                        document.getElementById('update_DiemChuyenCan').value = DiemChuyenCan;
                        document.getElementById('update_DiemGiuaKy').value = DiemGiuaKy;
                        document.getElementById('update_DiemCuoiKy').value = DiemCuoiKy;
                    });
                });
            });
        </script>
</body>

</html>