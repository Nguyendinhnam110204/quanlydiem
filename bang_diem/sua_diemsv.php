<?php
require_once '../folderconnect/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $id = $_POST['idDiem']; // ID của bản ghi cần cập nhật
    $MaSinhVien = $_POST['MaSinhVien'];
    $HoTen = $_POST['HoTen'];
    $TenLop = $_POST['TenLop'];
    $DiemChuyenCan = $_POST['DiemChuyenCan'];
    $DiemGiuaKy = $_POST['DiemGiuaKy'];
    $DiemCuoiKylan1 = $_POST['DiemCuoiKylan1'];
    $DiemCuoiKylan2 = $_POST['DiemCuoiKylan2'];

    // Tính toán điểm tổng kết học phần cho từng lần thi
    $TongKetHocPhan_lan1 = ($DiemChuyenCan * 0.1 + $DiemGiuaKy * 0.3 + $DiemCuoiKylan1 * 0.6);
    $TongKetHocPhan_lan2 = null;
    if ($DiemCuoiKylan2 !== '') {
        $TongKetHocPhan_lan2 = ($DiemChuyenCan * 0.1 + $DiemGiuaKy * 0.3 + $DiemCuoiKylan2 * 0.6);
    }

    //  echo "TongKetHocPhan_lan1: $TongKetHocPhan_lan1<br>";
    //  echo "TongKetHocPhan_lan2: $TongKetHocPhan_lan2<br>";

    // Tính toán điểm chữ dựa trên tổng kết học phần
    function getDiemChu($TongKetHocPhan) {
        if ($TongKetHocPhan < 4.0) {
            return 'F';
        } elseif ($TongKetHocPhan >= 4.0 && $TongKetHocPhan < 4.5) {
            return 'D';
        } elseif ($TongKetHocPhan > 4.5 && $TongKetHocPhan <= 5.0) {
            return 'D+';
        } elseif ($TongKetHocPhan >= 5.1 && $TongKetHocPhan < 6.0) {
            return 'C';
        } elseif ($TongKetHocPhan >= 6.1 && $TongKetHocPhan < 6.9) {
            return 'C+';
        } elseif ($TongKetHocPhan >= 7.0 && $TongKetHocPhan < 8) {
            return 'B';
        } elseif ($TongKetHocPhan > 8.0 && $TongKetHocPhan < 8.5) {
            return 'B+';
        } else  {
            return 'A';
        }
    }

    //  // Chuyển đổi điểm tổng kết học phần sang GPA (điểm trung bình tích lũy)
    //  function calculateGPA($TongKetHocPhan) {
    //     if ($TongKetHocPhan >= 8.5) {
    //         return 4.0;
    //     } elseif ($TongKetHocPhan >= 8.0) {
    //         return 3.8;
    //     } elseif ($TongKetHocPhan >= 7.5) {
    //         return 3.5;
    //     } elseif ($TongKetHocPhan >= 7.0) {
    //         return 3.2;
    //     } elseif ($TongKetHocPhan >= 6.5) {
    //         return 3.0;
    //     } elseif ($TongKetHocPhan >= 6.0) {
    //         return 2.8;
    //     } elseif ($TongKetHocPhan >= 5.5) {
    //         return 2.5;
    //     } elseif ($TongKetHocPhan >= 5.0) {
    //         return 2.0;
    //     } else {
    //         return 0.0; // Trường hợp còn lại không đạt
    //     }
    // }

    // // Tính toán điểm GPA cho từng lần thi
    // $GPA_lan1 = calculateGPA($TongKetHocPhan_lan1);
    // $GPA_lan2 = null;
    // if ($TongKetHocPhan_lan2 !== null) {
    //     $GPA_lan2 = calculateGPA($TongKetHocPhan_lan2);
    // }

    // // Lấy giá trị GPA cuối cùng (lấy giá trị GPA lớn nhất nếu có hai lần thi)
    // $GPA_combined = $GPA_lan1;
    // if ($GPA_lan2 !== null && $GPA_lan2 > $GPA_lan1) {
    //     $GPA_combined = $GPA_lan2;
    // }

    // Kết hợp điểm tổng kết học phần
    if ($TongKetHocPhan_lan2 !== null) {
        $TongKetHocPhan_combined = $TongKetHocPhan_lan2;
    } else {
        $TongKetHocPhan_combined = $TongKetHocPhan_lan1 ;
    }

    //  echo "TongKetHocPhan_combined: $TongKetHocPhan_combined<br>";

    $diemChu_lan1 = getDiemChu($TongKetHocPhan_lan1);
    if ($TongKetHocPhan_lan2 !== null) {
        $diemChu_lan2 = getDiemChu($TongKetHocPhan_lan2);
    } else {
        $diemChu_lan2 = '';
    }

    // Kết hợp điểm chữ
    if ($diemChu_lan2 !== '') {
         $diemChu_combined = $diemChu_lan1 . '|' . $diemChu_lan2;
        //$diemChu_combined =  $diemChu_lan2;
    } else {
        $diemChu_combined = $diemChu_lan1 ;
    }

    //  echo "diemChu_combined: $diemChu_combined<br>";

    // Xác định đánh giá
    if ($TongKetHocPhan_lan2 !== null && $TongKetHocPhan_lan2 < 4.0) {
        $DanhGia = 'Hoc Lai';
    } elseif ($TongKetHocPhan_lan2 !== null && $TongKetHocPhan_lan2 >= 4.0) {
        $DanhGia = 'DAT';
    } elseif ($TongKetHocPhan_lan1 >= 4.0) {
        $DanhGia = 'DAT';
    } else {
        $DanhGia = 'Thi Lai';
    }

    //  echo "DanhGia: $DanhGia<br>";

    // Cập nhật bảng sinhvien
    $sql_update_sinhvien = "
    UPDATE sinhvien 
    SET MaSinhVien = '$MaSinhVien', HoTen = '$HoTen'
    WHERE idSinhVien = (SELECT idSinhVien FROM diem WHERE idDiem = '$id')";

    // Cập nhật bảng lop
    $sql_update_lop = "
    UPDATE lop 
    SET TenLop = '$TenLop'
    WHERE idLop = (SELECT idLop FROM sinhvien WHERE idSinhVien = (SELECT idSinhVien FROM diem WHERE idDiem = '$id'))";  

    // Cập nhật bảng diem
    $sql_update_diem = "
    UPDATE diem 
    SET DiemChuyenCan = '$DiemChuyenCan', DiemGiuaKy = '$DiemGiuaKy', DiemCuoiKylan1 = '$DiemCuoiKylan1'";
    if ($DiemCuoiKylan2 !== '') {
        $sql_update_diem .= ", DiemCuoiKylan2 = '$DiemCuoiKylan2'";
    }
    $sql_update_diem .= ", TongKetHocPhan = '$TongKetHocPhan_combined', DiemChu = '$diemChu_combined', DanhGia = '$DanhGia'
    WHERE idDiem = '$id'";

    //  echo "SQL: $sql_update_diem<br>";

    // Thực hiện cập nhật
    if (mysqli_query($conn, $sql_update_sinhvien) && mysqli_query($conn, $sql_update_lop) && mysqli_query($conn, $sql_update_diem)) {
        echo "<script>
    alert('Cập nhật điểm thành công.');
    window.history.back(); // Quay lại trang trước đó
</script>";
        
    } else {
        echo "Lỗi cập nhật: " . mysqli_error($conn);
    }
       // Tính GPA sau khi cập nhật điểm
    $sql_gpa = "SELECT 
    SUM(d.TongKetHocPhan ) / SUM(mh.SoTinChi) / 2.5 AS GPA
FROM 
    diem d
JOIN 
    monhoc mh ON d.idMonHoc = mh.idMonHoc
JOIN 
    hocky hk ON mh.idHocKy = hk.idHocKy
WHERE 
    d.idSinhVien = (SELECT idSinhVien FROM diem WHERE idDiem = '$id')
    AND hk.idHocKy = (SELECT idHocKy FROM diem WHERE idDiem = '$id')
";

$result_gpa = mysqli_query($conn, $sql_gpa);

if ($result_gpa && mysqli_num_rows($result_gpa) > 0) {
$row_gpa = mysqli_fetch_assoc($result_gpa);
$GPA = $row_gpa['GPA'];

// Kiểm tra xem có bản ghi GPA nào tồn tại với idSinhVien và idHocKy không
$sql_check_gpa = "SELECT idGPA FROM gpa
WHERE idSinhVien = (SELECT idSinhVien FROM diem WHERE idDiem = '$id')
AND idHocKy = (SELECT idHocKy FROM diem WHERE idDiem = '$id')";

$result_check_gpa = mysqli_query($conn, $sql_check_gpa);

if (mysqli_num_rows($result_check_gpa) > 0) {
    // Nếu có bản ghi, cập nhật GPA
    $sql_update_gpa = "UPDATE gpa
    SET GPA = $GPA
    WHERE idSinhVien = (SELECT idSinhVien FROM diem WHERE idDiem = '$id')
    AND idHocKy = (SELECT idHocKy FROM diem WHERE idDiem = '$id')";

    if (mysqli_query($conn, $sql_update_gpa)) {
        echo "Cập nhật GPA thành công";
    } else {
        echo "Lỗi khi cập nhật GPA: " . mysqli_error($conn);
    }
} else {
    // Nếu không có bản ghi, chèn bản ghi mới
    $sql_insert_gpa = "INSERT INTO gpa (idSinhVien, idHocKy, GPA)
    SELECT d.idSinhVien, d.idHocKy, $GPA
    FROM diem d
    WHERE d.idDiem = '$id'
    GROUP BY d.idSinhVien, d.idHocKy";

    if (mysqli_query($conn, $sql_insert_gpa)) {
        echo "Chèn GPA thành công";
    } else {
        echo "Lỗi khi chèn GPA: " . mysqli_error($conn);
    }
}
} else {
echo "Lỗi khi tính toán GPA: " . mysqli_error($conn);
}

  // Tính GPA cho sinh viên trong học kỳ cụ thể
    mysqli_close($conn);
}

?>
