<?php session_start(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>main</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<a href="login_db.php"><button class="btn btn-secondary">log out</button></a>
    <h1>This is main page for user.</h1>
    <p>คลิกที่นี่เพื่อสร้างคอนเสิร์ต <a href="createcon_db.php">สร้างคอนเสิร์ต</a></p>
    <p>คลิกที่นี่เพื่อดูคอนเสิร์ตที่สร้าง <a href="my_concert.php">คอนเสิร์ตที่สร้าง</a></p>
</body>
</html>