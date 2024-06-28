<?php
require_once '../folderconnect/connect.php';
$selected_khoa = "";
$selected_lop = "";
//tim kiem
if(isset($_POST['btntkdiem']) && isset($_POST['lockhoa']) && isset($_POST['loclop'])){
    $selected_khoa = $_POST['lockhoa'];
    $selected_lop = $_POST['loclop'];

    $sql_select = "SELECT diem.idDiem, sv.idSinhVien, sv.MaSinhVien, sv.HoTen, sv.idlop, lop.idLop, lop.TenLop, 
                diem.HocKy, mh.idMonHoc, mh.TenMonHoc, diem.NamHoc, diem.DiemChuyenCan, diem.DiemGiuaKy, 
                diem.DiemCuoiKy, diem.TongKetHocPhan, diem.DiemChu, diem.DanhGia
                FROM diem
                INNER JOIN sinhvien sv ON diem.idSinhVien = sv.idSinhVien
                INNER JOIN monhoc mh ON diem.idMonHoc = mh.idMonHoc
                LEFT JOIN lop ON sv.idLop = lop.idLop
                WHERE lop.idKhoa = '$selected_khoa' AND lop.idLop =  '$selected_lop' ";
}

$result_timkiem = mysqli_query($conn,$sql_select);
if (!$result_timkiem) {
    die("Query failed: " . mysqli_error($conn));
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
    <title>Bảng Diem Lop</title>
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../CSS/Admin_Style.css?v = <?php echo time(); ?>">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- link bootrap 4  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
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
            <form action="" method="post">
              <div class="search-box">
              <button type="submit" name="btnTimkiem"><i class="uil uil-search"></i></button>
                <input type="text" placeholder="Tìm kiếm...">
            </div>
            </form>
            <img src="../Img/profile.jpg" alt="">
        </div>

        <div class="dash-content">
        <div  style="display: flex; justify-content: space-between;">
            <div style="display:flex; margin-top:10px;align-items:center;">
                
                <form action="../timkiem/timkiem.php" method="post">
                <div style="display:flex; padding:20px 20px;">
                <button  class="btn btn-success" type="submit" style="margin-top:2px;height:40px;" name="btntkdiem">Bộ Lọc</button>
                <select name="lockhoa" id="lopSelect" style="margin:0 10px; width:200px; text-align:center;" class="khoa">
                    <option value="0" >Theo Khoa..</option>   
                </select>
                <select name="loclop" id="lopSelect" style="width:200px; text-align:center; margin:0 10px;" class="lop">
                    <option value="0">Theo Lớp..</option>
                </select>
                </div>
                </form>
            </div>
        <button type="button" class="btn btn-primary btn-sm mx-3" data-toggle="modal" data-target="#myModal" style="margin-top:35px;height:40px">Xuất Excel</button>
        </div>
        
        <table class="table table-bordered table-striped full-width-table">
      <thead class="thead-dark"> 
        <tr >
          <th class=" justify-content-center ;">STT</th>
          <th>Mã Sinh Viên</th>
          <th> Họ Và Tên</th>
          <th> Tên Lớp</th>
          <th>Tên Môn Học</th>
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
        <!-- Dữ liệu mẫu -->
        <?php
        $i=0;
        while($rows=mysqli_fetch_assoc($result_timkiem)){
        ?>
        <tr>
          <th><?php echo ++$i; ?></th>
          <td><?php echo $rows['MaSinhVien']; ?></td>
          <td><?php echo $rows['HoTen']; ?></td>
          <td><?php echo $rows['TenLop']; ?></td>
          <td><?php echo $rows['TenMonHoc']; ?></td>
          <td><?php echo $rows['NamHoc']; ?></td>
          <td><?php echo $rows['DiemChuyenCan']; ?></td>
          <td><?php echo $rows['DiemGiuaKy']; ?></td>
          <td><?php echo $rows['DiemCuoiKy']; ?></td>
          <td><?php echo $rows['TongKetHocPhan']; ?></td>
          <td><?php echo $rows['DiemChu']; ?></td>
          <td><?php echo $rows['DanhGia']; ?></td>
          <td>
          <button
          type="button" 
          class="btn btn-success btn-update" 
          data-id="<?php echo $rows['idDiem']; ?>"
          data-MaSinhVien="<?php echo $rows['MaSinhVien']; ?>" 
          data-HoTen="<?php echo $rows['HoTen']; ?>" 
          data-TenLop="<?php echo $rows['TenLop']; ?>" 
          data-TenMonHoc="<?php echo $rows['TenMonHoc']; ?>" 
          data-NamHoc="<?php echo $rows['NamHoc']; ?>" 
          data-DiemChuyenCan="<?php echo $rows['DiemChuyenCan']; ?>" 
          data-DiemGiuaKy="<?php echo $rows['DiemGiuaKy']; ?>"  
          data-DiemCuoiKy="<?php echo $rows['DiemCuoiKy']; ?>"  
          data-toggle="modal" 
          data-target="#myModal-update"
          style="margin-right: 10px">
          <i class="fa-regular fa-pen-to-square"></i>
          Cập Nhật
        </button>
          </td>
        </tr>
        <?php
        }
        ?>
 
        <!-- Kết thúc dữ liệu mẫu -->
      </tbody>
    </table>
        </div>
    </section>

    <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Lấy tất cả các nút "Update"
                const updateButtons = document.querySelectorAll('.btn-update');

                updateButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Lấy giá trị từ thuộc tính data-
                        const id = this.getAttribute('data-id');
                        const MaSinhVien = this.getAttribute('data-MaSinhVien');
                        const HoTen = this.getAttribute('data-HoTen');
                        const TenLop = this.getAttribute('data-TenLop');
                        const TenMonHoc = this.getAttribute('data-TenMonHoc');
                        const NamHoc = this.getAttribute('data-NamHoc');
                        const DiemChuyenCan = this.getAttribute('data-DiemChuyenCan');
                        const DiemGiuaKy= this.getAttribute('data-DiemGiuaKy');
                        const DiemCuoiKy= this.getAttribute('data-DiemCuoiKy');

                        // Điền giá trị vào các trường trong modal
                        document.getElementById('update_id').value = id;
                        document.getElementById('update_MaSinhVien').value = MaSinhVien ;
                        document.getElementById('update_TenMonHoc').value = TenMonHoc;
                        document.getElementById('update_HoTen').value = HoTen;
                        document.getElementById('update_TenLop').value = TenLop;
                        document.getElementById('update_NamHoc').value = NamHoc;
                        document.getElementById('update_DiemChuyenCan').value = DiemChuyenCan;
                        document.getElementById('update_DiemGiuaKy').value = DiemGiuaKy;
                        document.getElementById('update_DiemCuoiKy').value = DiemCuoiKy;
                    });
                });
            });
        </script>

<div class="modal" id="myModal-update">
        <div class="modal-dialog">
            <div class="modal-content">
                 <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="font-family: 'Times New Roman', Times, serif;"> Thêm thông tin </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal Sửa -->
                <div class="modal-body">
                    <form action="../bang_diem/sua_diemsv.php" method="post">
                    <div class="form-group">
                            <input type="hidden" name="id" value="" id="update_id">
                        </div>
                        <div class="form-group">
                            <label for="update_MaSinhVien">Mã Sinh Viên</label>
                            <input type="text" class="form-control" id="update_MaSinhVien" name="MaSinhVien" >
                        </div>
                        <div class="form-group">
                            <label for="update_HoTen">Họ và Tên</label>
                            <input type="text" class="form-control" id="update_HoTen" name="HoTen" >
                        </div>
                        <div class="form-group">
                            <label for="update_TenLop">Tên Lớp</label>
                            <input type="text" class="form-control" id="update_TenLop" name="TenLop" >
                        </div>
                        <div class="form-group">
                            <label for="update_TenMonHoc">Tên Môn Học</label>
                            <input type="text" class="form-control" id="update_TenMonHoc" name="TenMonHoc" >
                        </div>
                        <div class="form-group">
                            <label for="update_NamHoc">Năm học</label>
                            <input type="text" class="form-control" id="update_NamHoc" name="NamHoc" >
                        </div>
                        <div class="form-group">
                            <label for="update_DiemChuyenCan">Điểm chuyên Cần</label>
                            <input type="text" class="form-control" id="update_DiemChuyenCan" name="DiemChuyenCan" >
                        </div>

                        <div class="form-group">
                            <label for="update_DiemGiuaKy">Điểm Giữa Kỳ</label>
                            <input type="text" class="form-control" id="update_DiemGiuaKy" name="DiemGiuaKy" >
                        </div>

                        <div class="form-group">
                            <label for="update_DiemCuoiKy">Điểm Cuối Kỳ</label>
                            <input type="text" class="form-control" id="update_DiemCuoiKy" name="DiemCuoiKy">
                        </div>

                        <button type="submit" class="btn btn-success">Lưu</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-left: 275px;">Đóng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="../JS/Admin_Script.js"></script>
<script src="../timkiem/ajax_timkiem.js"></script>
<!-- ajax de loc quan huyen -->
<script>
    $(document).ready(function () {
  $(".khoa").change(function () {
    var idKhoa = $(this).val(); // Get the selected value of khoa dropdow
    $.post("../timkiem/data.php", { idKhoa: idKhoa }, function (data) {
      $(".lop").html(data);
    });
  });
});

</script>
</body>
</html>