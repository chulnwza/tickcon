<?php
session_start();
ob_start();
if (isset($_SESSION['member_id'])) {
    session_destroy();
}
?>
<?php
date_default_timezone_set("Asia/Bangkok");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TICKCON</title>
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@500;700&family=IBM+Plex+Sans+Thai:wght@500&family=Mohave:wght@700&display=swap" rel="stylesheet">

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
            font-family: 'IBM Plex Sans Thai', sans-serif;
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

        #main-concert :hover {
            background-color: #91EAFF;
            border-radius: 10px;
        }

        body {
            background-color: #04364A;
        }

        hr {
            color: white;
        }

        .container {
            background-color: #56B2CD;
            width:55%;
        }

        @media only screen and (max-width: 767px) {
            .container {
                background-color: #56B2CD;
                width:100%;
            }
        }

        @media only screen and (max-width: 99px) {
            .container {
                background-color: #56B2CD;
                width:80%;
            }
        }

        #main-picture {
            width: 80%;
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
                <form class="d-flex mb-2 mb-lg-0 me-1" action="signup_db.php">
                    <button class="btn btn-outline-light" type="submit">Sign Up</button>
                </form>
                <form class="d-flex mb-2 mb-lg-0" action="login_db.php">
                    <button class="btn btn-outline-light" type="submit">Log In</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- code -->
    <div class="container py-2 rounded">
    <h3 class="mt-4 text-center text-light">Concerts</h3>
        <hr>
        <br>
        <div class="row">
            <?php
            require_once 'config/db.php';
            $sql1 = 'SELECT * FROM concert
            WHERE status="approved" AND open_booking_date <= "' . date("Y-m-d") . '"' . ' AND show_date > "' . date("Y-m-d") . '"';
            $result = $db->query($sql1);
            $count = 0;
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $count++;
            ?>
                <div class="col-6 col-md-4 col-xl-3 mb-3" id="main-concert">
                    <div class="card h-100 shadow">
                    <div class="card-body px-2 pb-0 pt-1">
                    <div class="text-center">
                        <a class="text-decoration-none text-dark" id="main-text" href="concert_detail_notlogin.php?id=<?= $row['concert_id'] ?>">
                        <img src="<?= $row['concert_img_path'] ?>" id="main-picture"
                            class="mt-3 p-1 my-1 border rounded bg-dark"> <br>
                        <b>
                            
                            <?= $row['concert_name'] ?>
                        </b><br>
                        <?php echo '<small>' . date('l', strtotime($row['show_date'])) . '<br>' . date('d F Y', strtotime($row['show_date'])) .'<br><i class="bi bi-clock"></i> '. $row['show_time'] . '</small>';?><br>
                        </a>
                    </div>
                    </div>
                    <br>
                </div>
                </div>
                <?php
            }
            if($count == 0){
                echo '<div class="text-center mb-5"><h6>Sorry, we don\'t have any concert </h6></div>';
            }
            $db->close();
            ?>
        </div>
    </div>

    <!-- footer -->
    
    <footer class="py-3 my-4 ">
        <hr  style="color:black;">
        <p class="text-center text-light">© 2023 TICKCON</p>
    </footer>
</body>

</html>