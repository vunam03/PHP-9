<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../login/login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "mysql_todolist";

$conn = mysqli_connect($servername, $username, $password, $db_name);

$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $address = $_POST['address'];

    $update_query = "UPDATE tbl_user SET name = '$name', email = '$email', phone_number = '$phone', gender = '$gender', dob = '$birthdate', address = '$address' WHERE id = $user_id";

    if (mysqli_query($conn, $update_query)) {
        header("Location:../View_profile/ViewProfile1.php?id=$user_id");
    } else {
        echo "Có lỗi khi cập nhật thông tin: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
