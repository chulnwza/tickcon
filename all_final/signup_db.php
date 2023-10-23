<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
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
    </style>
</head>

<body>
    <!-- navbar -->

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
                    <button class="btn btn-outline-light" type="submit"
                        style="background-color: #FFFFFF; color:#000000; border-color: white;">Sign Up</button>
                </form>
                <form class="d-flex mb-2 mb-lg-0" action="login_db.php">
                    <button class="btn btn-outline-light" type="submit">Log In</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- code -->
    <div class="container" style="width : 60%">
        <h3 class="mt-4">สมัครสมาชิก</h3>
        <hr>
        <?php
        if (isset($_POST['signup'])) {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $pwd = $_POST['pwd'];
            $c_pwd = $_POST['c_pwd'];
            $urole = 'user';
            $error_msg = "";
            // เพิ่ม Bootstrap alert
            if (empty($fname)) {
                echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">กรุณากรอกชื่อ<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
            } else if (empty($lname)) {
                echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">กรุณากรอกนามสกุล<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
            } else if (empty($email)) {
                echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">กรุณากรอกอีเมล<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo '<div class="alert alert-danger text-center" role="alert">รูปแบบอีเมลไม่ถูกต้อง<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
            } else if (empty($pwd)) {
                echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">กรุณากรอกรหัสผ่าน<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
            } else if (strlen($pwd) > 20 || strlen($pwd) < 5) {
                echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">รหัสผ่านจะต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
            } else if (empty($c_pwd)) {
                echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">กรุณายืนยันรหัสผ่าน<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
            } else if ($pwd != $c_pwd) {
                echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">รหัสผ่านไม่ตรงกัน<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
            } else {
                // Connect to the database
                session_start();
                require_once 'config/db.php';

                // Get data...
                $sql = <<<EOF
            SELECT email from member;
            EOF;
                $ret = $db->query($sql);
                $data_email = array();

                while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                    array_push($data_email, $row['email']);
                }

                if (in_array($email, $data_email)) {
                    echo '<div class="alert alert-danger text-center" role="alert">อีเมลนี้ถูกใช้ไปแล้ว กรุณาลองใหม่อีกครั้ง</div>';
                } else {
                    $sql = <<<EOF
                INSERT INTO member(firstname,lastname,email,password,type)
                VALUES ('$fname','$lname','$email','$pwd','$urole');
                EOF;
                    $ret = $db->query($sql);
                    echo '<div class="alert alert-success text-center" role="alert">สมัครสมาชิกสำเร็จ คลิกเพื่อเข้าสู่ระบบ <a href="login_db.php"> เข้าสู่ระบบ</a></div>';
                }
                $db->close();
            }
        }
        ?>
        <form action="signup_db.php" method="post">
            <div class="mb-3">
                <label for="fname" class="form-label">First name</label>
                <input type="text" class="form-control" name="fname" aria-describedby="fname" placeholder="ชื่อจริง">
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Last name</label>
                <input type="text" class="form-control" name="lname" aria-describedby="lname" placeholder="นามสกุล">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" aria-describedby="email" placeholder="อีเมล">
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Password</label>
                <input type="password" class="form-control" name="pwd" placeholder="ความยาวมากกว่า 5 ตัวอักษร">
            </div>
            <div class="mb-3">
                <label for="confirm pwd" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="c_pwd" placeholder="ยืนยัน password">
            </div>
            <button type="submit" class="btn btn-info" name="signup">Sign Up</button>

        </form>


    </div>


    <!-- footer -->
    <hr>
    <footer class="py-3 my-4 ">
        <p class="text-center text-muted">© 2023 TICKCON</p>
    </footer>
</body>

</html>