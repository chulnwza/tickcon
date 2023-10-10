<html lang="en">
<?php
session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Ticket</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <header></header>
    
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
    $sql = "SELECT concert_name, show_date, show_time, t.ticket_type, detail, concert_img_path, t.ticket_id
            FROM booking b
            JOIN ticket t
            USING (ticket_id) 
            JOIN concert c
            USING (concert_id)
            WHERE member_id = ". $_SESSION['user_login'] . ";";
    $ret = $db->query($sql);
    echo '<div class="container bg-dark pt-3 rounded-top">
    <div class="container pt-2 pb-3">
        <h3 class="text-center text-light">My Ticket</h5>
    </div>
    <div class="container">
    <div class="row">';
    $count = 1;
    $column1 = $column2 = '<div class="col-sm-12 col-md-6 col-lg-6 mb-3">';
    while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
        $text = '
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title text-center">
                        <h4> ' . $row['concert_name'] . '<h4>
                    </div>
                    <img class="rounded rounded-4 border border-3 border-dark w-100 mt-3 mb-3"
                        src= '. $row['concert_img_path'] .'>
                    <small>
                        <p class="mb-0"><i class="far fa-calendar-days"></i> '. $row['show_date'] .',
                            <i class="far fa-clock"></i> '. $row['show_time'] .'</small></p>
                    <ul class="list-group list-group-unstyled ms-0 align-items-start">
                        <li class="list-group-item border-0"><i
                                class="fas fa-ticket-simple"></i>&nbsp;เลขตั๋ว : '. $row['ticket_id'] .'</li>
                        <li class="list-group-item border-0"><i
                                class="fas fa-person"></i>&nbsp;ประเภทที่นั่ง : '. $row['ticket_type'] .'</li>
                        <li class="list-group-item border-0"><i class="fas fa-map"></i>&nbsp;สถานที่จัด : '. $row['detail'] .'
                        </li>
                    </ul>
                </div>
                <div class="card-footer d-inline-flex">
                    <a href="#" class="btn btn-danger pt-2 me-2 w-100">ดูรายละเอียด</a>
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
    echo $column2 .= '</div></div></div></div>';
    ?>
    </main>
    <footer></footer>
</body>

</html>