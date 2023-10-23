<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create concert</title>
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

        .nav-link-1:hover {
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

        .nav-link {
            text-decoration: none;
            color: #000000;
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
                        <a class="nav-link-1 nav-link " href="index_user.php">Concerts</a>
                    </li>
                    <li class="nav-item">
                        <a class=" nav-link-1 nav-link" href="myticket.php">My Tickets</a>
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
                    <button class="btn btn-light position-relative" type="submit" style = "background-color: white;">My Concert';
                    if (in_array("approved", $status) || in_array("rejected", $status)) {
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
    <?php
    if ((!isset($_SESSION['concert_id']) && isset($_GET['concert_id'])) || (isset($_SESSION['concert_id']) && isset($_GET['concert_id']))) {
        $_SESSION['concert_id'] = $_GET['concert_id'];
    }
    $concert_id = $_SESSION['concert_id'];
    require_once 'config/db.php';
    //concert data
    $sql = <<<EOF
    SELECT * from concert
    WHERE concert_id = $concert_id;
    EOF;
    $ret = $db->query($sql);
    $row = $ret->fetchArray(SQLITE3_ASSOC);

    echo '<div class="container">
        <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link1 nav-link" href="each_my_concert.php">ข้อมูลคอนเสิร์ต</a>
        </li>
        <li class="nav-item">
            <a class="nav-link1 nav-link active" aria-current="page" href="each_my_concert_stat.php" >ดูข้อมูลการซื้อบัตร</a>
        </li>
        </ul><br><h5>ข้อมูลบัตรคอนเสิร์ต</h5><hr>';
    $sql2 = <<<EOF
        SELECT * 
        FROM ticket_detail
        WHERE concert_id = $concert_id;
        ORDER BY detail_id
        EOF;
    $ret2 = $db->query($sql2);


    $sql_amount_buy = <<<EOF
        SELECT COUNT(CASE WHEN payment_id IS NOT NULL THEN detail_id END) AS amount_sell
        FROM ticket t
        JOIN ticket_detail td
        USING (detail_id)
        WHERE concert_id = $concert_id
        GROUP BY detail_id
        ORDER BY detail_id
        EOF;
    $ret_amount_buy = $db->query($sql_amount_buy);

    //เก็บค่ารายได้รวม
    $total_earn = 0;
    //display table
    echo '<table class="table  table-hover text-center">
        <thead>
            <tr >
            <th scope="col">ชนิดบัตร</th>
            <th scope="col">ราคา</th>
            <th scope="col">จำนวนที่เปิดขาย</th>
            <th scope="col">ขายได้</th>
            <th scope="col">คงเหลือ</th>
            <th scope="col">รายได้</th>
            </tr>
        </thead><tbody>';
    while ($row2 = $ret2->fetchArray(SQLITE3_ASSOC)) {
        $row_amount_buy = $ret_amount_buy->fetchArray(SQLITE3_ASSOC);
        echo '<tr>
            <td class="text-start"><b>' . $row2['name'] . '</b><p style = "color:#808080">' . $row2['description'] . '</p></td>
            <td>' . $row2['price'] . '</td>
            <td><span class="badge bg-warning rounded-pill px-3">' . $row2['amount'] . '</span></td>
            <td><span class="badge bg-success rounded-pill px-3">' . $row_amount_buy['amount_sell'] . '</span></td>
            <td><span class="badge bg-secondary rounded-pill px-3">' . $row2['amount'] - $row_amount_buy['amount_sell'] . '</span></td>
            <td><p style= "color:#088F8F"><b>' . number_format((float) $row2['price'] * $row_amount_buy['amount_sell'], 2, '.', '') . '</b></p></td>
          </tr>';
        $total_earn = $total_earn + ($row2['price'] * $row_amount_buy['amount_sell']);
    }
    echo '<tr >
        <td class=" align-items-center pt-3" style = "background-color: #F0F0F0;"><p style = "color:#00A36C"><b>รายได้รวม</b></p></td>
        <td style = "background-color: #F0F0F0;"></td>
        <td style = "background-color: #F0F0F0;"></td>
        <td style = "background-color: #F0F0F0;"></td>
        <td style = "background-color: #F0F0F0;"></td>
        <td class=" align-items-center pt-3" style = "color:#00A36C; background-color: #F0F0F0;"><h4><b>' . number_format((float) $total_earn, 2, '.', '') . '</b></h4></td>
      </tr></tbody></table>';
    echo '</div>';

    //ประวัติการขายบัตร
    $sql_sell_history = <<<EOF
        SELECT * , COUNT(*)
        FROM ticket 
        JOIN ticket_detail 
        USING (detail_id)
        JOIN payment
        USING (payment_id)
        JOIN member
        USING (member_id)
        WHERE concert_id = $concert_id AND payment_id is not null
        GROUP BY member_id, detail_id;
        EOF;
    $ret_sell_history = $db->query($sql_sell_history);
    $count_sell = 0;
    while ($row_sell_history = $ret_sell_history->fetchArray(SQLITE3_ASSOC)) {
        $count_sell++;
    }
    $sql_sell_history = <<<EOF
        SELECT * , COUNT(*)
        FROM ticket 
        JOIN ticket_detail 
        USING (detail_id)
        JOIN payment
        USING (payment_id)
        JOIN member
        USING (member_id)
        WHERE concert_id = $concert_id AND payment_id is not null
        GROUP BY member_id, detail_id;
        EOF;
    $ret_sell_history = $db->query($sql_sell_history);
    echo '<br><div class="container"><h5>ประวัติการขายบัตร</h5><div class="overflow-auto">';
    if ($count_sell > 0) {
        echo '<table class="table table-success  table-striped text-center">
        <thead>
            <tr>
            <th scope="col">ชนิดบัตร</th>
            <th scope="col">ราคา</th>
            <th scope="col">จำนวน</th>
            <th scope="col">ผู้ซื้อ</th>
            <th scope="col">ราคา</th>
            </tr>
        </thead><tbody>';
        while ($row_sell_history = $ret_sell_history->fetchArray(SQLITE3_ASSOC)) {
            echo '<tr>
            <td class="text-start"><b>' . $row_sell_history['name'] . '</b><p style = "color:#808080">' . $row_sell_history['description'] . '</p></td>
            <td>' . $row_sell_history['price'] . '</td>
            <td><span class="badge bg-success rounded-pill px-3">' . $row_sell_history['COUNT(*)'] . '</span></td>
            <td>' . $row_sell_history['email'] . '</td>
            <td><p style= "color:#088F8F"><b>' . number_format((float) $row_sell_history['COUNT(*)'] * $row_sell_history['price'], 2, '.', '') . '</b></p></td>
            </tr>';
        }
        echo '</tbody></table>';

    } else {
        echo 'ยังไม่มีการขายบัตร';
    }

    echo '</div></div>';

    ?>
    <footer class="py-3 my-4 ">
        <hr>
        <p class="text-center text-muted">© 2023 TICKCON</p>
    </footer>

</body>

</html>