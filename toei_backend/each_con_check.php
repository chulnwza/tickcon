<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create concert</title>
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
    $concert_id = $_GET['concert_id'];
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


    echo '<form action="each_con_check.php?concert_id=' . $row['concert_id'] . '" method = "post"><div class="container">' .
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
        '<p><b>วันที่จัดคอนเสิร์ต :</b><br>' . $row['show_date'] . '<p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="show_date_comment" style="width: 50%; height: 50px;"></textarea><hr>' .
        '</div>' .
        '<div>' .
        '<p><b>เวลาเริ่มคอนเสิร์ต :</b><br>' . $row['show_time'] . '<p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="show_time_comment" style="width: 50%; height: 50px;"></textarea><hr>' .
        '</div>' .
        '<div>' .
        '<p><b>บัตรคอนเสิร์ต :</b><br>';
    $sql3 = <<<EOF
        SELECT name,detail,price,COUNT(price) 
        FROM ticket
        WHERE concert_id = $concert_id
        GROUP BY price
        ORDER BY price;
    EOF;
    $ret3 = $db->query($sql3);
    while ($row3 = $ret3->fetchArray(SQLITE3_ASSOC)) {
        echo '<p><b>ชื่อบัตร :</b>' . $row3['name'] . '<b> ราคาบัตร :</b>' . $row3['price'] . ' บาท   <b>จำนวน :</b>' . $row3['COUNT(price)'] . '  ใบ<b> รายละเอียด :</b>' . $row3['detail'] . '</p>';
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
    </from></div>';
    if (isset($_POST['button'])) {
        $concert_name_comment = $_POST['concert_name_comment'];
        $detail_comment = $_POST['detail_comment'];
        $concert_img_comment = $_POST['concert_img_comment'];
        $show_date_comment = $_POST['show_date_comment'];
        $show_time_comment = $_POST['show_time_comment'];
        $copy_id_card_comment = $_POST['copy_id_card_comment'];
        $con_permission_comment = $_POST['con_permission_comment'];
        $stage_img_comment = $_POST['stage_img_comment'];
        $bank_name_comment = $_POST['bank_name_comment'];
        $bank_code_comment = $_POST['bank_code_comment'];
        $address_comment = $_POST['address_comment'];
        $ticket_comment = $_POST['ticket_comment'];
        if ($_POST['button'] == 'approve') {
            $sql4 = <<<EOF
                        UPDATE concert
                        SET status = "approved"
                        WHERE concert_id = $concert_id;
                    EOF;
            $ret4 = $db->exec($sql4);
            header("Location:con_waiting_list.php");
            exit();
        } else if ($_POST['button'] == 'reject') {
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
                        ticket_comment = '$ticket_comment'
                        WHERE concert_id = $concert_id;
                    EOF;
            $ret5 = $db->exec($sql5);
            header("Location:con_waiting_list.php",true, 301);
            exit();
        }
    }
    ?>
</body>
</html>