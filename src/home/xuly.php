<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_task'])) {
    $editedTask = $_POST['edited_task'];
    $task_id = $_POST['task_id'];

    // Kết nối đến cơ sở dữ liệu (sử dụng thông tin cấu hình của bạn)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "mysql_todolist";

    $conn = mysqli_connect($servername, $username, $password, $db_name);

    if (!$conn) {
        die("Kết nối cơ sở dữ liệu thất bại: " . mysqli_connect_error());
    }

    // Thực hiện câu lệnh SQL để cập nhật dữ liệu
    $updateQuery = "UPDATE tbl_todolist SET title = '$editedTask' WHERE stt = $task_id AND id = $user_id";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Cập nhật thành công
        echo "Cập nhật công việc thành công!";
    } else {
        // Xử lý lỗi khi truy vấn cập nhật thất bại
        echo "Lỗi cập nhật công việc: " . mysqli_error($conn);
    }

    // Đóng kết nối cơ sở dữ liệu
    mysqli_close($conn);
}
?>
