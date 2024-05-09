<?php

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "mysql_todolist";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$db_name);

// Check connection 
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

if (isset($_POST['cp_email']) && isset($_POST['old_password']) && isset($_POST['new_password'])) {
    $cp_email = $_POST['cp_email'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    // Kiểm tra xem email có tồn tại trong cơ sở dữ liệu
    $check_email_sql = "SELECT id, password FROM tbl_user WHERE email='$cp_email'";
    $result = mysqli_query($conn, $check_email_sql);

    if (empty($cp_email) || empty($old_password) || empty($new_password)) {
        header("Location: forgot_pass.php?error=Tất cả các trường là bắt buộc");
        exit();
    } 
    elseif  (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
        $db_password = $row['password'];

        // Kiểm tra xem mật khẩu hiện tại có khớp với mật khẩu trong cơ sở dữ liệu không
        if ($old_password === $db_password) {
            // Cập nhật mật khẩu mới
            $update_password_sql = "UPDATE tbl_user SET password='$new_password' WHERE id=$id";
            if (mysqli_query($conn, $update_password_sql)) {
                header("Location: ../login/login.php");
                exit();
            } else {
                header("Location: forgot_pass.php?error=Mật khẩu và xác nhận mật khẩu không khớp");
                echo "Lỗi: " . mysqli_error($conn);
            }
        } else {
            header("Location: forgot_pass.php?error=Mật khẩu hiện tại không đúng. Vui lòng kiểm tra lại");
            // echo "Mật khẩu hiện tại không đúng. Vui lòng kiểm tra lại.";
        }
    } else {
        header("Location: forgot_pass.php?error=Email không tồn tại");
        // echo "Email không tồn tại trong cơ sở dữ liệu.";
    }
} else {
    echo "Vui lòng cung cấp đủ thông tin.";
}

?>
