<?php session_start(); 
if(!isset($_SESSION['member_id']) || (isset($_SESSION['type']) && $_SESSION['type'] == 'admin')){
    header('location:index_notlogin.php');
}
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

        .btn-outline-danger {
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

        body {
            background-color: #04364A;
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
        hr {
            color: white;
        }
        p {
  margin: 25px;
}
    </style>

</head>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-md sticky-top shadow p-2 mb-5 " style="background-color : #0097B2">
        <div class="container-fluid">
            <a class="navbar-brand" href="index_user.php">
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
                        <a class="nav-link" href="index_user.php">Home</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link " href="index_user.php">Concerts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="myticket.php">My Tickets</a>
                    </li>
                </ul>

                <div class="mb-lg-0 me-3 mt-1">
                    <p style="color:black"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle"
                        viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd"
                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                    </svg>
                        <?= $_SESSION['firstname'] ?>
                    </p>
                </div>
                <?php
                require_once 'config/db.php';
                $member_id = $_SESSION['member_id'];
                $sql = <<<EOF
                SELECT * from concert
                WHERE member_id = $member_id;
                EOF;
                $ret = $db->query($sql);
                $count = 0;
                $status = array();
                while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                    array_push($status, $row['status']);
                    $count++;
                }
                if ($count > 0) {
                    echo '<form class="d-flex mb-2 mb-lg-0 me-1" action="my_concert.php">
                    <button class="btn btn-light position-relative" type="submit" style = "background-color: white;">My Concert';
                    if(in_array("approved", $status) || in_array("rejected", $status)){
                        echo '<span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger rounded-circle">
                        </span>';
                    }
                    
                    echo '</button>
                    </form>';
                }
                ?>
                <form class="d-flex mb-2 mb-lg-0 me-1" action="createcon_db.php">
                    <button class="btn btn-light" type="submit">Create Concert</button>
                </form>
                <form class="d-flex mb-2 mb-lg-0" action="index_notlogin.php">
                    <button class="btn btn-outline-danger" type="submit">Log Out</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- code -->
    <div class="container py-2 rounded">
        <h3 class="mt-4 text-center text-light">My Concert</h3>
        <hr>
        <br>
        <div class="row">
    <?php
    //connect to database
    require_once 'config/db.php';

    $member_id = $_SESSION['member_id'];
    $sql = <<<EOF
    SELECT * from concert
    WHERE member_id = $member_id;
    EOF;
    $ret = $db->query($sql);
    $count = 0;
    while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
        $count++;
    }
    if ($count > 0) {
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            echo '<div class = "col-6 col-md-4 col-lg-3 mb-3" id = "main-concert">
            <div class="card h-100 px-0 ">
            <img src="' . $row['concert_img_path'] . '" 
            class="card-img mt-3 p-1 my-1 border rounded bg-dark"
            id="main-picture">
                <div class="card-body pb-2 pt-1 text-center">
                    <h6 class="card-title fw-bold mb-0">' . $row['concert_name'] . '</h5>
                    <small>' . date('l', strtotime($row['show_date'])) . ', ' . date('d F Y', strtotime($row['show_date'])) .'<br><i class="bi bi-clock"></i> '. $row['show_time'] . '</small><br>';
                    if($row['status'] == 'checking'){
                        echo'<span class="badge bg-secondary rounded-pill mb-1">' . $row['status'] . '</span>';
                    }elseif ($row['status'] == 'approved'){
                        echo'<span class="badge bg-success rounded-pill mb-1">' . $row['status'] . '</span>';
                    }elseif ($row['status'] == 'rejected'){
                        echo'<span class="badge bg-danger rounded-pill mb-1">' . $row['status'] . '</span>';
                    }
                echo '</div>
                <a href="each_my_concert.php?concert_id=' . $row['concert_id'] . '" class="btn btn-outline-info p-2" style="border-radius:0px; border-color:white;">see more</a>
            </div>
            </div>';
        }
        echo "</div></div>";
    } else {
        
        echo '<div class="text-center mb-5"><h6>Don\'t have concert in pending list</h6></div>';
        echo "</div></div>";
    }
    ?>
    <!-- footer -->
    
    <footer class="py-3 my-4 ">
        <hr style="color:black;">
        <p class="text-center text-light">© 2023 TICKCON</p>
    </footer>
</body>

</html>
