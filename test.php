<?php
// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "diemsinhvien";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Giá trị của ID sinh viên và ID học kỳ
$idSinhVien = 3; // Thay thế bằng ID sinh viên cụ thể
$idHocKy = 2;    // Thay thế bằng ID học kỳ cụ thể

// Truy vấn SQL để tính tổng điểm, điểm trung bình và điểm hệ 4
$sql = "SELECT 
        sv.idSinhVien,
        sv.HoTen,
        hk.TenHocKy,
        hk.NamHoc,
        SUM(d.TongKetHocPhan) AS TongDiem,
        SUM(mh.SoTinChi) AS TongSoTinChi,
        SUM(d.TongKetHocPhan) / SUM(mh.SoTinChi) AS DiemTrungBinh,
        (SUM(d.TongKetHocPhan) / SUM(mh.SoTinChi)) / 2.5 AS DiemHe4
    FROM 
        SinhVien sv
    JOIN 
        Diem d ON sv.idSinhVien = d.idSinhVien
    JOIN 
        MonHoc mh ON d.idMonHoc = mh.idMonHoc
    JOIN 
        HocKy hk ON mh.idHocKy = hk.idHocKy
    WHERE 
        sv.idSinhVien = ? 
        AND hk.idHocKy = ?
    GROUP BY 
        sv.idSinhVien, sv.HoTen, hk.TenHocKy, hk.NamHoc;
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $idSinhVien, $idHocKy);
$stmt->execute();
$result = $stmt->get_result();

// Hiển thị kết quả
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID Sinh Viên: " . $row["idSinhVien"] . "<br>";
        echo "Họ Tên: " . $row["HoTen"] . "<br>";
        echo "Học Kỳ: " . $row["TenHocKy"] . "<br>";
        echo "Năm Học: " . $row["NamHoc"] . "<br>";
        echo "Tổng Điểm: " . $row["TongDiem"] . "<br>";
        echo "Tổng Số Tín Chỉ: " . $row["TongSoTinChi"] . "<br>";
        echo "Điểm Trung Bình: " . $row["DiemTrungBinh"] . "<br>";
        echo "Điểm Hệ 4: " . $row["DiemHe4"] . "<br>";
    }
} else {
    echo "Không tìm thấy kết quả.";
}

$stmt->close();
$conn->close();
?>