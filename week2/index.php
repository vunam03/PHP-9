
<?php
// Thông tin cơ sở dữ liệu
$server = "localhost"; // Tên server MySQL
$username1 = "root"; // Tên đăng nhập MySQL
$password1 = "21122003"; // Mật khẩu MySQL
$database = "login"; // Tên cơ sở dữ liệu

// Tạo kết nối đến cơ sở dữ liệu
$conn = mysqli_connect($server, $username1, $password1, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Xử lý đăng nhập nếu có dữ liệu được gửi từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Xử lý truy vấn kiểm tra thông tin đăng nhập
    $query = "SELECT * FROM usename WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        // Đăng nhập thành công
        echo "Đăng nhập thành công!";
        // Thực hiện các thao tác tiếp theo sau khi đăng nhập thành công
        // Ví dụ: chuyển hướng người dùng đến trang chính sau khi đăng nhập
        // header("Location: home.php");
        exit();
    } else {
        // Đăng nhập thất bại
        echo "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng nhập</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="username">Tên đăng nhập:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Mật khẩu:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Đăng nhập</button>
    </form>
</body>
</html>