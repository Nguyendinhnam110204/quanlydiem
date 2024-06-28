<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Điểm sinh viên</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        .header-text {
            font-weight: bold;
            color: green;
        }

        .table thead th {
            background-color: #0056b3;
            color: white;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "diemsinhvien";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['idSinhVien'])) {
        $studentId = $_GET['idSinhVien'];

    $studentQuery = "SELECT sv.MaSinhVien, sv.HoTen, sv.NgaySinh, sv.DiaChi, sv.Email, sv.DienThoai, l.TenLop, k.TenKhoa, hdt.TenHeDT
                     FROM SinhVien sv
                     JOIN Lop l ON sv.idLop = l.idLop
                     JOIN Khoa k ON l.idKhoa = k.idKhoa
                     JOIN HeDaoTao hdt ON l.idHeDT = hdt.idHeDT
                     WHERE sv.idSinhVien = $studentId";

    $studentResult = $conn->query($studentQuery);

    if ($studentResult->num_rows > 0) {
        $student = $studentResult->fetch_assoc();
    }
    ?>

    <div class="row mb-3">
        <div class="col-md-4">
            <p><span class="header-text">Mã sinh viên:</span> <?= $student['MaSinhVien'] ?></p>
            <p><span class="header-text">Khoa:</span> <?= $student['TenKhoa'] ?></p>
            <p><span class="header-text">Chọn học kỳ:</span>
                <select class="form-control" id="hocKySelect">
                    <?php
                    // Fetch hoc ky data
                    $hocKySql = "SELECT idHocKy, TenHocKy, NamHoc FROM HocKy";
                    $hocKyResult = $conn->query($hocKySql);
                    while($row = $hocKyResult->fetch_assoc()): ?>
                        <option value="<?= $row['idHocKy'] ?>"><?= $row['TenHocKy'] ?> _ <?= $row['NamHoc'] ?></option>
                    <?php endwhile; ?>
                </select>
            </p>
        </div>
        <div class="col-md-4">
            <p><span class="header-text">Họ tên:</span> <?= $student['HoTen'] ?></p>
            <p><span class="header-text">Ngành:</span> <?= $student['TenHeDT'] ?></p>
            <p><span class="header-text">Trạng thái:</span> Đang học</p>
        </div>
        <div class="col-md-4">
            <p><span class="header-text">Lớp:</span> <?= $student['TenLop'] ?></p>
            <p><span class="header-text">Ngày Sinh:</span> <?= $student['NgaySinh'] ?></p>
            <p><span class="header-text">Địa chỉ:</span> <?= $student['DiaChi'] ?></p>
        </div>
    </div>

    <h5 class="text-center font-weight-bold mb-3">BẢNG ĐIỂM TRUNG BÌNH HỌC TẬP NĂM HỌC, HỌC KỲ, TOÀN KHÓA:</h5>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Năm học</th>
                <th>Học kỳ</th>
                <th>GPA</th>
                <th>Điểm chữ</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $gpaQuery = "SELECT hk.NamHoc, hk.TenHocKy, gpa.GPA
                     FROM GPA gpa
                     JOIN HocKy hk ON gpa.idHocKy = hk.idHocKy
                     WHERE gpa.idSinhVien = $studentId";
        $gpaResult = $conn->query($gpaQuery);

        if ($gpaResult->num_rows > 0) {
            while ($gpa = $gpaResult->fetch_assoc()) {
                $letterGrade = '';
                if ($gpa['GPA'] >= 9) {
                    $letterGrade = 'A+';
                } elseif ($gpa['GPA'] >= 8.5) {
                    $letterGrade = 'A';
                } elseif ($gpa['GPA'] >= 8) {
                    $letterGrade = 'B+';
                } elseif ($gpa['GPA'] >= 7) {
                    $letterGrade = 'B';
                } elseif ($gpa['GPA'] >= 6.5) {
                    $letterGrade = 'C+';
                } elseif ($gpa['GPA'] >= 5.5) {
                    $letterGrade = 'C';
                } elseif ($gpa['GPA'] >= 5) {
                    $letterGrade = 'D+';
                } elseif ($gpa['GPA'] >= 4) {
                    $letterGrade = 'D';
                } else {
                    $letterGrade = 'F';
                }

                echo "<tr>
                        <td>{$gpa['NamHoc']}</td>
                        <td>{$gpa['TenHocKy']}</td>
                        <td>{$gpa['GPA']}</td>
                        <td>{$letterGrade}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No data found</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <h5 class="text-center font-weight-bold mt-4 mb-3">ĐIỂM CHI TIẾT:</h5>

    <table class="table table-bordered" id="gradesTable">
        <thead>
            <tr>
                <th>Mã học phần</th>
                <th>Tên học phần</th>
                <th>Số TC</th>
                <th>Đánh giá</th>
                <th>Điểm Chuyên cần</th>
                <th>Kiểm tra GK</th>
                <th>Thi kết thúc</th>
                <th>Tổng kết HP</th>
                <th>Điểm chữ</th>
                <th>Kết quả</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $gradesQuery = "SELECT mh.MaMonHoc, mh.TenMonHoc, mh.SoTinChi, d.DiemChuyenCan, d.DiemGiuaKy, d.DiemCuoiKy, d.DanhGia , d.TongKetHocPhan, d.DiemChu
                        FROM Diem d
                        JOIN MonHoc mh ON d.idMonHoc = mh.idMonHoc
                        WHERE d.idSinhVien = $studentId";
        $gradesResult = $conn->query($gradesQuery);

        if ($gradesResult->num_rows > 0) {
            while ($grade = $gradesResult->fetch_assoc()) {
                $evaluation = $grade['TongKetHocPhan'] > 4.0 ? 'DAT' : 'Khong DAT';
                echo "<tr>
                        <td>{$grade['MaMonHoc']}</td>
                        <td>{$grade['TenMonHoc']}</td>
                        <td>{$grade['SoTinChi']}</td>
                        <td>{$grade['DanhGia']}</td>
                        <td>{$grade['DiemChuyenCan']}</td>
                        <td>{$grade['DiemGiuaKy']}</td>
                        <td>{$grade['DiemCuoiKy']}</td>
                        <td>{$grade['TongKetHocPhan']}</td>
                        <td>{$grade['DiemChu']}</td>
                         <td>{$evaluation}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No data found</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <?php
    } else {
        echo "<p>No student found with the given ID.</p>";
    }

    $conn->close();
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#hocKySelect').change(function() {
            var hocKyId = $(this).val();
            $.ajax({
                url: 'fetch_grades.php',
                type: 'POST',
                data: { idHocKy: hocKyId, idSinhVien: <?= $studentId ?> },
                success: function(response) {
                    $('#gradesTable tbody').html(response);
                }
            });
        });
    });
</script>
</body>
</html>
