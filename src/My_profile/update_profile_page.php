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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="update_profile_page.css">
</head>
<body>
    <h1 class="tieude">Trang chủ</h1>
    <div class="all">
        <div class="content_up">
            <div class="box_img">
                <img src="https://img.meta.com.vn/Data/image/2021/09/22/anh-meo-cute-de-thuong-dang-yeu-42.jpg" alt="" style="width: 300px;
                height: 300px;
                flex-shrink: 0;
                border-radius: 200px;
                margin-left: 50px;">
            </div>

            <div class="box_inf">
                <form id="profileForm" method="post" action="update_profile.php">
                    <div class="box_input">
                        <p class="p_1">Tên</p>
                        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
                    </div>
                    <div class="box_input">
                        <p class="p_1">Email</p>
                        <input type="text" id="email" name="email" placeholder="Nhập email của bạn" value="<?php echo $row['email']; ?>"required>
                    </div>
                    <div class="box_input">
                        <p class="p_1">Số điện thoại</p>
                        <input type="number" style="appearance: textfield;" id="phone" name="phone" placeholder="Nhập số điện thoại của bạn" value="<?php echo $row['phone_number']; ?>">
                    </div>
                    <div class="box_input_2">
                        <div class="box_dob_pn">
                            <p class="p_1">DOB</p>
                            <input type="date" style="font-family:Arial, Helvetica, sans-serif "id="birthdate" name="birthdate" value="<?php echo $row['dob']; ?>">
                        </div>
                        <div class="box_dob_pn">
                            <p class="p_1">Giới tính</p>
                            <select class="gendercss" id="gender" name="gender">
                                <option value="Nam" <?php echo ($row['gender'] === 'Nam') ? 'selected' : ''; ?>>Nam</option>
                                <option value="Nữ" <?php echo ($row['gender'] === 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                            </select>
                        </div>
                    </div>
                    <div class="box_input">
                        <p class="p_1">Địa chỉ</p>
                        <input type="text" id="address" name="address" placeholder="Nhập địa chỉ của bạn" value="<?php echo $row['address']; ?>">
                    </div>
                </form>
            </div>
        </div>

        <div class="content_down"></div>
    
    </div>
    <div class="button_box">
        <button id="submitButton" type="submit" style="background-color: orange; border-radius: 10px; color: white;" >
            Xác nhận
        </button>
        <button style="background-color: orange; border-radius: 10px; color: white; " onclick="window.location.href='../View_profile/ViewProfile1.php?id=<?php echo intval($user_id); ?>'">
            Hủy 
        </button>
    </div>

    <script>
        function validateForm() {
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;

            if (name === "") {
                document.getElementById("name").classList.add("is-invalid");
                alert("Bạn chưa nhập tên!");
                return false;
            } else {
                document.getElementById("name").classList.remove("is-invalid");
            }

            if (!/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}/i.test(email)) {
                document.getElementById("email").classList.add("is-invalid");
                alert("Bạn chưa nhập email chính xác!");
                return false;
            } else {
                document.getElementById("email").classList.remove("is-invalid");
            }

            return true;
        }


         // Hàm xử lý khi người dùng nhấn nút "Lưu"
         document.getElementById("submitButton").addEventListener("click", function() {
            if (!validateForm()) {
                return;
            }

            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var phone = document.getElementById("phone").value;
            var gender = document.getElementById("gender").value;
            var birthdate = document.getElementById("birthdate").value;
            var address = document.getElementById("address").value;

            document.getElementById("infoName").innerHTML = name;
            document.getElementById("infoEmail").innerHTML = email;
            document.getElementById("infoPhone").innerHTML = phone;
            document.getElementById("infoGender").innerHTML = gender;
            document.getElementById("infoBirthdate").innerHTML = birthdate;
            document.getElementById("infoAddress").innerHTML = address;

            document.getElementById("profileForm").style.display = "none";
            document.getElementById("profileInfo").style.display = "block";        

            // Lắng nghe sự kiện click của nút "Quay lại"
            document.getElementById("backButton").addEventListener("click", function goBack() {
                window.history.back();
                document.getElementById("profileForm").style.display = "block";
                document.getElementById("profileInfo").style.display = "none";
            });
        });

        document.getElementById('submitButton').addEventListener('click', function() {
    document.getElementById('profileForm').submit();
});
    </script>
</body>
</html>

<?php
// Đóng kết nối cơ sở dữ liệu
mysqli_close($conn);
?>