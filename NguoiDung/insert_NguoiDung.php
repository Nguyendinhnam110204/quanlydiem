<?php
    // Kết nối tới cơ sở dữ liệu
    require_once '../folderconnect/connect.php'; // File connect.php chứa thông tin kết nối MySQL

    // Hàm kiểm tra xem đã có tài khoản admin nào trong cơ sở dữ liệu chưa
    function isAdminExist($conn) {
        $check_sql = "SELECT * FROM NguoiDung WHERE VaiTro = 'admin'";
        $check_result = mysqli_query($conn, $check_sql);
        return mysqli_num_rows($check_result) > 0;
    }

    // Kiểm tra nếu form được gửi đi (người dùng nhấn nút Thêm)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy dữ liệu từ form
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

        $check_sql = "SELECT * FROM NguoiDung WHERE TenDangNhap = '$tenDangNhap'";
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            // Nếu tên đăng nhập đã tồn tại, thông báo lỗi
            echo '<script>alert("Tên đăng nhập đã tồn tại!"); window.history.back();</script>';
        } else {
            // Mã hóa mật khẩu
            $matKhauMaHoa = password_hash($matKhau, PASSWORD_BCRYPT);

            // Câu lệnh SQL để chèn dữ liệu vào bảng NguoiDung
            $insert_sql = "INSERT INTO NguoiDung (TenDangNhap, MatKhau, VaiTro) 
                        VALUES ('$tenDangNhap', '$matKhauMaHoa', '$vaiTro')";

            // Thực thi câu lệnh SQL
            if (mysqli_query($conn, $insert_sql)) {
                // Nếu thêm thành công, thông báo và đóng modal
                echo '<script>alert("Thêm tài khoản người dùng thành công!");</script>';
                header("Location: index_NguoiDung.php");
            } else {
                // Nếu có lỗi, thông báo lỗi
                echo "Error: " . $insert_sql . "<br>" . mysqli_error($conn);
            }
        }
        // Đóng kết nối
        mysqli_close($conn);
    }
?>
