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
        .btn-outline-danger{
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

        #a :hover {
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
            display: flex;
            justify-content: center;
            margin: 0 auto;
        }
    </style>

</head>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-md sticky-top shadow p-2 mb-5 " style="background-color : #0097B2">
        <div class="container-fluid">
            <a class="navbar-brand" href="index_admin.php">
                <img src="upload/logo/TICKCON.png" alt="Logo" width="150px" 
                    class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 p-1 ms-0 ps-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index_admin.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="con_waiting_list.php" style="color:white;">Pending List</a>
                    </li>
                </ul>
                <form class="d-flex mb-2 mb-lg-0" action="index_notlogin.php">
                    <button class="btn btn-outline-danger" type="submit">Log Out</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- code -->
    <a href="index_admin.php"><button class="btn btn-secondary">back</button></a>
    <div class='container py-3 rounded'>
        <div class='row'>
            <h4 class='text-center text-light'>Approve Queue</h4><hr>
    <?php
    require_once 'config/db.php';
    $sql = <<<EOF
    SELECT * from concert
    WHERE status = 'checking';
    EOF;
    $ret = $db->query($sql);
    $count = 0;
    while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
        $count++;
    }
    if ($count > 0) {
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            echo '<div class = "col-6 col-md-4 col-lg-3 mb-3" id = "main-concert">
            <div class="card h-100 px-0 py-1">
            <img src="' . $row['concert_img_path'] . '" 
            class="card-img mt-3 p-1 my-1 border rounded bg-dark"
            id="main-picture">
                <div class="card-body pb-2 pt-1 text-center">
                    <h6 class="card-title fw-bold mb-0">' . $row['concert_name'] . '</h5>
                    <small>' . date('l', strtotime($row['show_date'])) . ', ' . date('d F Y', strtotime($row['show_date'])) .'<br><i class="bi bi-clock"></i> '. $row['show_time'] . '</small><br>
                    <a href="each_con_check.php?concert_id=' . $row['concert_id'] . '" class="btn btn-primary">see more</a>
                </div>
            </div>
            </div>';
        }
        echo "</div></div>";
    } else {
        echo "</div></div>";
        echo "<p>don't have concert to approve in queue.</p>";
    }
    ?>
    <!-- footer -->
    <hr>
    <footer class="py-3 my-4 ">
        <p class="text-center text-light">© 2023 TICKCON</p>
    </footer>

</body>

</html>