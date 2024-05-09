<?php
session_start();
include "../../sever/config/config.php";

if (isset($_POST['login_email']) && isset($_POST['login_password'])){
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data =  htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST['login_email']);
    $password = validate($_POST['login_password']);

    if (empty($email)){
        header("Location: login.php?error=Chưa nhập tài khoản");
        exit();
    } else if(empty($password)){
        header("Location: login.php?error=Chưa nhập mật khẩu");
        exit();
    } else {
        $sql = "SELECT * FROM tbl_user WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            if ($row['email'] === $email && $row['password'] === $password){
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                $user_id = $row['id'];
                header("Location:../trangchu/dist/index.php?id=$user_id");
                echo "loggin";
            }
            else {
                header("Location: login.php?error=Tài khoản hoặc mật khẩu không đúng");
                exit();
            }
        }
        else {
            header("Location: login.php?error=Tài khoản hoặc mật khẩu không đúng");
            exit();
        }
    }
} else {
    header("Location: login.php");
    exit();
}
