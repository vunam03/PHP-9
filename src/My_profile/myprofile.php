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
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="myprofile.css">
    <title>Form nhập thông tin cá nhân</title>
</head>

<body>
    <div class="container">
        <h1>My Profile</h1>
        <div class="line"></div>
        <form id="profileForm" method="post" action="update_profile.php">
            <div id="Avatar" class="form-group">
                <img id="avatarPreview" src="../image/Screenshot 2023-10-31 190301.png" class="image" alt="Ảnh đại diện">
                <div class="middle">
                    <label for="avatar">Ảnh đại diện</label>
                    <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                </div>
            </div>
            <div class="form-group">
                <label class="text" for="name">Tên</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên của bạn" value="<?php echo $row['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email của bạn" value="<?php echo $row['email']; ?>"required>
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại của bạn" value="<?php echo $row['phone_number']; ?>">
            </div>
            <div class="form-group">
    <label for="gender">Giới tính</label>
    <select class="form-control" id="gender" name="gender">
        <option value="Nam" <?php echo ($row['gender'] === 'Nam') ? 'selected' : ''; ?>>Nam</option>
        <option value="Nữ" <?php echo ($row['gender'] === 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
    </select>
</div>

            <div class="form-group">
                <label for="birthdate">Ngày sinh</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo $row['dob']; ?>">
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" class "form-control" id="address" name="address" placeholder="Nhập địa chỉ của bạn" value="<?php echo $row['address']; ?>">
            </div>
            <button type="submit" id="submitButton">Lưu</button>
        </form>
        <!-- <div id="profileInfo" style="display: none;">
            <h3>Thông Tin Cá Nhân</h3>
            <p><strong>Tên:</strong> <span id="infoName"></span></p>
            <p><strong>Email:</strong> <span id="infoEmail"></span></p>
            <p><strong>Số Điện Thoại:</strong> <span id="infoPhone"></span></p>
            <p><strong>Giới Tính:</strong> <span id="infoGender"></span></p>
            <p><strong>Ngày Sinh:</strong> <span id="infoBirthdate"></span></p>
            <p><strong>Địa Chỉ:</strong> <span id="infoAddress"></span></p>
            <button type="button" id="backButton">Quay lại</button>
        </div> -->
        <script>
            
             // Hàm xử lý khi người dùng chọn tệp hình ảnh mới
        document.getElementById("avatar").addEventListener("change", function(event) {
            var file = event.target.files[0]; // Lấy tệp hình ảnh từ sự kiện change

            if (file) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var img = document.getElementById("avatarPreview");
                    img.src = e.target.result; // Cập nhật ảnh đại diện với ảnh mới
                }

                reader.readAsDataURL(file); // Đọc tệp hình ảnh như một đường dẫn dữ liệu
            }
        });



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
        </script>
    </div>
</body>

</html>

<?php
// Đóng kết nối cơ sở dữ liệu
mysqli_close($conn);
?>