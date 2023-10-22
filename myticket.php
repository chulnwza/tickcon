<!DOCTYPE html>
<html lang="en">
<?php
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <main>
        <?php
    // Import File
    class MyDB extends SQLite3 {
    function __construct() {
       $this->open('mainDatabase.db');
        }
    }

    //open db
    $db = new MyDB();
    $_SESSION['user_login'] = 1; #แก้ตอนรวมไฟล์
        if (!isset($_SESSION['user_login'])) {
            $_SESSION['error'] = 'กรุณาล็อคอินก่อน';
            header("location: /tickcon/login.php", TRUE);
            exit;
        } elseif (isset($_SESSION['user_login'])) {
            $sql = "SELECT concert_name, show_date, show_time, t.ticket_type, c.address, requirements, concert_img_path, t.ticket_id
            FROM booking b
            JOIN ticket t
            USING (ticket_id) 
            JOIN concert c
            USING (concert_id)
            WHERE member_id = ". $_SESSION['user_login'] . ";";
        $ret = $db->query($sql);
        $count = 0;
        while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
            $count = $count + 1;
        }
        echo '<div class="container bg-secondary pt-3 rounded-top h-100 mt-3">
        <div class="container pt-2 pb-3">
            <h3 class="text-center text-light">My Ticket</h5>
        </div>
        <div class="container">
        <div class="row">';
        $count = 1;
        $column1 = $column2 = '<div class="col-sm-12 col-md-6 col-lg-6 mb-3">';
        if ($count <= 0) {
        }
        else while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $text = '
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title text-center">
                        <p class="fw-bold fs-4 py-0"> ' . $row['concert_name'] . '<p>
                        </div>
                        <img class="rounded rounded-4 border border-3 border-dark w-100 mt-1 mb-3"
                            src="/tickcon/toei_backend/'. $row['concert_img_path'] .'" alt="poster">
                        <small>
                            <p class="mb-0"><i class="far fa-calendar-days"></i> '. date('l d F Y', strtotime($row['show_date'])) .',
                                <i class="far fa-clock"></i> '. $row['show_time'] .'</small></p>
                        <ul class="list-group list-group-unstyled ms-0 align-items-start">
                            <li class="list-group-item border-0"><i
                                    class="fas fa-person"></i>&nbsp;ประเภทที่นั่ง : '. $row['ticket_type'] .'</li>
                            <li class="list-group-item border-0"><i class="fas fa-map"></i>&nbsp;สถานที่จัด : '. $row['address'] .'
                            <li class="list-group-item border-0"><i class="fas fa-map"></i>&nbsp;ข้อจำกัด : '. $row['requirements'] .'
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer d-inline-flex">'.
                    //รอชูทำดูรายละเอียดกับ QR
                        '<a href="#" class="btn btn-danger pt-2 me-2 w-100">ดูรายละเอียด</a>
                        <a href="#" class="btn btn-danger pt-2 w-100">แสดง QR Code</a>
                    </div>
                </div>';
            if ($count == 1) {
                $column1 .= $text;
                $count += 1;
            }elseif ($count == 2) {
                $column2 .= $text;
                $count = 1;
            }
            }
            echo $column1 .= '</div>';
            echo $column2 .= '</div>';
        }
        echo '</div></div></div>';
    ?>

    </main>
    <footer></footer>
</body>

</html>