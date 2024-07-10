<?php
require_once '../folderconnect/connect.php';

// Hàm kiểm tra xem đã có tài khoản admin nào trong cơ sở dữ liệu chưa
function isAdminExist($conn) {
    $check_sql = "SELECT * FROM NguoiDung WHERE VaiTro = 'admin'";
    $check_result = mysqli_query($conn, $check_sql);
    return mysqli_num_rows($check_result) > 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $idNguoiDung = $_POST['idNguoiDung'];
    $tenDangNhap = $_POST['TenDangNhap'];
    $matKhau = $_POST['MatKhau'];
    $vaiTro = $_POST['VaiTro'];

    // Kiểm tra mật khẩu có đáp ứng yêu cầu
    if (strlen($matKhau) < 8 || strlen($matKhau) > 24 || !preg_match('/[A-Z]/', $matKhau)) {
        echo '<script>alert("Mật khẩu phải có độ dài từ 8 đến 24 ký tự và chứa ít nhất một chữ cái viết hoa!"); window.history.back();</script>';
        exit; // Dừng lại nếu mật khẩu không hợp lệ
    }

    // Kiểm tra xem đã tồn tại tài khoản admin chưa
    if ($vaiTro === 'admin' && isAdminExist($conn)) {
        echo '<script>alert("Chỉ được phép tồn tại một tài khoản admin!"); window.history.back();</script>';
        exit; // Dừng lại nếu đã tồn tại tài khoản admin
    }

    // Kiểm tra xem tên đăng nhập đã tồn tại chưa, ngoại trừ người dùng hiện tại
    $check_sql = "SELECT * FROM NguoiDung WHERE TenDangNhap = '$tenDangNhap' AND idNguoiDung != '$idNguoiDung'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Nếu tên đăng nhập đã tồn tại, thông báo lỗi
        echo '<script>alert("Tên đăng nhập đã tồn tại!"); window.history.back();</script>';
    } else {
        // Mã hóa mật khẩu chỉ nếu mật khẩu mới được cung cấp (không trống)
        if (!empty($matKhau)) {
            $hashed_password = password_hash($matKhau, PASSWORD_BCRYPT);
        } else {
            // Nếu không thay đổi mật khẩu, giữ nguyên mật khẩu cũ
            $password_sql = "SELECT MatKhau FROM NguoiDung WHERE idNguoiDung = '$idNguoiDung'";
            $password_result = mysqli_query($conn, $password_sql);
            $row = mysqli_fetch_assoc($password_result);
            $hashed_password = $row['MatKhau'];
        }

        // Câu lệnh SQL để cập nhật dữ liệu vào bảng NguoiDung
        $update_sql = "UPDATE NguoiDung SET TenDangNhap = '$tenDangNhap', MatKhau = '$hashed_password', VaiTro = '$vaiTro' WHERE idNguoiDung = '$idNguoiDung'";

        // Thực thi câu lệnh SQL
        if (mysqli_query($conn, $update_sql)) {
            // Nếu thêm thành công, thông báo và đóng modal
            echo '<script>alert("Sửa tài khoản người dùng thành công!"); window.location.href = "index_NguoiDung.php";</script>';
        } else {
            // Nếu có lỗi, thông báo lỗi
            echo "Error: " . $update_sql . "<br>" . mysqli_error($conn);
        }
    }

    // Đóng kết nối
    mysqli_close($conn);
}
?>
