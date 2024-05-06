<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
    tendangnhap <input type="text" name="user" size="15">
   <br> matkhau <input type="password" name="pass" size="15">
   <br> <input type="submit" name="submit" value="login" >
   </form>
   
    <?php
        $tendangnhap= $_POST['user'];
        $matkhau= $_POST['pass'];

        if($tendangnhap == "admin" && $matkhau="123456"){
            echo "<font color=red> Welcome to, ",$tendangnhap," <font>";
        }
        else{
            echo"<font coler=red>tendangnhap hoac matkhau khong chinh xac, vui long dang nhap lai<font>";
        }
    ?>


</body>
</html>
        
