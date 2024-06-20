<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['id'])) {
  header("Location: ../../Views/login.php"); // Điều hướng người dùng đến trang đăng nhập nếu chưa đăng nhập.
  exit();
}

// Kết nối đến cơ sở dữ liệu (sử dụng thông tin cấu hình của bạn)
// include "../../sever/config/config.php";
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "manage";

$conn = mysqli_connect($servername, $username, $password, $db_name);

// Lấy ID của người dùng từ tham số URL
$user_id = $_GET['id'];

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

$taskQuery = "SELECT * FROM tbl_todolist WHERE id = $user_id"; // Sử dụng tên bảng `tbl_todolist`
$taskResult = mysqli_query($conn, $taskQuery);

if (!$taskResult) {
  die("Lỗi truy vấn danh sách công việc: " . mysqli_error($conn));
}

$tasks = array(); // Tạo một mảng để lưu trữ các mục công việc
while ($taskRow = mysqli_fetch_assoc($taskResult)) {
  $tasks[] = $taskRow['title'];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link type="image/png" sizes="32x32" rel="icon" href="./images/checklist_32px.png" />
  <script defer src="./main.js"></script>
  <title>YourTodo</title>
</head>

<body>
  <header>
    <nav>
      <button type="button" class="sidebarBtn">
        <img src="./images/menu.png" alt="Sidebar" />
      </button>
      <div class="navMain">
        <img class="navIcon" src="./images/checklist.png" alt="TodoList Icon" />
        <span class="navTitle">YourTodo</span>
      </div>

      <a href="../../View_profile/ViewProfile1.php?id=<?php echo intval($user_id); ?>'" style="width: 140px;display:flex;color: inherit;text-decoration: none;">
        <img src="../../icon/icon_page1/4213460-account-avatar-head-person-profile-user_115386.png" alt="" style="width: 40%;">
        <p style="font-size: 20 px;margin-top: 20px;">Trang cá nhân</p>
      </a>

    </nav>
  </header>
  <main class="sidebarClosed" data-sidebar="closed">
    <aside class="sidebar closed">
      <h2>Dự án</h2>
      <button type="button" id="newProjectBtn">Dự án mới</button>

      <div class="projects">
        <!-- PROJECT ITEM TEMPLATE USED FOR CREATING NEW PROJECT ITEMS VIA JAVASCRIPT -->
        <template id="projectTemplate">
          <button type="button" class="projectItem">
            <span class="projectTitle" role="textbox" contenteditable>Không có tiêu đề</span>
            <img class="deleteProjectItem" role="button" src="./images/trash.png" alt="Trash" />
          </button>
        </template>
      </div>
    </aside>

    <section aria-labelledby="currentProjectTitle" class="container">
      <h1 id="currentProjectTitle">
        <?php foreach ($tasks as $task) : ?>
          <div class="project-list">
            <div class="project-content">
              <button type="button" class="text-button" onclick="handleButtonClick('<?php echo $task; ?>');">
                <?php echo $task; ?>
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      </h1>
      <button id="newItemBtn">Tiêu đề mới</button>
      <template id="todoItemTemplate">
        <li class="todoItem">
          <span class="todoItem_title"></span>
          <button class="showTodoDetailsBtn">Chi tiết</button>
        </li>
      </template>
      <ul class="todos"></ul>
    </section>
  </main>

  <!-- POPUP FOR CREATING TODO ITEMS -->
  <dialog class="createTodoItemDialog">
    <form>
      <span class="dialogTitle">Tiêu đề mới</span>
      <div class="formInputFields">
        <input type="text" class="todoItemTitle" placeholder="Review Waves in Physics" required minlength="2" />
        <input type="date" required class="todoItemDueDate" />
        <select class="selectItemPriority" required>
          <option value="priority_low" selected>Ưu tiên thấp</option>
          <option value="priority_med">Ưu tiên trung bình</option>
          <option value="priority_high">Ưu tiên cao</option>
        </select>
        <textarea placeholder="Review waves in physics due to upcoming test" required class="todoItemDescription" minlength="2"></textarea>
      </div>
      <button class="formBtn addTodoItemBtn" type="submit">Thêm</button>
    </form>
  </dialog>

  <!-- TODO ITEM DETAILS POPUP -->
  <dialog class="todoItemDetailsDialog">
    <form>
      <span class="dialogTitle">Tiêu đề mới</span>
      <div class="formInputFields">
        <input type="text" class="todoItemTitle" minlength="2" required />
        <input type="date" class="todoItemDueDate" required />
        <select class="selectItemPriority" required>
          <option value="priority_low" selected>Ưu tiên thấp</option>
          <option value="priority_med">Ưu tiên trung bình</option>
          <option value="priority_high">Ưu tiên cao</option>
        </select>
        <textarea class="todoItemDescription" minlength="2" required></textarea>
      </div>
      <button class="formBtn saveBtn" data-type="save">Lưu</button>
      <button class="formBtn statusBtn" data-type="status">
        Xong / Chưa xong
      </button>
      <button class="formBtn deleteBtn" data-type="delete">Xóa</button>
    </form>
  </dialog>
</body>

</html>