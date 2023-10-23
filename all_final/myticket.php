<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Ticket</title>
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
    <main>
        <?php
        if (!isset($_SESSION['member_id'])) {
            $_SESSION['error'] = 'กรุณาล็อคอินก่อน';
            header("location: /tickcon/login.php", TRUE);
            exit;
        } elseif (isset($_SESSION['member_id'])) {
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
            echo '<div class="container" style="width : 70%">
            <div class="text-center"></div><h4>My Tickets</h4><hr></div>';
            if ($count <= 0) {
                echo "you don't have any ticket.";
            } else {
                $sql = <<<EOF
                SELECT concert_id, concert_name, show_date, show_time, td.name, concert_img_path, p.member_id
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
                while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
                    echo '<div class="card mb-3" style="width: 24rem;">
                    <div class="card-body">
                      <div class="row">
                      <div class="col-lg-4 col-sm-12">
                      <img class="card-img rounded rounded-4 border border-3 border-dark w-100 mt-1 mb-3"
                            src="'. $row['concert_img_path'] .'" alt="poster">
                      </div>
                      <div class="col-lg-8 col-sm-12">
                      <h6 class="card-title">'.$row['concert_name'].'</h6>
                      <h6 class="card-subtitle mb-2 text-body-secondary">'.$row['show_date'].' / '.$row['show_time'].'</h6>
                      <p class="card-text">'.$row['name'].'</p>
                      <a href="concert_detail.php?id='. $row['concert_id'] .'" class="card-link">see more</a>
                      <a href="#" class="card-link">QR code</a>
                      </div>
                      </div>
                    </div>
                    </div>';
                }
            }
        }
        echo '</div>';
        ?>

    </main>
    <!-- footer -->
    <hr>
    <footer class="py-3 my-4 ">
        <p class="text-center text-muted">© 2023 TICKCON</p>
    </footer>
</body>

</html>