
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>

<body class="p-5">
    <div class="container my-5">
        <form action="signin_db.php" method="post">
            <h1>เข้าสู่ระบบ</h1>
            <div class="form-outline mb-4">
                <i class='trailing'></i>
                <input type="email" id="form" class="form-control" name="email"/>
                <label class="form-label">อีเมล</label>
            </div>
            <div class="form-outline mb-4">
                <i class='bx bxs-lock-alt trailing'></i>
                <input type="password" id="form" class="form-control" name="password"/>
                <label class="form-label">รหัสผ่าน</label>
            </div>

            <button type="submit" class="btn btn-primary btn-block mb-4" name="signin">เข้าสู่ระบบ</button>
            <div class="text-center">
                <p>ยังไม่มีบัญชีใช่มั้ย? <a href="register.php"> สมัครสมาชิก</a></p>
            </div>
        </form>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>