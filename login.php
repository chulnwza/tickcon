<?php session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .container-box {
            text-align: center;
            border: 2px solid grey;
            border-radius: 25px;
            padding: 3%;
            width: 40vh;
        }
        .btn-primary{
            background-color: grey;
        }
    </style>
</head>

<body class="p-5">
    <div class="position-absolute top-50 start-50 translate-middle container-box">
        <form action="signin_db.php" method="post">
        <?php if (isset($_SESSION['error'])) {?>
                <div class="alert alert-danger" role="alert">
                    <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
            <?php }?>
            <?php if (isset($_SESSION['success'])) {?>
                <div class="alert alert-success" role="alert">
                    <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
            <?php }?>
            <h1>เข้าสู่ระบบ</h1>
            <div class="form-outline mb-4">
                <i class='trailing'>@</i>
                <input type="email" id="form" class="form-control" />
                <label class="form-label">ที่อยู่อีเมล</label>
            </div>
            <div class="form-outline mb-4">
                <i class='bx bxs-lock-alt trailing'></i>
                <input type="password" id="form" class="form-control" />
                <label class="form-label">รหัสผ่าน</label>
            </div>

            <button type="submit" class="btn btn-primary btn-block mb-4">เข้าสู่ระบบ</button>
            <div class="text-center">
                <p>ยังไม่มีบัญชีผู้ใช้? <a href="register.php"> ลงทะเบียน</a></p>
            </div>
        </form>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
</body>

</html>