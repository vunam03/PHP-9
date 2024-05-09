<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="sign_up.css">
</head>
<body>
    <div class="wrapper fadeInDown">
        <div id="formContent">
          <!-- Tabs Titles -->
          <a href="../login/login.php">
          <h2 class="inactive underlineHover"> Đăng nhập </h2>
          </a>
          <h2 class="active">Đăng kí </h2>
      
          <!-- Icon -->
          <div class="fadeIn first">
            <!-- <img src="" id="icon" alt="User Icon" /> -->
          </div>
      
          <!-- Login Form -->
          <form method="post" action="register_process.php">
          <?php if (isset($_GET['error'])) { ?>
              <p class="error"><?php echo $_GET['error'];?></p>
              <?php } ?>
    <input type="text" id="login" class="fadeIn second" name="name" placeholder="Tên">
    <input type="text" id="signup_email" class="fadeIn second" name="signup_email" placeholder="Tài khoản">
    <input type="text" id="signup_password" class="fadeIn third" name="signup_password" placeholder="Mật khẩu">
    <input type="text" id="password" class="fadeIn third" name="confirm_password" placeholder="Xác nhận mật khẩu">
    <input type="submit" class="fadeIn fourth" value="Sign up">
</form>
      
          <!-- Remind Passowrd -->
          <div id="formFooter">
            <!-- <a class="underlineHover" href="#">Forgot Password?</a> -->
          </div>
      
        </div>
      </div>
</body>
</html>