<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>check concert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .container {
            margin: auto;
            margin-bottom: 20px;
        }

        .comment {
            color: blue;
        }
    </style>
</head>

<body>
    <a href="con_waiting_list.php"><button class="btn btn-secondary">back</button></a>
    <?php
    session_start();
    if((!isset( $_SESSION['concert_id']) && isset($_GET['concert_id'])) || (isset($_SESSION['concert_id']) && isset($_GET['concert_id']))){
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
    //user data
    $user_id = $row['user_id'];
    $sql2 = <<<EOF
    SELECT * from user
    WHERE user_id = $user_id;
    EOF;
    $ret2 = $db->query($sql2);
    $row2 = $ret2->fetchArray(SQLITE3_ASSOC);


    echo '<form method = "get"><div class="container">' .
        '<div>' .
        '<p><b>From User : </b>' . $row2['fname'] . '  ' . $row2['lname'] . '<b> email : </b>' . $row2['email'] . '</p>' .
        '</div>' .
        '<div>' .
        '<p><b>ชื่อคอนเสิร์ต :</b><br>' . $row['concert_name'] . '<p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="concert_name_comment" style="width: 50%; height: 50px;"></textarea><hr>' .
        '</div>' .
        '<div>' .
        '<p><b>สถานที่จัดคอนเสิร์ต :</b><br>' . $row['address'] . '<p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="address_comment" style="width: 50%; height: 50px;"></textarea><hr>' .
        '</div>' .
        '<div>' .
        '<p><b>ข้อจำกัด :</b><br>' . $row['requirement'] . '<p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="requirement_comment" style="width: 50%; height: 50px;"></textarea><hr>' .
        '</div>' .
        '<div>' .
        '<p><b>วันที่ปิดขายบัตรคอนเสิร์ต :</b><br>' . $row['open_booking_date'] . '<p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="open_booking_date_comment" style="width: 50%; height: 50px;"></textarea><hr>' .
        '</div>' .
        '<div>' .
        '<p><b>วันที่จัดคอนเสิร์ต :</b><br>' . $row['show_date'] . '<p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="show_date_comment" style="width: 50%; height: 50px;"></textarea><hr>' .
        '</div>' .
        '<div>' .
        '<p><b>เวลาเริ่มคอนเสิร์ต :</b><br>' . $row['show_time'] . '<p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="show_time_comment" style="width: 50%; height: 50px;"></textarea><hr>' .
        '</div>' .
        '<div>' .
        '<p><b>บัตรคอนเสิร์ต :</b><br>';
    $sql3 = <<<EOF
        SELECT name,description,price,COUNT(price)
        FROM ticket
        JOIN ticket_detail
        USING (detail_id)
        WHERE concert_id = $concert_id
        GROUP BY price
        ORDER BY price;
    EOF;
    $ret3 = $db->query($sql3);
    while ($row3 = $ret3->fetchArray(SQLITE3_ASSOC)) {
        echo '<p><b>ชื่อบัตร :</b>' . $row3['name'] . '<b> ราคาบัตร :</b>' . $row3['price'] . ' บาท   <b>จำนวน :</b>' . $row3['COUNT(price)'] . '  ใบ<br><b> รายละเอียด :</b>' . $row3['description'] . '</p>';
    }
    echo '<p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="ticket_comment" style="width: 50%; height: 50px;"></textarea><hr>' .
        '</div>' .
        '<div>' .
        '<p><b>รายละเอียดคอนเสิร์ต :</b><br>' . $row['detail'] . '<p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="detail_comment" style="width: 50%; height: 50px;"></textarea><hr>' .
        '</div>' .
        '<div>' .
        '<p><b>โปสเตอร์คอนเสิร์ต :</b><br></p>' . '<img src="' . $row['concert_img_path'] . '" style="max-width : 40vw"><br>' . '<a href="' . $row['concert_img_path'] . '" download>download</a>' . '<p class="comment">ความคิดเห็น :</p>' . '<textarea name="concert_img_comment" style="width: 50%; height: 50px;"></textarea><hr>' .
        '</div>' .
        '<div>' .
        '<p><b>สำเนาบัตรประชาชนผู้จัดคอนเสิร์ต :</b><br></p>' . '<img src="' . $row['copy_id_card_img'] . '" style="max-width : 40vw"><br>' . '<a href="' . $row['copy_id_card_img'] . '" download>download</a>' . '<p class="comment">ความคิดเห็น :</p>' . '<textarea name="copy_id_card_comment" style="width: 50%; height: 50px;"></textarea><hr>' .
        '</div>' .
        '<div>' .
        '<p><b>ใบอนุญาตจัดคอนเสิร์ต :</b><br></p>' . '<img src="' . $row['con_permission_img'] . '" style="max-width : 40vw"><br>' . '<a href="' . $row['con_permission_img'] . '" download>download</a>' . '<p class="comment">ความคิดเห็น :</p>' . '<textarea name="con_permission_comment" style="width: 50%; height: 50px;"></textarea><hr>' .
        '</div>' .
        '<div>' .
        '<p><b>แผนผังคอนเสิร์ต :</b><br></p>' . '<img src="' . $row['stage_img'] . '" style="max-width : 40vw"><br>' . '<a href="' . $row['stage_img'] . '" download>download</a>' . '<p class="comment">ความคิดเห็น :</p>' . '<textarea name="stage_img_comment" style="width: 50%; height: 50px;"></textarea><hr>' .
        '</div>' .
        '<div>' .
        '<p><b>ชื่อบัญชีรับเงิน :</b><br>' . $row['bank_name'] . '<p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="bank_name_comment" style="width: 50%; height: 50px;"></textarea><hr>' .
        '</div>' .
        '<div>' .
        '<p><b>เลขที่บัญชีรับเงิน :</b><br>' . $row['bank_code'] . '<p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="bank_code_comment" style="width: 50%; height: 50px;"></textarea><hr>' .
        '</div>' .
        '<button type = "submit" name="button" value = "approve" class="btn btn-primary">Approve</button>
    <button type = "submit" name="button" value = "reject" class="btn btn-danger">Reject</button>
    </div></from>';
    if (isset($_GET['button'])) {
        $concert_name_comment = $_GET['concert_name_comment'];
        $detail_comment = $_GET['detail_comment'];
        $concert_img_comment = $_GET['concert_img_comment'];
        $show_date_comment = $_GET['show_date_comment'];
        $show_time_comment = $_GET['show_time_comment'];
        $copy_id_card_comment = $_GET['copy_id_card_comment'];
        $con_permission_comment = $_GET['con_permission_comment'];
        $stage_img_comment = $_GET['stage_img_comment'];
        $bank_name_comment = $_GET['bank_name_comment'];
        $bank_code_comment = $_GET['bank_code_comment'];
        $address_comment = $_GET['address_comment'];
        $ticket_comment = $_GET['ticket_comment'];
        $open_booking_date_comment = $_GET['open_booking_date_comment'];
        $requirement_comment = $_GET['requirement_comment'];
        if ($_GET['button'] == 'approve') {
            $sql4 = <<<EOF
            UPDATE concert
            SET status = "approved"
            WHERE concert_id = $concert_id;
            EOF;
            $ret4 = $db->exec($sql4);
            header("Location: con_waiting_list.php");
        } else if ($_GET['button'] == 'reject') {
            $sql5 = <<<EOF
            UPDATE concert
            SET status = "rejected",
            concert_name_comment = '$concert_name_comment',
            detail_comment = '$detail_comment',
            concert_img_comment = '$concert_img_comment',
            show_date_comment = '$show_date_comment',
            show_time_comment = '$show_time_comment',
            copy_id_card_comment = '$copy_id_card_comment',
            con_permission_comment = '$con_permission_comment',
            stage_img_comment = '$stage_img_comment',
            bank_name_comment = '$bank_name_comment',
            bank_code_comment = '$bank_code_comment',
            address_comment = '$address_comment',
            ticket_comment = '$ticket_comment',
            open_booking_date_comment = '$open_booking_date_comment',
            requirement_comment = '$requirement_comment'
            WHERE concert_id = $concert_id; 
            EOF;
            $ret5 = $db->exec($sql5);
            header("Location:con_waiting_list.php");
        }
    }
    ?>
</body>
</html>