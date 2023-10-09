<?php
    session_start();
   class MyDB extends SQLite3 {
      function __construct() {
         $this->open('mainDatabase.db');
      }
   }

   // 2. Open Database 
   $db = new MyDB();
   if(!$db) {
      echo $db->lastErrorMsg();
   } else {
      // echo "Opened database successfully<br>";
   }

    if (isset($_POST['signup'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $user_type = 'member';
        if (empty($username)|| empty($password) || empty($c_password) || empty($email)) {
            $_SESSION['error'] = 'โปรดกรอกข้อมูลให้ครบ';
            header("location: register.php");
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'ข้อมูลไม่ถูกต้องตามมาตรฐานที่กำหนด (email)';
            header("location: register.php");
        } else if (strlen($username) < 5) {
            $_SESSION['error'] = 'ข้อมูลไม่ถูกต้องตามมาตรฐานที่กำหนด (username)';
            header("location: register.php");
        } else if (strlen($_POST['password']) < 5){
            $_SESSION['error'] = 'ข้อมูลไม่ถูกต้องตามมาตรฐานที่กำหนด (password)';
            header("location: register.php");
        } else if ($password != $c_password){
            $_SESSION['error'] = 'ข้อมูลไม่ถูกต้องตามมาตรฐานที่กำหนด (password and confirm password)';
            header("location: register.php");
        } else {
            try{
                $sql = 'SELECT email FROM member WHERE email = "'.$email.'"';
                $ret = $db->query($sql);
                $count = 0;
                while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                    $count = $count + 1;
                   }
                if ($count != 0) {
                    $_SESSION['warning'] = "email ถูกใช้สมัครสมาชิกแล้ว <a href='signin.php'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: register.php");
                } else if (!isset($_SESSION['error'])) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $db->prepare("INSERT INTO member(username, email, password, type) 
                                            VALUES(:username, :email, :password, :type)");
                    $stmt->bindParam(":username", $username);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":type", $user_type);
                    $stmt->execute();
                    $db->close();
                    $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! <a href='signin.php' class='alert-link'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: register.php");
                } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location: register.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

?>