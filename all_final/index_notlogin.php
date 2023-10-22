<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
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
            font-weight: 700;
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

        .btn-outline-info {
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
                        <a class="nav-link " href="index_notlogin.php" style="color:white;">Concerts</a>
                    </li>
                </ul>
                <form class="d-flex mb-2 mb-lg-0" action="login_db.php">
                    <button class="btn btn-outline-info" type="submit">Log In</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- code -->
    <div class="text-center">
        <h1>คอนเสิร์ตที่เปิดขาย</h1>
    </div>
    <div class="container">
        <br>
        <div class="row">
            <?php
            require_once 'config/db.php';
            $sql1 = 'SELECT * FROM concert
            WHERE status="approved" AND open_booking_date < "' . date("Y-m-d") . '"' . ' AND show_date > "' . date("Y-m-d") . '"';
            $result = $db->query($sql1);
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {


                ?>
                <div class="col-sm-3">
                    <div class="text-center">
                        <img src="<?= $row['concert_img_path'] ?>" width="200px" height="250" class="mt-5 p-1 my-1 border">
                        <br>
                        <b>
                            <?= $row['concert_name'] ?>
                        </b><br>
                        <b>Showtime:</b>
                        <?= $row['show_time'] ?>,
                        <?= $row['show_date'] ?><br>
                        <a class="btn btn-outline-primary"
                            href="concert_detail_notlogin.php?id=<?= $row['concert_id'] ?>">รายละเอียด</a>
                        <a class="btn btn-outline-dark">ซื้อบัตร</a>
                    </div>
                    <br>
                </div>
                <?php
            }
            $db->close();
            ?>
        </div>
    </div>

    <!-- footer -->
    <footer class="py-3 my-4 ">
        <p class="text-center text-muted">© 2023 TICKCON</p>
    </footer>
</body>

</html>