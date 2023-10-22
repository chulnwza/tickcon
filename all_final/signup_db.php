<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h3 class="mt-4">สมัครสมาชิก</h3>
        <hr>
        <form action="signup_db.php" method="post">
            <div class="mb-3">
                <label for="fname" class="form-label">First name</label>
                <input type="text" class="form-control" name="fname" aria-describedby="fname">
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Last name</label>
                <input type="text" class="form-control" name="lname" aria-describedby="lname">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" aria-describedby="email">
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Password</label>
                <input type="password" class="form-control" name="pwd">
            </div>
            <div class="mb-3">
                <label for="confirm pwd" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="c_pwd">
            </div>
            <button type="submit" class="btn btn-primary" name="signup">Sign Up</button>
        </form>
        <hr>
        <p>คลิกที่นี่เพื่อเข้าสู่ระบบ <a href="login_db.php">เข้าสู่ระบบ</a></p>

    </div>

    <?php
    if (isset($_POST['signup'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];
        $c_pwd = $_POST['c_pwd'];
        $urole = 'user';
        $error_msg = "";
        if (empty($fname)) {
            echo "<script>alert('กรุณากรอกชื่อ');</script>";
        } else if (empty($lname)) {
            echo "<script>alert('กรุณากรอกนามสกุล');</script>";
        } else if (empty($email)) {
            echo "<script>alert('กรุณากรอกอีเมล');</script>";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('รูปแบบอีเมลไม่ถูกต้อง');</script>";
        } else if (empty($pwd)) {
            echo "<script>alert('กรุณากรอกรหัสผ่าน');</script>";
        } else if (strlen($pwd) > 20 || strlen($pwd) < 5) {
            echo "<script>alert('รหัสผ่านจะต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร');</script>";
        } else if (empty($c_pwd)) {
            echo "<script>alert('กรุณายืนยันรหัสผ่าน');</script>";
        } else if ($pwd != $c_pwd) {
            echo "<script>alert('รหัสผ่านไม่ตรงกัน');</script>";
        } else {
            //cennect to database
            session_start();
            require_once 'config/db.php';
            //get data...
    
            $sql = <<<EOF
            SELECT email from member;
            EOF;
            $ret = $db->query($sql);
            $data_email = array();

            while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                array_push($data_email, $row['email']);
            }

            if (in_array($email, $data_email)) {
                echo "<script>alert('อีเมลนี้ถูกใช้ไปแล้ว กรุณาลองใหม่อีกครั้ง');</script>";
            } else {

                $sql = <<<EOF
                INSERT INTO member(firstname,lastname,email,password,type)
                VALUES ('$fname','$lname','$email','$pwd','$urole');
                EOF;
                $ret = $db->query($sql);
                echo "<script>alert('Register Successfully Please Log-in.');</script>";
            }
            $db->close();
        }
    }

    ?>

</body>

</html>