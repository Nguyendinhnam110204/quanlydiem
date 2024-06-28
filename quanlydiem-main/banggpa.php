<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhập Điểm Sinh Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin: 0 auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Nhập Điểm Sinh Viên</h2>
        <form action="process_grade.php" method="post">
            <div class="form-group">
                <label for="student_id">Mã Sinh Viên:</label>
                <input type="text" id="student_id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="class">Lớp Học:</label>
                <input type="text" id="class" name="class" required>
            </div>
            <div class="form-group">
                <label for="course">Môn Học:</label>
                <select id="course" name="course" required>
                    <option value="">Chọn môn học</option>
                    <option value="MA001">Toán cao cấp</option>
                    <option value="PH001">Vật lý đại cương</option>
                    <option value="EN001">Tiếng Anh căn bản</option>
                    <!-- Thêm các môn học khác vào đây -->
                </select>
            </div>
            <div class="form-group">
                <label for="credit">Số Tín Chỉ:</label>
                <input type="text" id="credit" name="credit" required>
            </div>
            <div class="form-group">
                <label for="grade">Điểm Môn Học:</label>
                <input type="text" id="grade" name="grade" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Nhập Điểm">
            </div>
        </form>
    </div>
</body>
</html>
