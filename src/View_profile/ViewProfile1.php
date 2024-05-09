
<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['id'])) {
    header("Location: ../login/login.php"); // Điều hướng người dùng đến trang đăng nhập nếu chưa đăng nhập.
    exit();
}

// Kết nối đến cơ sở dữ liệu (sử dụng thông tin cấu hình của bạn)
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "mysql_todolist";

$conn = mysqli_connect($servername, $username, $password, $db_name);

// Lấy ID của người dùng từ phiên (session)
$user_id = $_SESSION['id'];

// Truy vấn thông tin của tài khoản người dùng dựa trên ID
$query = "SELECT * FROM tbl_user WHERE id = $user_id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Lỗi truy vấn cơ sở dữ liệu: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) === 0) {
    die("Không tìm thấy thông tin tài khoản người dùng.");
}

$row = mysqli_fetch_assoc($result);

$name = $row['name'];
$email = $row['email'];
$phoneNumber = $row['phone_number'];
$dob = $row['dob'];
$dobFormatted = date('d-m-Y', strtotime($dob));
$address = $row['address'];
$gender = $row['gender'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="viewprofile1.css">
</head>
<body>
    
    <h1 class="tieude">Trang cá nhân</h1>
    <div class="all">
        <div class="box_img">
            <img src="https://img.meta.com.vn/Data/image/2021/09/22/anh-meo-cute-de-thuong-dang-yeu-42.jpg" alt="" style="width: 300px;
            height: 300px; border-radius: 200px;margin-top: 40px;margin-left: 40px;">
        </div>
        <div class="box_inf">
            <div class="box_inf_1">
                <div class="box_inf_1_1">
                    <p class="p_1">Tên</p>
                    <p class="p_2"><?php echo $name; ?></p>
                </div>
                <div class="box_inf_1_1">
                    <p class="p_1">Email</p>
                    <p class="p_2"><?php echo $email; ?></p>
                </div>
            </div>
            <div class="box_inf_1">
                <div class="box_inf_1_1">
                    <p class="p_1">Số điện thoại</p>
                    <p class="p_2"><?php echo $phoneNumber; ?></p>
                </div>
                <div class="box_inf_1_1">
                    <p class="p_1">DoB</p>
                    <p class="p_2"><?php echo $dobFormatted; ?></p>
                </div>
            </div>
            <div class="box_inf_1">
                <div class="box_inf_1_1">
                    <p class="p_1">Địa chỉ</p>
                    <p class="p_2"><?php echo $address; ?></p>
                </div>
                <div class="box_inf_1_1">
                    <p class="p_1">Giới tính</p>
                    <p class="p_2"><?php echo $gender; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="button_box">
        <button style="background-color: orange; border-radius: 10px; color: white;" onclick="window.location.href='../My_profile/update_profile_page.php?id=<?php echo intval($user_id); ?>'">
            Cập nhật
        </button>
        <button style="background-color: orange; border-radius: 10px; color: white; " onclick="window.location.href='../trangchu/dist/index.php?id=<?php echo intval($user_id); ?>'">
            Trang chủ
        </button>

        <button style="background-color: orange; border-radius: 10px; color: white; margin-left: 980px; " onclick="window.location.href='../login/login.php'">
            Đăng xuất
        </button>
    </div>
</body>
</html> 

<?php
// Đóng kết nối cơ sở dữ liệu
mysqli_close($conn);
?>