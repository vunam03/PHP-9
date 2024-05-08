<!DOCTYPE html>
/* Ngo Thi Thom */
<html>
<head>
    <title>Hiển thị dữ liệu sinh viên đăng ký môn học</title>
    <style>
        /* CSS để căn giữa bảng */
        .table-container {
            margin: 0 auto; /* Căn giữa theo chiều ngang */
            width: 80%; /* Độ rộng của bảng */
        }
        table {
            border: solid 1px black;
            width: 100%; /* Bảng chiếm toàn bộ chiều rộng của container */
        }
        th, td {
            border: solid 1px black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Dữ liệu sinh viên đăng ký môn học</h1>
    <!-- <div class="table-container">
    <table>
        <tr>
            <th>MSSV</th>
            <th>Họ Tên</th>
            <th>Kỳ</th>
            <th>Môn Học</th>
        </tr> -->
    <?php
    // Kết nối đến CSDL
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "PKA_S";

    $conn = new mysqli($servername, $username, $password, $database);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối đến CSDL thất bại: " . $conn->connect_error);
    }

    // Truy vấn dữ liệu sinh viên đăng ký môn học
    $query = "SELECT SinhVien.MSSV, SinhVien.HoTen, DangKy.Ky, MonHoc.TenMH
              FROM SinhVien
              INNER JOIN DangKy ON SinhVien.MSSV = DangKy.MSSV
              INNER JOIN MonHoc ON DangKy.MaMH = MonHoc.MaMH";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Hiển thị dữ liệu trong bảng
        echo "<table>";
        echo "<tr><th>MSSV</th>
        <th>Họ tên</th>
        <th>Kì</th>
        <th>Đăng ký</th>
         </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["MSSV"] . "</td>";
            echo "<td>" . $row["HoTen"] . "</td>";
            echo "<td>" . $row["Ky"] . "</td>";
            echo "<td>" . $row["TenMH"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Không có dữ liệu sinh viên đăng ký môn học.";
    }

    // Đóng kết nối CSDL
    $conn->close();
    ?>
    </table>
</body>
</html>