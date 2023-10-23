<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>check concert</title>
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
        .container {
            margin: auto;
            margin-bottom: 20px;
        }

        .comment {
            color: blue;
        }

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
            <a class="navbar-brand" href="index_admin.php">
                <img src="upload/logo/TICKCON.png" alt="Logo" width="150px" class="d-inline-block align-text-top">
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
    <a href="con_waiting_list.php"><button class="btn btn-secondary">back</button></a>
    <?php
    session_start();
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
    //user data
    $member_id = $row['member_id'];
    $sql2 = <<<EOF
    SELECT * from member
    WHERE member_id = $member_id;
    EOF;
    $ret2 = $db->query($sql2);
    $row2 = $ret2->fetchArray(SQLITE3_ASSOC);


    echo '<div class="container">
        <form method="get" >
            <div class="mb-3">
                <label for="cname" class="form-label"><b>ผู้สร้างคอนเสิร์ต</b></label>
                <input type="text" class="form-control" name="cname" value = "' . $row2['firstname'] . ' ' . $row2['lastname'] . '" disabled>
                <label for="cname" class="form-label"><b>email</b></label>
                <input type="text" class="form-control" name="cname" value = "' . $row2['email'] . '" disabled><hr>
            </div>
            <div class="mb-3">
                <label for="cname" class="form-label"><b>ชื่อคอนเสิร์ต</b></label>
                <input type="text" class="form-control" name="cname" value = "' . $row['concert_name'] . '" disabled>
                <p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="concert_name_comment" style="width: 50%; height: 50px;"></textarea><hr>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label"><b>สถานที่จัดคอนเสิร์ต</b></label><br>
                <textarea name="address" style="width: 100%; height: 100px;" disabled>' . $row['address'] . '</textarea>
                <p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="address_comment" style="width: 50%; height: 50px;"></textarea><hr>
            </div>
            <div class="mb-3">
                <label for="bdate" class="form-label"><b>วันที่เปิดให้จองบัตรคอนเสิร์ต</b></label>
                <input type="date" class="form-control" name="bdate" value = "' . $row['open_booking_date'] . '" disabled>
                <p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="open_booking_date_comment" style="width: 50%; height: 50px;"></textarea><hr>
            </div>
            <div class="mb-3">
                <label for="cdate" class="form-label"><b>วันที่จัดคอนเสิร์ต</b></label>
                <input type="date" class="form-control" name="cdate" value = "' . $row['show_date'] . '" disabled>
                <p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="show_date_comment" style="width: 50%; height: 50px;"></textarea><hr>
            </div>
            <div class="mb-3">
                <label for="ctime" class="form-label"><b>เวลาเริ่มคอนเสิร์ต</b></label>
                <input type="time" class="form-control" name="ctime" value = "' . $row['show_time'] . '" disabled>
                <p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="show_time_comment" style="width: 50%; height: 50px;"></textarea><hr>
            </div>
            <div class="mb-3">
                <label class="form-label"><b>รายละเอียดคอนเสิร์ต</b></label><br>
                <textarea name="detail" style="width: 100%; height: 100px;" disabled>' . $row['detail'] . '</textarea>
                <p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="detail_comment" style="width: 50%; height: 50px;"></textarea><hr>
            </div>
            <div class="mb-3">
                <label for="require" class="form-label"><b>ข้อจำกัดของคอนเสิร์ต</b></label>
                <input type="require" class="form-control" name="require" value = "' . $row['requirement'] . '" disabled>
                <p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="requirement_comment" style="width: 50%; height: 50px;"></textarea><hr>
            </div>
            <div class="mb-3" id="tic_type_add"><b>บัตรคอนเสิร์ต</b><br>';
    //ticket section start
    $sql3 = <<<EOF
        SELECT name,description,price,COUNT(detail_id)
        FROM ticket
        JOIN ticket_detail
        USING (detail_id)
        WHERE concert_id = $concert_id
        GROUP BY detail_id
        ORDER BY price ASC;
    EOF;
    $ret3 = $db->query($sql3);
    while ($row3 = $ret3->fetchArray(SQLITE3_ASSOC)) {
        echo '<hr><label class="form-label">ชื่อบัตร</label>
                <input type="text" class="form-control" name="tic_name[]"  value = "' . $row3['name'] . '" disabled>
                <label class="form-label">ราคาบัตร</label>
                <input type="number" class="form-control" name="tic_price[]"  value = "' . $row3['price'] . '" disabled>
                <label class="form-label">จำนวนบัตร</label>
                <input type="number" class="form-control" name="tic_amount[]"  value = "' . $row3['COUNT(detail_id)'] . '" disabled>
                <label class="form-label">คำอธิบาย</label>
                <textarea name="tic_detail[]" style="width: 100%; height: 70px;" disabled>' . $row3['description'] . '</textarea>';
    }
    //ticket section end
    echo '<p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="ticket_comment" style="width: 50%; height: 50px;"></textarea><hr></div>
            <div class="mb-3">
                <label for="poster_img" class="form-label"><b>โปสเตอร์คอนเสิร์ต</b></label><br>
                <img src="' . $row['concert_img_path'] . '" style="max-width : 40vw"><br><a href="' . $row['stage_img'] . '" >download</a><br><br>
                <p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="concert_img_comment" style="width: 50%; height: 50px;"></textarea><hr>
            </div>

            <div class="mb-3">
                <label for="id_card_img" class="form-label"><b>สำเนาบัตรประชาชนผู้จัดคอนเสิร์ต</b></label><br>
                <img src="' . $row['copy_id_card_img'] . '" style="max-width : 40vw"><br><a href="' . $row['stage_img'] . '" >download</a><br><br>
                <p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="copy_id_card_comment" style="width: 50%; height: 50px;"></textarea><hr>
            </div>
            <div class="mb-3">
                <label for="license_img" class="form-label"><b>ใบอนุญาตจัดคอนเสิร์ต</b></label><br>
                <img src="' . $row['con_permission_img'] . '" style="max-width : 40vw"><br><a href="' . $row['stage_img'] . '" >download</a><br><br>
                <p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="con_permission_comment" style="width: 50%; height: 50px;"></textarea><hr>
            </div>
            <div class="mb-3">
            <label for="con_img" class="form-label"><b>แผนผังคอนเสิร์ต</b></label><br>';

            if (is_null($row['stage_img'])) {
                echo '<p style="color : #808080;">ไม่ได้อัพโหลดแผนผังคอนเสิร์ต</p>';
            } else {
                echo '<img src="' . $row['stage_img'] . '" style="max-width : 40vw"><br><br>';
            }
            echo '<textarea name="stage_img_comment" style="width: 50%; height: 50px;"></textarea><hr>
            </div>
             <div class="mb-3">
                <label for="bank_acc_name" class="form-label"><b>ชื่อธนาคารรับเงิน</b></label>
                <input type="text" class="form-control" name="bank_acc_name"  value = "' . $row['bank_name'] . '" disabled>
                <p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="bank_name_comment" style="width: 50%; height: 50px;"></textarea><hr>
                <label for="bank_acc_number" class="form-label"><b>เลขที่บัญชีธนาคารรับเงิน</b></label>
                <input type="text" class="form-control" name="bank_acc_number"  value = "' . $row['bank_code'] . '" disabled> 
                <p class="comment">ความคิดเห็น :</p></p>' . '<textarea name="bank_code_comment" style="width: 50%; height: 50px;"></textarea><hr>
            </div>
            <button type = "submit" name="button" value = "approve" class="btn btn-primary">Approve</button>
            <button type = "submit" name="button" value = "reject" class="btn btn-danger">Reject</button>
            </form></div>';
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
    <footer class="py-3 my-4 ">
        <hr>
        <p class="text-center text-muted">© 2023 TICKCON</p>
    </footer>
</body>

</html>