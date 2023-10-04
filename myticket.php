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
       $this->open('test.db');
    }
    }

    //open db
    $_SESSION['id'] = '1';
    $db = new MyDB();
    $sql = "SELECT concert_name, detail, ticket_id, t.ticket_type
            FROM booking b
            JOIN ticket t
            USING (ticket_id) 
            JOIN concert c
            USING (concert_id)
            WHERE member_id = ". $_SESSION['id'] . ";";
    $ret = $db->query($sql);
    echo '<main><div class="container bg-dark pt-3 rounded-top">
            <div class="container pt-2 pb-3">
                <h3 class="text-center text-light">My Ticket</h5>
            </div>
            <div class="container bg-success pt-3 px-5 h-100 rounded">';
    while($row = $ret->fetchArray(SQLITE3_ASSOC)) {
        echo
        // สร้างแถว ที่ระยะห่างแกน x = 0
        '<div class="row gx-0">'
        . //สร้าง column ที่มีความยาว 7/12 ของหน้าจอ ซึ่ง padding = 0 และ margin-bottom = 2
        '<div class="col-7 p-0 mb-2">'
        . //สร้างที่เก็บ card ที่มีความสูง 100% ของความสูง row และ กรอบโค้งด้านซ้าย
            '<div class="card h-100 rounded-left">'
        . //สร้างเนื้อหาของการ์ดที่มี พื้นหลังสี primary(น้ำเงิน) มีกรอบ ความหนา3 กรอบโค้งด้านซ้าย และเซ็ตให้กรอบที่เหลือไม่โค้ง
                '<div class="card-body bg-primary border border-3 border-light rounded-start rounded-0">'
        . //สร้างเนื้อหาใน card-body ที่ฟอนต์สีขาว และ padding-left = 1 โดยนำเนื้อหาจาก query
                    '<div class="text-white ps-1">'. $row['concert_name']. '</div>'
        . //สร้างปุ่มสีแดงที่ padding-top = 2, margin-top = 2
                    '<a href="#" class="btn btn-danger pt-2 mt-2">แสดง QR code</a>
                </div>
            </div>
        </div>'
        . //สร้าง column ที่มีความยาว 5/12 ของหน้าจอ ซึ่ง padding = 0 และ margin-bottom = 2
        '<div class="col-5 p-0 mb-2">'
        . //สร้างที่เก็บ card ที่มีความสูง 100% ของความสูง row และ กรอบไม่โค้ง
            '<div class="card p-0 h-100 rounded-0 border-0">
                <ul class="list-group list-group-light h-100">
                    <li class="list-group-item p-1 rounded-right-1 h-100"><small>รหัสบัตร : '. $row['ticket_id'] .'</small></li>
                    <li class="list-group-item p-1 h-100"><small>ที่นั่ง : '. $row['ticket_type'] .'</small></li>
                    <li class="list-group-item p-1 h-100"><small>วันจัด : '. $row['detail'] .'</small></li>
                    <li class="list-group-item p-1 rounded-0 h-100"><small>สถานที่จัด : </small></li>
                </ul>
            </div>
        </div>
        </div>';
    }
    echo '</div></div>';
    ?>
    </main>
    <footer></footer>
</body>

</html>