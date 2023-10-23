<?php
session_start();
ob_start();
if (isset($_SESSION['member_id'])) {
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>log-in</title>
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@500;700&family=Mohave:wght@700&display=swap"
        rel="stylesheet">

    <!-- bootstrap link and script -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <!-- add style -->
    <style>
        * {
            font-family: 'Dosis', sans-serif;
        }

        .navbar-brand {
            font-family: 'Mohave', sans-serif;
        }

        .container-fluid {
            color: white;
        }

        .nav-link:hover {
            color: white;
            font-weight: bolder;
        }

        .btn-light {
            background-color: #C2D9FF;
            border-color: #C2D9FF;
        }

        .btn-outline-light {
            color: white;
            border-color: white;
        }

        .card-text {
            max-width: 50ch;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .card {
            margin: auto;
        }

        .linkk {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <!-- Your navbar code here -->
    <nav class="navbar navbar-expand-md sticky-top shadow p-2 mb-5 " style="background-color : #0097B2">
        <div class="container-fluid">
            <a class="navbar-brand" href="index_notlogin.php">
                <img src="upload/logo/TICKCON.png" alt="Logo" width="150px" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 p-1 ms-0 ps-0">
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="index_notlogin.php">Home</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link " href="index_notlogin.php">Concerts</a>
                    </li>
                </ul>
                <form class="d-flex mb-2 mb-lg-0 me-1" action="signup_db.php">
                    <button class="btn btn-outline-light" type="submit">Sign Up</button>
                </form>
                <form class="d-flex mb-2 mb-lg-0" action="login_db.php">
                    <button class="btn btn-outline-light" type="submit"
                        style="background-color: #FFFFFF; color:#000000; border-color: white;">Log In</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- code -->
    <div class="container" style="width : 60%">
        <h3 class="mt-4">เข้าสู่ระบบ</h3>
        <hr>
        <?php
        if (isset($_POST['signin'])) {
            //assign variable
            $email = $_POST['email'];
            $pwd = $_POST['pwd'];
            $check = true;
            if (empty($email)) {
                echo '<div class="alert alert-warning text-center alert-dismissible fade show" role="alert">
                            กรุณากรอกอีเมลหรือสมัครสมาชิก คลิกที่นี่เพื่อสมัครสมาชิก <a class="linkk" href="signup_db.php">สมัครสมาชิก</a>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
            } elseif (empty($pwd)) {
                echo '<div class="alert alert-warning text-center alert-dismissible fade show" role="alert">
                            กรุณากรอกรหัสผ่านหรือสมัครสมาชิก คลิกที่นี่เพื่อสมัครสมาชิก <a class="linkk" href="signup_db.php">สมัครสมาชิก</a>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';

            } else {
                //cennect to database
                require_once 'config/db.php';

                $sql = <<<EOF
                SELECT * from member;
                EOF;
                $ret = $db->query($sql);
                $data_member = array();
                $count = 0;
                $ret = $db->query($sql);
                while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                    if (($email == $row['email']) && ($pwd == $row['password'])) {
                        $_SESSION['member_id'] = $row['member_id'];
                        if ($row['type'] == 'user') {
                            header('Location:index_user.php');
                        } elseif ($row['type'] == 'admin') {
                            header('Location:index_admin.php');
                        }
                        break;
                    } elseif (($email == $row['email']) && ($pwd != $row['password'])) {
                        $check = false;
                        echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                            Email หรือ Password ไม่ถูกต้อง โปรดลองใหม่อีกครั้ง
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
                        break;
                    }
                }
                if ($check) {
                    echo '<div class="alert alert-warning text-center alert-dismissible fade show" role="alert">
                        บัญชีนี้ยังไม่มีชื่อในระบบ คลิกที่นี่เพื่อสมัครสมาชิก <a class="linkk" href="signup_db.php">สมัครสมาชิก</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
                }
                $db->close();
            }

        }
        ?>
        <form action="login_db.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">อีเมล</label>
                <input type="email" class="form-control" name="email" aria-describedby="email" placeholder="Email">
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">รหัสผ่าน</label>
                <input type="password" class="form-control" name="pwd" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-info" name="signin">Log In</button>
        </form>
    </div>
    <!-- footer -->
    <hr>
    <footer class="py-3 my-4 ">
        <p class="text-center text-muted">© 2023 TICKCON</p>
    </footer>
</body>

</html>