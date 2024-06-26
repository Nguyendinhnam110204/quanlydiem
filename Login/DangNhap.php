<?php
require_once '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form và thực hiện kiểm tra, làm sạch dữ liệu
    $tenDangNhap = trim($_POST['TenDangNhap']);
    $matKhau = trim($_POST['MatKhau']);
    
    // Chuẩn bị câu lệnh SQL với prepared statements để ngăn chặn SQL Injection
    $stmt = $conn->prepare("SELECT idNguoiDung, MatKhau, TenDangNhap, VaiTro FROM NguoiDung WHERE TenDangNhap = ?");
    $stmt->bind_param("s", $tenDangNhap);

    // Thực thi câu lệnh SQL
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($idNguoiDung, $matKhauMaHoa, $tenDangNhapDB, $vaiTro);
        $stmt->fetch();

        // Kiểm tra mật khẩu
        if (password_verify($matKhau, $matKhauMaHoa)) {
            // Đăng nhập thành công
            session_start();
            $_SESSION['idNguoiDung'] = $idNguoiDung;
            $_SESSION['TenDangNhap'] = $tenDangNhapDB;
            $_SESSION['VaiTro'] = $vaiTro;

            // Phân quyền dựa trên vai trò
            if ($vaiTro == 'giao_vien') {
                echo "<script>
                        alert('Đăng nhập thành công với vai trò giảng viên.');
                        window.location.href = '../GiangVien_Index.php'; // Đổi thành trang chính của giảng viên
                    </script>";
            }if ($vaiTro == 'sinh_vien'){
                echo "<script>
                        alert('Đăng nhập thành công với vai trò sinh viên.');
                        window.location.href = '../SinhVien_Index.php'; // Đổi thành trang chính của sinh viên
                    </script>";
            }else {
                echo "<script>
                        alert('Đăng nhập thành công.');
                        window.location.href = '../Admin_Index.php'; // Đổi thành trang chính của quản trị viên
                    </script>";
            }
        } else {
            echo "<script>
                    alert('Sai mật khẩu. Vui lòng thử lại.');
                    window.location.href = 'Dangnhap_Index.php';
                </script>";
        }
    } else {
        echo "<script>
                alert('Không tìm thấy tài khoản. Vui lòng kiểm tra lại tên đăng nhập.');
                window.location.href = 'Dangnhap_Index.php';
            </script>";
    }

    // Đóng statement và connection
    $stmt->close();
    $conn->close();
}
?>
