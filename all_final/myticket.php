<?php
session_start();
if (!isset($_SESSION['member_id']) || (isset($_SESSION['type']) && $_SESSION['type'] == 'admin')) {
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
    <link
        href="https://fonts.googleapis.com/css2?family=Dosis:wght@500;700&family=IBM+Plex+Sans+Thai:wght@500&family=Mohave:wght@700&display=swap"
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
<<<<<<< HEAD
        p {
  margin: 25px;
}
=======

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
            width: 55%;
        }

        @media only screen and (max-width: 767px) {
            .container {
                background-color: #56B2CD;
                width: 100%;
            }
        }

        @media only screen and (max-width: 99px) {
            .container {
                background-color: #56B2CD;
                width: 80%;
            }
        }

        #main-picture {
            width: 80%;
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
                        <a class="nav-link" href="myticket.php" style="color :white">My Tickets</a>
                    </li>
                </ul>

                <div class=" mb-2 ms-0">
                    <p style="color:black"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
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
                    <button class="btn btn-light position-relative" type="submit" >My Concert';
                    if (in_array("approved", $status) || in_array("rejected", $status)) {
                        echo '<span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger rounded-circle">
                        </span>';
                    }

                    echo '</button>
                    </form>';
                }
                ?>
                <form class="d-flex mb-2 mb-lg-0 me-1" action="createcon_db.php">
                    <button class="btn btn-light" type="submit" style="background-color: white;">Create Concert</button>
                </form>
                <form class="d-flex mb-2 mb-lg-0" action="login_db.php">
                    <button class="btn btn-outline-danger" type="submit">Log Out</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- code -->
    <div class="container py-3 rounded">
        <h3 class="mt-4 text-center text-light">My Tickets</h3>
        <hr>
        <br>
        <div class="row">
        <?php
        $member_id = $_SESSION['member_id'];
        $sql = <<<EOF
            SELECT concert_name, show_date, show_time, td.name, c.address, requirement, concert_img_path, t.ticket_id,p.member_id
            FROM ticket t
            JOIN ticket_detail td
            USING (detail_id) 
            JOIN payment p
            USING (payment_id)
            JOIN concert c
            USING (concert_id)
            WHERE p.member_id = $member_id;"
            EOF;
        $ret = $db->query($sql);
        $count = 0;
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $count++;
        }
        if ($count <= 0) {
            echo '<div class="text-center mb-5"><h6>you don\'t have any ticket.</h6></div>';
        } else {
            $sql = <<<EOF
                SELECT *
                FROM ticket t
                JOIN ticket_detail td
                USING (detail_id) 
                JOIN payment p
                USING (payment_id)
                JOIN concert c
                USING (concert_id)
                WHERE p.member_id = $member_id;"
                EOF;
            $ret = $db->query($sql);
            $count = 0;
            while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                echo '<div class="col-12 col-xl-6 mb-3">
                    <div class="card mb-3 m-3">
                    <div class="card-body">
                      <div class="row">
                      <div class="col-6 text-center">
                      <img class=" border-end  border-4 mt-1 p-3 rounded-0 w-100"
                            src="' . $row['concert_img_path'] . '"><br>
                    </div>
                      <div class="col-6">
                      <div class= "text-start">
                      <b><a class="card-title text-decoration-none" href="concert_detail.php?id=' . $row['concert_id'] . '">' . $row['concert_name'] . '</a></b><br>
                      <h6 class="card-subtitle mb-2 text-body-secondary">' . $row['show_date'] . ' / ' . $row['show_time'] . '</h6>
                      <a class="card-text text-start text-decoration-none d-flex" style="color: #7752FE;"><b><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-ticket-detailed-fill" viewBox="0 0 16 16" >
                      <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6V4.5Zm4 1a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5Zm0 5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5ZM4 8a1 1 0 0 0 1 1h6a1 1 0 1 0 0-2H5a1 1 0 0 0-1 1Z"/>
                    </svg>  ' . $row['name'].'</b></a>';
                    if($row['show_date'] < date("Y-m-d")){
                        echo'<span class="badge bg-secondary rounded-pill float-end">expired</span>';
                    }elseif ($row['show_date'] > date("Y-m-d")){
                        echo'<span class="badge bg-success rounded-pill float-end ">available</span>';
                    }elseif ($row['show_date'] == date("Y-m-d")){
                        echo'<span class="badge bg-warning rounded-pill  float-end">using</span>';
                    }
                    echo '<br><hr style="color:black">
                      <div class="collapse" id="navbarToggleExternalContent'."$count".'" data-bs-theme="dark">
                        <div class="text-start">
                            <small><p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                          </svg>  '.$row['description'].'</p>
                            <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                          </svg> '.$row['address'].'</p>
                            </small>
                        </div>   
                    </div>
                    <div class="collapse" id="navbarToggleExternalContentQR'."$count".'" data-bs-theme="dark">
                        <div class="">
                            <img class="card-img border border-2 border-dark mt-1 mb-3" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' .$row['concert_id'].'-'.$row['ticket_id']. '-'.$row['payment_id'] . '">
                        </div>
                    </div>
                    <nav class="navbar">
                        <div class="container-fluid row text-center">
                        <div class="col-6 "><a class=" text-decoration-none mb-0"  data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent'."$count".'" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation" style="color: #000000;">More</a></div>
                        <div class="col-6 "><a class=" text-decoration-none mb-0"  data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContentQR'."$count".'" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation" style="color: #000000;">QR</a></div>
                        </div>
                    </nav>
                    </div></div></div></div></div></div>';
                    $count++;
            }
            echo '</div>';
        }
            ?>

    </div>
    <!-- footer -->

    <footer class="py-3 my-4">
        <hr style="color:black">
        <p class="text-center text-light">© 2023 TICKCON</p>
    </footer>
</body>

</html>