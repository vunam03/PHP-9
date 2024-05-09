<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "mysql_todolist";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$db_name);

// Check connection 
// Kiểm tra nếu biểu mẫu chỉnh sửa đã được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối đến cơ sở dữ liệu (sử dụng thông tin cấu hình của bạn)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "mysql_todolist";

    $conn = mysqli_connect($servername, $username, $password, $db_name);

    if (!$conn) {
        die("Lỗi kết nối cơ sở dữ liệu: " . mysqli_connect_error());
    }

    // Lấy dữ liệu từ biểu mẫu chỉnh sửa
    $editedTask = $_POST['edited_task'];
    $taskID = $_POST['task_id'];

    // Thực hiện cập nhật công việc trong cơ sở dữ liệu
    $updateQuery = "UPDATE tbl_todolist SET title = '$editedTask' WHERE stt = $taskID";

    if (mysqli_query($conn, $updateQuery)) {
        // Cập nhật thành công
        header("Location: home.php"); // Điều hướng người dùng trở lại trang home sau khi cập nhật
        exit();
    } else {
        // Xử lý lỗi khi cập nhật thất bại
        echo 'Lỗi cập nhật công việc: ' . mysqli_error($conn) ;
    }

    // Đóng kết nối cơ sở dữ liệu
    mysqli_close($conn);
}
?>
