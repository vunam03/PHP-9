<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
          <!-- Tabs Titles -->
          <a href="./login.php">
            <h2 class="active"> Đăng nhập </h2>
          </a>
          <a href="../sign_up/sign_up.php">
            <h2 class="inactive underlineHover">Đăng kí </h2>
          </a>
          <!-- Icon -->
          <div class="fadeIn first">
            <!-- <img src="http://danielzawadzki.com/codepen/01/icon.svg" id="icon" alt="User Icon" /> -->
          </div>
      
          <!-- Login Form -->
          <form action="user_login.php" method="POST"> 
            <?php if (isset($_GET['error'])) { ?>
              <p class="error"><?php echo $_GET['error'];?></p>
              <?php } ?>
            <input type="text" id="email" class="fadeIn second" name="login_email" placeholder="Email">
            <input type="text" id="password" class="fadeIn third" name="login_password" placeholder="Mật khẩu">
            <input type="submit" class="fadeIn fourth" value="Đăng nhập">
          </form>
      
          <!-- Remind Passowrd -->
          <div id="formFooter">
            <a class="underlineHover" href="../Change_password/forgot_pass.php">Đổi mật khẩu</a>
            <!-- <a class="underlineHover" href="/Applications/XAMPP/xamppfiles/htdocs/src_project/Change_password/forgot_pass.php">Đổi mật khẩu</a> -->
          </div>
          <div id ="formFooter">
            <a href="#" class = "google"> <img src="../icon/icon_page1/img_signin.png" alt="" style="width: 65%"> </a>
        </div>
      
        </div>
      </div>
</body>
</html>