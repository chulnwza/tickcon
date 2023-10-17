<?php
session_start();
if (isset($_SESSION['user_id'])) {
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>log-in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h3 class="mt-4">เข้าสู่ระบบ</h3>
        <hr>
        <form action="login_db.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" aria-describedby="email">
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Password</label>
                <input type="password" class="form-control" name="pwd">
            </div>
            <button type="submit" class="btn btn-primary" name="signin">Sign In</button>
        </form>
        <hr>
        <p>คลิกที่นี่เพื่อสมัครสมาชิก <a href="signup_db.php">สมัครสมาชิก</a></p>
        <?php
        if (isset($_POST['signin'])) {
            //assign variable
            $email = $_POST['email'];
            $pwd = $_POST['pwd'];
            $check = true;
            //cennect to database
            session_start();
            require_once 'config/db.php';

            $sql = <<<EOF
            SELECT * from user;
            EOF;
            $ret = $db->query($sql);
            $data_user = array();
            $count = 0;
            while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                $count++;
            }
            $ret = $db->query($sql);
            if ($count > 0) {
                while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                    if (($email == $row['email']) && ($pwd == $row['pwd'])) {
                        $_SESSION['user_id'] = $row['user_id'];
                        if ($row['urole'] == 'user') {
                            header('Location:index_user.php');
                        } elseif ($row['urole'] == 'admin') {
                            header('Location:index_admin.php');
                        }
                        break;
                    } elseif (($email == $row['email']) && ($pwd != $row['pwd'])) {
                        $check = false;
                        echo "<script>alert('The email or password is incorrect. Please try again.');</script>";
                        break;
                    }
                }
                if ($check) {
                    echo "<script>alert('You haven't registered as a member yet. Please register before using the service.');</script>";
                }

            } else {
                echo "<script>alert('You haven't registered as a member yet. Please register before using the service.');</script>";
            }
            $db->close();
        }

        ?>
    </div>

</body>

</html>