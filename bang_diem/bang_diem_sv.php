<?php
require_once '../folderconnect/connect.php';
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

// $vaiTro = $_SESSION['VaiTro'];

if (isset($_SESSION['idNguoiDung']) && isset($_SESSION['TenDangNhap'])) {
    // $idNguoiDung = $_SESSION['idNguoiDung'];
    $maGiangVien = $_SESSION['TenDangNhap'] ;
// Truy vấn cơ sở dữ liệu để lấy idGiangVien tương ứng
$sql = "SELECT idGiangVien , MaGiangVien  FROM giangvien WHERE MaGiangVien = '$maGiangVien'";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $idGiangVien = $row['idGiangVien'];
} else {
    echo "Không tìm thấy giảng viên với mã: $maGiangVien";
    exit;
}
    $sql_lophoc = "SELECT gv.*, lop.* FROM lop 
                   JOIN giangvien gv ON gv.idGiangVien = lop.idGiangVien
                   WHERE gv.idGiangVien = '$idGiangVien'";
    $result = mysqli_query($conn, $sql_lophoc);
    $result_lophoc2 = mysqli_query($conn, $sql_lophoc);
}
$sql_hocky = "SELECT * FROM hocky ";
$result_hocky = mysqli_query($conn, $sql_hocky);
$result_hocky2 = mysqli_query($conn, $sql_hocky);

// Số môn học trên mỗi trang
$limit = 6;

// Trang hiện tại, mặc định là trang 1
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính offset
$offset = ($current_page - 1) * $limit;

$count_sql = "SELECT COUNT(*) AS total FROM diem";

$sql_danhsachdiemsv = "SELECT diem.*, lop.*, sinhvien.*, HocKy.*, monhoc.*
                       FROM diem
                       JOIN sinhvien ON sinhvien.idSinhVien = diem.idSinhVien
                       JOIN HocKy ON HocKy.idHocKy = diem.idHocKy
                       JOIN lop ON lop.idLop = sinhvien.idLop
                       JOIN monhoc ON monhoc.idMonHoc = diem.idMonHoc
                       LIMIT $limit OFFSET $offset";
if(isset($_GET['loclop']) && $_GET['loclop'] != 0 && isset($_GET['monhoc']) && isset($_GET['btntkdiem1']) && isset($_GET['hocky'])  ) 
{
    $idlop = $_GET['loclop'];
    $idMonHoc = $_GET['monhoc'];
    $idhocky = $_GET['hocky'];

    $_SESSION['loclop'] = $idlop;
    $_SESSION['monhoc'] = $idMonHoc;
    $_SESSION['hocky'] = $idhocky;
    $sql_danhsachdiemsv .= " WHERE DiemCuoiKylan1 IS NULL AND DiemCuoiKylan2 IS NULL   AND lop.idLop = '$idlop' AND diem.idHocKy = '$idhocky' AND diem.idMonHoc = '$idMonHoc'  ";
} else {
    $result_danhsach = false;
}
if (isset($_GET['loclop2']) && $_GET['loclop2'] != 0 && isset($_GET['monhoc2']) && isset($_GET['btntkdiem2']) && isset($_GET['hocky2'])  ) {
    $idlop2 = $_GET['loclop2'];
    $idMonHoc2 = $_GET['monhoc2'];
    $idhocky2 = $_GET['hocky2'];
    $_SESSION['loclop2'] = $idlop2;
    $_SESSION['monhoc2'] = $idMonHoc2;
    $_SESSION['hocky2'] = $idhocky2;
    $sql_danhsachdiemsv .= " WHERE  DiemCuoiKylan2 IS NULL  lop.idLop = '$idlop2' AND diem.idHocKy = '$idhocky2' AND diem.idMonHoc = '$idMonHoc2'  ";
} else {
    $result_danhsach = false;
}

$result_count = mysqli_query($conn, $count_sql);
$row_count = mysqli_fetch_assoc($result_count);
$total_records = $row_count['total'];

// Tính số trang
$total_pages = ceil($total_records / $limit);

$result_danhsach = mysqli_query($conn, $sql_danhsachdiemsv);

mysqli_close($conn);
?>
<!DOCTYPE html>
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
            <?php if ($vaiTro == 'giao_vien'): ?>
                <li><a href="../themdiemsv_GV/themdiem_SV.php">
                    <i class="uil uil-table"></i>
                    <span class="link-name">Thêm điểm</span>
                </a></li>
                <li><a href="#">
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
            <img src="../Img/profile.jpg" alt="">
        </div>

        <div class="dash-content">
        <div  style="display: flex; justify-content: space-between;">
            <div style="display:flex; margin-top:10px;align-items:center;">
                
                <form action="" method="get">
                <div style="display:flex; padding:20px 20px;">
                <button  class="btn btn-success" type="submit" style="margin-top:2px;height:40px;" name="btntkdiem1">Cập Nhật Lần 1</button>
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
                      <option value="<?php echo $rows['idHocKy']; ?>"><?php echo $rows['NamHoc']; ?></option>
                      <?php
                    }
                    
                    ?>
                </select>
                <select name="monhoc" id="monhocSelect" style="width:200px; text-align:center; margin:0 10px;" class="monhoc">
                    <option value="0">Môn Học..</option>
                </select>
                </div>
                </form>
            </div>
        </div>

        <div  style="display: flex; justify-content: space-between;">
            <div style="display:flex; margin-top:5px;align-items:center;">
                
                <form action="" method="get">
                <div style="display:flex; padding:20px 20px;">
                <button  class="btn btn-success" type="submit" style="margin-top:2px;height:40px;" name="btntkdiem2">Cập Nhật Lần 2</button>
                <select name="loclop2" id="lopSelect2" style="width:200px; text-align:center; margin:0 10px;" class="lop">
                    <option value="0">Theo Lớp..</option>
                    <?php 
                    while($r = mysqli_fetch_assoc($result_lophoc2)){
                      ?>
                      <option value="<?php echo $r['idLop']; ?>"><?php echo $r['TenLop']; ?></option>
                      <?php
                    }
                    
                    ?>
                </select>
                <select name="hocky2" id="hockySelect2" style="width:200px; text-align:center; margin:0 10px;" class="hocky">
                    <option value="0">hocky..</option>
                    <?php 
                    while($rows = mysqli_fetch_assoc($result_hocky2)){
                      ?>
                      <option value="<?php echo $rows['idHocKy']; ?>"><?php echo $rows['NamHoc']; ?></option>
                      <?php
                    }
                    
                    ?>
                </select>
                <select name="monhoc2" id="monhocSelect2" style="width:200px; text-align:center; margin:0 10px;" class="monhoc">
                    <option value="0">Môn Học..</option>
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
          <th>Môn Học</th>
          <th>Điểm Chuyên Cần</th>
          <th>Điểm Giữa Kỳ</th>
          <th>Điểm Cuối Kỳ Lần 1</th>
          <th>Điểm Cuối Kỳ Lần 2</th>
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
                  <td><?php echo $row['TenMonHoc']; ?></td>
                  <td><?php echo $row['DiemChuyenCan']; ?></td>
                  <td><?php echo $row['DiemGiuaKy']; ?></td>
                  <td><?php echo $row['DiemCuoiKylan1']; ?></td>
                  <td><?php echo $row['DiemCuoiKylan2']; ?></td>
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
          data-TenMonHoc="<?php echo $row['TenMonHoc']; ?>" 
          data-DiemChuyenCan="<?php echo $row['DiemChuyenCan']; ?>" 
          data-DiemGiuaKy="<?php echo $row['DiemGiuaKy']; ?>" 
          data-DiemCuoiKylan1="<?php echo $row['DiemCuoiKylan1']; ?>"
          data-DiemCuoiKylan2="<?php echo $row['DiemCuoiKylan2']; ?>"
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
              <td colspan="12">Không tồn tại sinh viên phải thi lại</td>
          </tr>
       <?php  } 
      }?>
                    
 <!-- Kết thúc dữ liệu mẫu -->
  </tbody>
  </table>
  <ul class="pagination justify-content-center" style="margin-left: -40px;">
                <!-- Nút Previous -->
                <li class="page-item <?php echo ($current_page == 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="bang_diem_sv.php?page=<?php echo ($current_page > 1) ? ($current_page - 1) : 1; ?>">Trước</a>
                </li>

                <!-- Các nút số trang -->
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?php echo ($current_page == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="bang_diem_sv.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Nút Next -->
                <li class="page-item <?php echo ($current_page == $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="bang_diem_sv.php?page=<?php echo ($current_page < $total_pages) ? ($current_page + 1) : $total_pages; ?>">Sau</a>
                </li>
        </ul>
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
                            <input type="text" class="form-control" id="update_MaSinhVien" name="MaSinhVien" readonly>
                        </div>
                        <div class="form-group">
                            <label for="update_email_HoTen">Tên Sinh Viên</label>
                            <input type="text" class="form-control" id="update_HoTen" name="HoTen" readonly>
                        </div>
                        <div class="form-group">
                            <label for="update_TenLop">Lớp</label>
                            <input type="text" class="form-control" id="update_TenLop" name="TenLop" readonly>
                        </div>
                        <div class="form-group">
                            <label for="update_TenLop">Tên Môn Học</label>
                            <input type="text" class="form-control" id="update_MonHoc" name="MonHoc" readonly>
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
                            <label for="update_DiemCuoiKylan1">Diểm Cuối Kỳ Lần 1 </label>
                            <input type="text" class="form-control" id="update_DiemCuoiKylan1" name="DiemCuoiKylan1" required>
                        </div>
                        <div class="form-group">
                            <label for="update_DiemCuoiKylan2">Diểm Cuối Kỳ Lần 2 </label>
                            <input type="text" class="form-control" id="update_DiemCuoiKylan2" name="DiemCuoiKylan2" >
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
                        const MonHoc = this.getAttribute('data-TenMonHoc');
                        const DiemChuyenCan = this.getAttribute('data-DiemChuyenCan');
                        const DiemGiuaKy = this.getAttribute('data-DiemGiuaKy');
                        const DiemCuoiKylan1= this.getAttribute('data-DiemCuoiKylan1');
                        const DiemCuoiKylan2= this.getAttribute('data-DiemCuoiKylan2');
                        // Điền giá trị vào các trường trong modal
                        document.getElementById('update_idDiem').value= idDiem;
                        document.getElementById('update_MaSinhVien').value = MaSinhVien;
                        document.getElementById('update_HoTen').value = HoTen;
                        document.getElementById('update_TenLop').value = TenLop;
                        document.getElementById('update_MonHoc').value = MonHoc;
                        document.getElementById('update_DiemChuyenCan').value = DiemChuyenCan;
                        document.getElementById('update_DiemGiuaKy').value = DiemGiuaKy;
                        document.getElementById('update_DiemCuoiKylan1').value = DiemCuoiKylan1;
                        document.getElementById('update_DiemCuoiKylan2').value = DiemCuoiKylan2;
                    });
                });
            });
        </script>
<!-- lọc môn học theo học kỳ và lớp học -->
<script>
        $(document).ready(function() {
            $('#lopSelect, #hockySelect').change(function() {
                var idLop = $('#lopSelect').val();
                var idHocKy = $('#hockySelect').val();
                if (idLop != 0 && idHocKy != 0) {
                    $.post('../timkiem/locmonhoc_bd.php', { idLop: idLop, idHocKy: idHocKy }, function(data) {
                        $('#monhocSelect').html('<option value="0">Môn Học..</option>' + data);
                    });
                }
            });
        });
    </script>


<script>
        $(document).ready(function() {
            $('#lopSelect2, #hockySelect2').change(function() {
                var idLop2 = $('#lopSelect2').val();
                var idHocKy2 = $('#hockySelect2').val();
                if (idLop2 != 0 && idHocKy2 != 0) {
                    $.post('../timkiem/locmonhoc_bd2.php', { idLop2: idLop2, idHocKy2: idHocKy2 }, function(data) {
                        $('#monhocSelect2').html('<option value="0">Môn Học..</option>' + data);
                    });
                }
            });
        });
    </script>

</body>

</html>