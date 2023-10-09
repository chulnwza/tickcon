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

    if (isset($_POST['signin'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

      
        if (empty($email)) {
            $_SESSION['error'] = 'กรุณากรอกอีเมล';
            header("location: signin.php");
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
            header("location: signin.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header("location: signin.php");
        } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
            header("location: signin.php");
        } else {
            try {
                $sql = 'SELECT * FROM member WHERE email = "'.$email.'"';
                $ret = $db->query($sql);
                $count = 0;
                while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                    $count = $count + 1;
                   }

                if ($check_data->rowCount() > 0) {
                    while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
                        $email_indat = $row["email"];
                        $password_indat = $row["password"];
                        $member_id_indat = $row["member_id"];
                       }
                    if ($email == $email_indat) {
                        if (password_verify($password, $password_indat)) {
                            // if ($row['urole'] == 'admin') {
                            //     $_SESSION['admin_login'] = $row['id'];
                            //     header("location: admin.php");
                            } else {
                                $_SESSION['user_login'] = $row['id'];
                                header("location: user.php");
                            }
                        } else {
                            $_SESSION['error'] = 'รหัสผ่านผิด';
                            header("location: signin.php");
                        }
                    } else {
                        $_SESSION['error'] = 'อีเมลผิด';
                        header("location: signin.php");
                    }
                } else {
                    $_SESSION['error'] = "ไม่มีข้อมูลในระบบ";
                    header("location: signin.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


?>