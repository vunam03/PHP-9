<?php
include "../../sever/config/config.php";

if (isset($_POST['signup_email']) && isset($_POST['signup_password']) && isset($_POST['confirm_password'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['signup_email']);
    $password = validate($_POST['signup_password']);
    $confirm_password = validate($_POST['confirm_password']);
    $name = validate($_POST['name']);

    if (empty($email) || empty($password) || empty($name)) {
        header("Location: sign_up.php?error=Tất cả các trường là bắt buộc");
        exit();
    } elseif ($password !== $confirm_password) {
        header("Location: sign_up.php?error=Mật khẩu và xác nhận mật khẩu không khớp");
        exit();
    } else {
        // Thực hiện câu lệnh SQL INSERT với dữ liệu từ biểu mẫu
        $sql = "INSERT INTO tbl_user (email, password, name) VALUES ('$email', '$password', '$name')";
        if (mysqli_query($conn, $sql)) {
            // Đăng ký thành công, bạn có thể thực hiện các hành động khác (ví dụ: đăng nhập ngay lập tức).
            header("Location: ../login/login.php");
            echo "Đăng ký thành công!";
        } else {
            header("Location: sign_up.php?error=Lỗi trong quá trình đăng ký");
            exit();
        }
    }
} else {
    header("Location: sign_up.php");
    exit();
}
