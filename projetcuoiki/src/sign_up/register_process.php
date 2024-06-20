<?php
include "../../sever/config/config.php";

if (isset($_POST['signup_email']) && isset($_POST['signup_password']) && isset($_POST['confirm_password']) && isset($_POST['sbm'])) {

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
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: sign_up.php?error=Email phải có dạng @gmail.com");
        exit();
    } elseif ($password !== $confirm_password) {
        header("Location: sign_up.php?error=Mật khẩu và xác nhận mật khẩu không khớp");
        exit();
    } else {
        // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu chưa
        $stmt = $conn->prepare("SELECT email FROM tbl_user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            header("Location: sign_up.php?error=Email này đã được sử dụng");
            exit();
        }

        $stmt->close();

        // Kiểm tra xem tên đã tồn tại trong cơ sở dữ liệu chưa
        $stmt = $conn->prepare("SELECT name FROM tbl_user WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            header("Location: sign_up.php?error=Tên này đã được sử dụng");
            exit();
        }

        $stmt->close();

        // Sử dụng câu lệnh chuẩn bị để bảo vệ chống lại SQL Injection
        $stmt = $conn->prepare("INSERT INTO tbl_user (email, password, name) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $password, $name);

        if ($stmt->execute()) {
            // Đăng ký thành công, chuyển hướng đến trang đăng nhập
            header("Location: ../login/login.php");
            exit();
        } else {
            header("Location: sign_up.php?error=Lỗi trong quá trình đăng ký");
            exit();
        }

        $stmt->close();
    }
} else {
    header("Location: sign_up.php");
    exit();
}
?>
