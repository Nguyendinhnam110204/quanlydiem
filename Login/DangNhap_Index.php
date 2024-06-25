<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../CSS/Login.css?v = <?php echo time(); ?>">
    <title>Login</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-in">
            <form action="DangNhap.php" method="post">
                <h1>Đăng nhập</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>hoặc sử dụng mã người dùng và mật khẩu</span>
                <input type="text" placeholder="Mã người dùng" name="TenDangNhap" required>
                <input type="password" placeholder="Mật khẩu" name="MatKhau" required>
                <button>Đăng nhập</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>Chào mừng Bạn!</h1>
                    <p>
                       Đại học UTT là một trong những cơ sở giáo dục hàng đầu tại khu vực này,
                       nổi bật với sự cam kết mang đến chất lượng giáo dục cao và môi trường
                       học tập thân thiện.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>