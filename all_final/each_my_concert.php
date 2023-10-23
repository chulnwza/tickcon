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
                        <a class="nav-link-1 nav-link" href="myticket.php">My Tickets</a>
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
                <p><?=$_SESSION['firstname']?></p>
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
    if (!isset($_POST['button'])) {
        echo '<div class="container">
        
        <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">ข้อมูลคอนเสิร์ต</a>
        </li>';
        if ($row['status'] == 'approved') {
            echo '<li class="nav-item">
                <a class="nav-link" href="each_my_concert_stat.php">ดูข้อมูลการซื้อบัตร</a>
                </li>';
        }else{
            echo '<li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true" href="each_my_concert_stat.php">ดูข้อมูลการซื้อบัตร</a>
                </li>';
        }

        echo '</ul><br>
    
        <form action="each_my_concert.php" method="post" enctype="multipart/form-data">
        <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
            <div class="mb-3">
                <label for="cname" class="form-label"><b>ชื่อคอนเสิร์ต</b></label>
                <input type="text" class="form-control" name="cname" value = "' . $row['concert_name'] . '" disabled>
                <p style="color : red;">' . $row['concert_name_comment'] . '</p><hr>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label"><b>สถานที่จัดคอนเสิร์ต</b></label><br>
                <textarea name="address" style="width: 100%; height: 100px;" disabled>' . $row['address'] . '</textarea>
                <p style="color : red;">' . $row['address_comment'] . '</p><hr>
            </div>
            <div class="mb-3">
                <label for="bdate" class="form-label"><b>วันที่เปิดให้จองบัตรคอนเสิร์ต</b></label>
                <input type="date" class="form-control" name="bdate" value = "' . $row['open_booking_date'] . '" disabled>
                <p style="color : red;">' . $row['open_booking_date_comment'] . '</p><hr>
            </div>
            <div class="mb-3">
                <label for="cdate" class="form-label"><b>วันที่จัดคอนเสิร์ต</b></label>
                <input type="date" class="form-control" name="cdate" value = "' . $row['show_date'] . '" disabled>
                <p style="color : red;">' . $row['show_date_comment'] . '</p><hr>
            </div>
            <div class="mb-3">
                <label for="ctime" class="form-label"><b>เวลาเริ่มคอนเสิร์ต</b></label>
                <input type="time" class="form-control" name="ctime" value = "' . $row['show_time'] . '" disabled>
                <p style="color : red;">' . $row['show_time_comment'] . '</p><hr>
            </div>
            <div class="mb-3">
                <label class="form-label"><b>รายละเอียดคอนเสิร์ต</b></label><br>
                <textarea name="detail" style="width: 100%; height: 100px;" disabled>' . $row['detail'] . '</textarea>
                <p style="color : red;">' . $row['detail_comment'] . '</p><hr>
            </div>
            <div class="mb-3">
                <label for="require" class="form-label"><b>ข้อจำกัดของคอนเสิร์ต</b></label>
                <input type="require" class="form-control" name="require" value = "' . $row['requirement'] . '" disabled>
                <p style="color : red;">' . $row['requirement_comment'] . '</p><hr>
            </div>
            <div class="mb-3">
                <label for="poster_img" class="form-label"><b>โปสเตอร์คอนเสิร์ต</b></label><br>
                <img src="' . $row['concert_img_path'] . '" style="max-width : 40vw"><br><br>
                <p style="color : red;">' . $row['concert_img_comment'] . '</p><hr>
            </div>
            <div class="mb-3">
                <label for="con_img" class="form-label"><b>แผนผังคอนเสิร์ต</b></label><br>';

        if (is_null($row['stage_img'])) {
            echo '<p style="color : #808080;">ไม่ได้อัพโหลดแผนผังคอนเสิร์ต</p>';
        } else {
            echo '<img src="' . $row['stage_img'] . '" style="max-width : 40vw"><br><br>';
        }
        echo '<p style="color : red;">' . $row['stage_img_comment'] . '</p><hr>
            </div>
        </div>
        <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
            <div class="mb-3" id="tic_type_add">
            <label class="form-label"><b>บัตรคอนเสิร์ต :</b></label>';
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
            echo '<div class="row">
                <div class="col">
                <label class="form-label">ชื่อบัตร</label>
                <input type="text" class="form-control" name="tic_name[]"  value = "' . $row3['name'] . '" disabled>
                </div>
                <div class="col"> 
                <label class="form-label">ราคาบัตร</label>
                <input type="number" class="form-control" name="tic_price[]"  value = "' . $row3['price'] . '" disabled>
                </div>
                <div class="col">  
                <label class="form-label">จำนวนบัตร</label>
                <input type="number" class="form-control" name="tic_amount[]"  value = "' . $row3['COUNT(detail_id)'] . '" disabled>
                </div>
                <div class="col">    
                <label class="form-label">คำอธิบาย</label>
                <textarea name="tic_detail[]" style="width: 100%; height: 40px;" disabled>' . $row3['description'] . '</textarea>
                </div>
                </div>';
        }
        //ticket section end
        echo '<p style="color : red;">' . $row['ticket_comment'] . '</p><hr></div>
        </div>
        
        <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
        <label class="form-label"><b>ข้อมูลผู้จัดคอนเสิร์ต :</b></label>

            <div class="mb-3">
                <label for="id_card_img" class="form-label"><b>สำเนาบัตรประชาชนผู้จัดคอนเสิร์ต</b></label><br>
                <img src="' . $row['copy_id_card_img'] . '" style="max-width : 40vw"><br><br>
                <p style="color : red;">' . $row['copy_id_card_comment'] . '</p><hr>
            </div>
            <div class="mb-3">
                <label for="license_img" class="form-label"><b>ใบอนุญาตจัดคอนเสิร์ต</b></label><br>
                <img src="' . $row['con_permission_img'] . '" style="max-width : 40vw"><br><br>
                <p style="color : red;">' . $row['con_permission_comment'] . '</p><hr>
            </div>
            <div class="mb-3">
                <label for="bank_acc_name" class="form-label"><b>ชื่อธนาคารับเงิน</b></label>
                <input type="text" class="form-control" name="bank_acc_name"  value = "' . $row['bank_name'] . '" disabled>
                <p style="color : red;">' . $row['bank_name_comment'] . '</p><hr>
                <label for="bank_acc_number" class="form-label"><b>เลขที่บัญชีธนาคารรับเงิน</b></label>
                <input type="text" class="form-control" name="bank_acc_number"  value = "' . $row['bank_code'] . '" disabled> 
                <p style="color : red;">' . $row['bank_code_comment'] . '</p><hr>
            </div></div>';
        if ($row['status'] != 'approved') {
            echo '<div class="">
            <button type="submit" class="btn btn-secondary" name="button" value="edit">Edit</button>
            <button type="submit" class="btn btn-outline-success" name="button" value="save" disabled>Save</button>
            <button type="submit" class="btn btn-';
            if (!isset($_SESSION['count_save'])) {
                echo 'outline-';
            }
            echo 'primary" name="button"  value="submit"';
            if (!isset($_SESSION['count_save'])) {
                echo 'disabled';
            }
            echo '>Submit</button>';
            if ($row['status'] != 'approved') {
                echo '<button type="submit" class="btn btn-danger float-end" name="button" value="delete" >Delete Concert</button>';
            }
            echo '</div></form><br></div>';
        }


    } else {
        if ($_POST['button'] == 'edit') {
            if (isset($_SESSION['count_save'])) {
                unset($_SESSION['count_save']);
            }
            $tmp_status = $row['status'];
            $sql_edit = <<<EOF
                UPDATE concert
                SET status = 'editing'
                WHERE concert_id = $concert_id;
            EOF;
            $ret_edit = $db->exec($sql_edit);
            echo '<div class="container">
        
        <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">ข้อมูลคอนเสิร์ต</a>
        </li>';
        if ($row['status'] == 'approved') {
            echo '<li class="nav-item">
                <a class="nav-link" href="each_my_concert_stat.php">ดูข้อมูลการซื้อบัตร</a>
                </li>';
        }else{
            echo '<li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true" href="each_my_concert_stat.php">ดูข้อมูลการซื้อบัตร</a>
                </li>';
        }

        echo '</ul><br>
                <form action="each_my_concert.php?tmp_status=' . $tmp_status . '" method="post" enctype="multipart/form-data">
                <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                    <div class="mb-3">
                        <label for="cname" class="form-label"><b>ชื่อคอนเสิร์ต</b></label>
                        <input type="text" class="form-control" name="cname" value = "' . $row['concert_name'] . '" >
                        <p style="color : red;">' . $row['concert_name_comment'] . '</p><hr>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label"><b>สถานที่จัดคอนเสิร์ต</b></label><br>
                        <textarea name="address" style="width: 100%; height: 100px;" >' . $row['address'] . '</textarea>
                        <p style="color : red;">' . $row['address_comment'] . '</p><hr>
                    </div>
                    <div class="mb-3">
                        <label for="bdate" class="form-label"><b>วันที่เปิดให้จองบัตรคอนเสิร์ต</b></label>
                        <input type="date" class="form-control" name="bdate" value = "' . $row['open_booking_date'] . '" >
                        <p style="color : red;">' . $row['open_booking_date_comment'] . '</p><hr>
                    </div>
                    <div class="mb-3">
                        <label for="cdate" class="form-label"><b>วันที่จัดคอนเสิร์ต</b></label>
                        <input type="date" class="form-control" name="cdate" value = "' . $row['show_date'] . '" >
                        <p style="color : red;">' . $row['show_date_comment'] . '</p><hr>
                    </div>
                    <div class="mb-3">
                        <label for="ctime" class="form-label"><b>เวลาเริ่มคอนเสิร์ต</b></label>
                        <input type="time" class="form-control" name="ctime" value = "' . $row['show_time'] . '" >
                        <p style="color : red;">' . $row['show_time_comment'] . '</p><hr>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><b>รายละเอียดคอนเสิร์ต</b></label><br>
                        <textarea name="detail" style="width: 100%; height: 100px;" >' . $row['detail'] . '</textarea>
                        <p style="color : red;">' . $row['detail_comment'] . '</p><hr>
                    </div>
                    <div class="mb-3">
                        <label for="require" class="form-label"><b>ข้อจำกัดของคอนเสิร์ต</b></label>
                        <input type="require" class="form-control" name="require" value = "' . $row['requirement'] . '" >
                        <p style="color : red;">' . $row['requirement_comment'] . '</p><hr>
                    </div>
                    <div class="mb-3">
                        <label for="poster_img" class="form-label"><b>โปสเตอร์คอนเสิร์ต</b></label><br>
                        <img src="' . $row['concert_img_path'] . '" style="max-width : 40vw"><br><a href="' . $row['concert_img_path'] . '" >download</a><br><br>
                        <input type="file" class="form-control" name="poster_img" accept="image/*" >
                        <p style="color : red;">' . $row['concert_img_comment'] . '</p><hr>
                    </div>
                    <div class="mb-3">
                <label for="con_img" class="form-label"><b>แผนผังคอนเสิร์ต</b></label><br>';
            if (is_null($row['stage_img'])) {
                echo '<p style="color : #808080;">ไม่ได้อัพโหลดแผนผังคอนเสิร์ต</p>';
            } else {
                echo '<img src="' . $row['stage_img'] . '" style="max-width : 40vw"><br><br>';
            }
            echo '<input type="file" class="form-control" name="con_img" accept="image/*">
                    <p style="color : red;">' . $row['stage_img_comment'] . '</p><hr>
                </div>

                    </div>
                    <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                    <label class="form-label"><b>บัตรคอนเสิร์ต :</b></label>';
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

                echo '<div class="row">
                <div class="col">
                <label class="form-label">ชื่อบัตร</label>
                        <input type="text" class="form-control" name="tic_name[]"  value = "' . $row3['name'] . '" >
                        </div>
                        <div class="col">
                        <label class="form-label">ราคาบัตร</label>
                        <input type="number" class="form-control" name="tic_price[]"  value = "' . $row3['price'] . '" >
                        </div>
                        <div class="col">
                        <label class="form-label">จำนวนบัตร</label>
                        <input type="number" class="form-control" name="tic_amount[]"  value = "' . $row3['COUNT(detail_id)'] . '" disabled>
                        </div>
                        <div class="col">
                        <label class="form-label">คำอธิบาย</label>
                        <textarea name="tic_detail[]" style="width: 100%; height: 70px;" >' . $row3['description'] . '</textarea>
                        </div>
                        </div>';
            }
            //ticket section end
            echo '<p style="color : red;">' . $row['ticket_comment'] . '</p><hr></div>
                    <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                    <label class="form-label"><b>ข้อมูลผู้จัดคอนเสิร์ต :</b></label>
                    <div class="mb-3">
                        <label for="id_card_img" class="form-label"><b>สำเนาบัตรประชาชนผู้จัดคอนเสิร์ต</b></label><br>
                        <img src="' . $row['copy_id_card_img'] . '" style="max-width : 40vw"><br><a href="' . $row['copy_id_card_img'] . '" >download</a><br><br>
                        <input type="file" class="form-control" name="id_card_img" accept="image/*" >
                        <p style="color : red;">' . $row['copy_id_card_comment'] . '</p><hr>
                    </div>
                    <div class="mb-3">
                        <label for="license_img" class="form-label"><b>ใบอนุญาตจัดคอนเสิร์ต</b></label><br>
                        <img src="' . $row['con_permission_img'] . '" style="max-width : 40vw"><br><a href="' . $row['con_permission_img'] . '" >download</a><br><br>
                        <input type="file" class="form-control" name="license_img" accept="image/*" >
                        <p style="color : red;">' . $row['con_permission_comment'] . '</p><hr>
                    </div>
                    
                <div class="mb-3">
                        <label for="bank_acc_name" class="form-label"><b>ชื่อธนาคารรับเงิน</b></label>
                        <input type="text" class="form-control" name="bank_acc_name"  value = "' . $row['bank_name'] . '" >
                        <p style="color : red;">' . $row['bank_name_comment'] . '</p><hr>
                        <label for="bank_acc_number" class="form-label"><b>เลขที่บัญชีธนาคารรับเงิน</b></label>
                        <input type="text" class="form-control" name="bank_acc_number"  value = "' . $row['bank_code'] . '" > 
                        <p style="color : red;">' . $row['bank_code_comment'] . '</p><hr>
                    </div></div>
                    <div class="">
            <button type="submit" class="btn btn-outline-secondary" name="button" value="edit" disabled>Edit</button>
            <button type="submit" class="btn btn-success" name="button" value="save" >Save</button>
            <button type="submit" class="btn btn-';
            if (!isset($_SESSION['count_save'])) {
                echo 'outline-';
            }
            echo 'primary" name="button"  value="submit"';
            if (!isset($_SESSION['count_save'])) {
                echo 'disabled';
            }
            echo '>Submit</button>';
            if ($row['status'] != 'approved') {
                echo '<button type="submit" class="btn btn-outline-danger float-end" name="button" value="delete" disabled>Delete Concert</button>';
            }
            echo '</div></form><br>
            </div>';
        } else if ($_POST['button'] == 'save') {
            $_SESSION['count_save'] = 1;
            $tmp_status = $_GET['tmp_status'];
            $sql_save = <<<EOF
            UPDATE concert
            SET status = '$tmp_status'
            WHERE concert_id = $concert_id;
            EOF;
            $ret_save = $db->exec($sql_save);

            //name
            $cname = $_POST['cname'];
            $cname = str_replace('"', '”', $cname);
            $cname = str_replace('‘', "'", $cname);
            $cname = str_replace('’', "'", $cname);
            //address
            $address = $_POST['address'];
            $address = str_replace('"', '”', $address);
            $address = str_replace('‘', "'", $address);
            $address = str_replace('’', "'", $address);
            //open booking date
            $bdate = $_POST['bdate'];
            //start date
            $cdate = $_POST['cdate'];
            //start time
            $ctime = $_POST['ctime'];
            //ticket name
            $tic_name = $_POST['tic_name'];
            //ticket price
            $tic_price = $_POST['tic_price'];
            //ticket detail
            $tic_detail = $_POST['tic_detail'];
            //detail
            $detail = $_POST['detail'];
            $detail = str_replace('"', '”', $detail);
            $detail = str_replace('‘', "'", $detail);
            $detail = str_replace('’', "'", $detail);
            //requirement
            $require = $_POST['require'];
            $require = str_replace('"', '”', $require);
            $require = str_replace('‘', "'", $require);
            $require = str_replace('’', "'", $require);
            //file
            $poster_img = basename($_FILES["poster_img"]["name"]);
            $id_card_img = basename($_FILES["id_card_img"]["name"]);
            $license_img = basename($_FILES["license_img"]["name"]);
            $con_img = basename($_FILES["con_img"]["name"]);
            //bank name
            $bank_acc_name = $_POST['bank_acc_name'];
            $bank_acc_name = str_replace('"', '”', $bank_acc_name);
            $bank_acc_name = str_replace('‘', "'", $bank_acc_name);
            $bank_acc_name = str_replace('’', "'", $bank_acc_name);
            //bank number
            $bank_acc_number = $_POST['bank_acc_number'];
            $member_id = $_SESSION['member_id']; #อย่าลืมแก้
            $alert_msg = "";

            if (empty($cname)) {
                $alert_msg .= 'กรุณาระบุชื่อคอนเสิร์ต\n';
            }
            if (empty($address)) {
                $alert_msg .= 'กรุณาระบุสถานที่จัดคอนเสิร์ต\n';
            }
            if (empty($bdate)) {
                $alert_msg .= 'กรุณาระบุวันที่เปิดให้จองบัตรคอนเสิร์ต\n';
            }
            if (empty($cdate)) {
                $alert_msg .= 'กรุณาระบุวันที่จัดคอนเสิร์ต\n';
            }
            if (empty($ctime)) {
                $alert_msg .= 'กรุณาระบุเวลาเริ่มคอนเสิร์ต\n';
            }
            if (empty($tic_name)) {
                $alert_msg .= 'กรุณาระบุชื่อบัตร\n';
            }
            if (empty($tic_price)) {
                $alert_msg .= 'กรุณาระบุราคาบัตร\n';
            }
            if (empty($detail)) {
                $alert_msg .= 'กรุณาระบุรายละเอียดคอนเสิร์ต\n';
            }
            if (empty($require)) {
                $alert_msg .= 'กรุณาระบุข้อจำกัดของคอนเสิร์ต หากไม่มีให้ใส่ (-)\n';
            }
            if (empty($bank_acc_name)) {
                $alert_msg .= 'กรุณาระบุชื่อบัญชีรับเงิน\n';
            }
            if (empty($bank_acc_number)) {
                $alert_msg .= 'กรุณาระบุเลขที่บัญชีรับเงิน\n';
            }
            if (strtotime($bdate) > strtotime($cdate)) {
                $alert_msg .= 'กรุณากรอกวันที่เปิดจำหน่ายบัตรให้เป็นวันที่ก่อนวันจัดแสดง\n';
            }
            if ($alert_msg != "") {
                echo "<script>alert('" . $alert_msg . "');</script>";
            } else {

                //cennect to database
                require_once 'config/db.php';

                // Upload file to server 
                if (!empty($poster_img)) {
                    $poster_img_path = "upload/poster/" . $poster_img;
                    move_uploaded_file($_FILES["poster_img"]["tmp_name"], $poster_img_path);
                    $sql1 = <<<EOF
                    UPDATE concert
                    SET concert_img_path = '$poster_img_path'
                    WHERE concert_id = $concert_id;
                    EOF;
                    $ret1 = $db->exec($sql1);
                }
                if (!empty($id_card_img)) {
                    $id_card_img_path = "upload/id_card/" . $id_card_img;
                    move_uploaded_file($_FILES["id_card_img"]["tmp_name"], $id_card_img_path);
                    $sql1 = <<<EOF
                    UPDATE concert
                    SET copy_id_card_img = '$id_card_img_path'
                    WHERE concert_id = $concert_id;
                    EOF;
                    $ret1 = $db->exec($sql1);
                }
                if (!empty($license_img)) {
                    $license_img_path = "upload/license/" . $license_img;
                    move_uploaded_file($_FILES["license_img"]["tmp_name"], $license_img_path);
                    $sql1 = <<<EOF
                    UPDATE concert
                    SET con_permission_img = '$license_img_path'
                    WHERE concert_id = $concert_id;
                    EOF;
                    $ret1 = $db->exec($sql1);
                }
                if (!empty($con_img)) {
                    $con_img_path = "upload/concert_map/" . $con_img;
                    move_uploaded_file($_FILES["con_img"]["tmp_name"], $con_img_path);
                    $sql1 = <<<EOF
                    UPDATE concert
                    SET stage_img = '$con_img_path'
                    WHERE concert_id = $concert_id;
                    EOF;
                    $ret1 = $db->exec($sql1);
                }
                $sql = <<<EOF
                        UPDATE concert
                        SET concert_name = "$cname",
                        detail = "$detail",
                        requirement = "$require",
                        open_booking_date = '$bdate',
                        show_date = '$cdate',
                        show_time = '$ctime',
                        bank_name = "$bank_acc_name",
                        bank_code = '$bank_acc_number',
                        address = "$address"
                        WHERE concert_id = $concert_id;
                        EOF;
                $ret = $db->exec($sql);
                if ($ret) {
                    $sql3 = <<<EOF
                            SELECT detail_id
                            FROM ticket_detail
                            WHERE concert_id = $concert_id
                            ORDER BY price ASC;
                            EOF;
                    $ret3 = $db->query($sql3);
                    $count = 0;
                    // $sql4 = <<<EOF
                    //         SELECT name,description,price,COUNT(detail_id)
                    //         FROM ticket
                    //         JOIN ticket_detail
                    //         USING (detail_id)
                    //         WHERE concert_id = $concert_id
                    //         GROUP BY detail_id
                    //         ORDER BY price ASC;
                    //         EOF;
                    // $ret4 = $db->query($sql4);
                    while ($row3 = $ret3->fetchArray(SQLITE3_ASSOC)) {

                        $detail_id = $row3['detail_id'];
                        //clean data avoid error
                        $tic_name_tmp = $tic_name[$count];
                        $tic_name_tmp = str_replace('"', '”', $tic_name_tmp);
                        $tic_name_tmp = str_replace('‘', "'", $tic_name_tmp);
                        $tic_name_tmp = str_replace('’', "'", $tic_name_tmp);
                        //clean data avoid error
                        $tic_detail_tmp = $tic_detail[$count];
                        $tic_detail_tmp = str_replace('"', '”', $tic_detail_tmp);
                        $tic_detail_tmp = str_replace('‘', "'", $tic_detail_tmp);
                        $tic_detail_tmp = str_replace('’', "'", $tic_detail_tmp);
                        $tic_price_tmp = $tic_price[$count];

                        $sql = <<<EOF
                        UPDATE ticket_detail
                        SET name = "$tic_name_tmp",
                        description = "$tic_detail_tmp",
                        price = '$tic_price_tmp'
                        WHERE detail_id = $detail_id;
                        EOF;
                        $ret = $db->exec($sql);
                        $count++;
                        // $row4 = $ret4->fetchArray(SQLITE3_ASSOC);
                        // if ($row4['COUNT(detail_id)'] < $tic_amount[$count]) {
                        //     for ($i = 1; $i <= $tic_amount[$count] - $row4['COUNT(detail_id)']; $i++) {
                        //         $sql = <<<EOF
                        //                 INSERT INTO ticket(detail_id)
                        //                 VALUES('$detail_id');
                        //                 EOF;
                        //         $ret = $db->exec($sql);
                        //     }
                        // }else if($row4['COUNT(detail_id)'] > $tic_amount[$count]){
    
                        // }
                    }
                } else {
                    echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">มีบางอย่างผิดพลาดโปรดลองใหม่อีกครั้ง EMSG:1<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
                }
            }
            header("Refresh:0");
        } else if ($_POST['button'] == 'submit') {
            unset($_SESSION['count_save']);
            $sql_sub = <<<EOF
                UPDATE concert
                SET status = 'checking'
                WHERE concert_id = $concert_id;
            EOF;
            $ret_sub = $db->exec($sql_sub);
            if ($ret_sub) {
                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert">ส่งข้อมูลคอนเสิร์ตเพื่อตรวจสอบเสร็จสิ้น กรุณารอผลการตรวจสอบ<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
            }
            echo '<div class="container">
        
        <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">ข้อมูลคอนเสิร์ต</a>
        </li>';
        if ($row['status'] == 'approved') {
            echo '<li class="nav-item">
                <a class="nav-link" href="each_my_concert_stat.php">ดูข้อมูลการซื้อบัตร</a>
                </li>';
        }else{
            echo '<li class="nav-item">
                <a class="nav-link disabled" aria-disabled="true" href="each_my_concert_stat.php">ดูข้อมูลการซื้อบัตร</a>
                </li>';
        }

        echo '</ul><br>
            <form action="each_my_concert.php" method="post" enctype="multipart/form-data">
            <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                <div class="mb-3">
                    <label for="cname" class="form-label"><b>ชื่อคอนเสิร์ต</b></label>
                    <input type="text" class="form-control" name="cname" value = "' . $row['concert_name'] . '" disabled>
                    <p style="color : red;">' . $row['concert_name_comment'] . '</p><hr>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label"><b>สถานที่จัดคอนเสิร์ต</b></label><br>
                    <textarea name="address" style="width: 100%; height: 100px;" disabled>' . $row['address'] . '</textarea>
                    <p style="color : red;">' . $row['address_comment'] . '</p><hr>
                </div>
                <div class="mb-3">
                    <label for="bdate" class="form-label"><b>วันที่เปิดให้จองบัตรคอนเสิร์ต</b></label>
                    <input type="date" class="form-control" name="bdate" value = "' . $row['open_booking_date'] . '" disabled>
                    <p style="color : red;">' . $row['open_booking_date_comment'] . '</p><hr>
                </div>
                <div class="mb-3">
                    <label for="cdate" class="form-label"><b>วันที่จัดคอนเสิร์ต</b></label>
                    <input type="date" class="form-control" name="cdate" value = "' . $row['show_date'] . '" disabled>
                    <p style="color : red;">' . $row['show_date_comment'] . '</p><hr>
                </div>
                <div class="mb-3">
                    <label for="ctime" class="form-label"><b>เวลาเริ่มคอนเสิร์ต</b></label>
                    <input type="time" class="form-control" name="ctime" value = "' . $row['show_time'] . '" disabled>
                    <p style="color : red;">' . $row['show_time_comment'] . '</p><hr>
                </div>
                <div class="mb-3">
                    <label class="form-label"><b>รายละเอียดคอนเสิร์ต</b></label><br>
                    <textarea name="detail" style="width: 100%; height: 100px;" disabled>' . $row['detail'] . '</textarea>
                    <p style="color : red;">' . $row['detail_comment'] . '</p><hr>
                </div>
                <div class="mb-3">
                    <label for="require" class="form-label"><b>ข้อจำกัดของคอนเสิร์ต</b></label>
                    <input type="require" class="form-control" name="require" value = "' . $row['requirement'] . '" disabled>
                    <p style="color : red;">' . $row['requirement_comment'] . '</p><hr>
                </div>
                <div class="mb-3">
                    <label for="poster_img" class="form-label"><b>โปสเตอร์คอนเสิร์ต</b></label><br>
                    <img src="' . $row['concert_img_path'] . '" style="max-width : 40vw"><br><br>
                    <p style="color : red;">' . $row['concert_img_comment'] . '</p><hr>
                </div>
                <div class="mb-3">
                <label for="con_img" class="form-label"><b>แผนผังคอนเสิร์ต</b></label><br>';

            if (is_null($row['stage_img'])) {
                echo '<p style="color : #808080;">ไม่ได้อัพโหลดแผนผังคอนเสิร์ต</p>';
            } else {
                echo '<img src="' . $row['stage_img'] . '" style="max-width : 40vw"><br><br>';
            }
            echo '<p style="color : red;">' . $row['stage_img_comment'] . '</p><hr>
            </div>

                </div>
                <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                <label class="form-label"><b>บัตรคอนเสิร์ต :</b></label>';
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
                echo '<div class="row">
                <div class="col">
                <label class="form-label">ชื่อบัตร</label>
                    <input type="text" class="form-control" name="tic_name[]"  value = "' . $row3['name'] . '" disabled>
                    </div>
                    <div class="col">
                    <label class="form-label">ราคาบัตร</label>
                    <input type="number" class="form-control" name="tic_price[]"  value = "' . $row3['price'] . '" disabled>
                    </div>
                    <div class="col">
                    <label class="form-label">จำนวนบัตร</label>
                    <input type="number" class="form-control" name="tic_amount[]"  value = "' . $row3['COUNT(detail_id)'] . '" disabled>
                    </div>
                    <div class="col">
                    <label class="form-label">คำอธิบาย</label>
                    <textarea name="tic_detail[]" style="width: 100%; height: 70px;" disabled>' . $row3['description'] . '</textarea>
                    </div>
                    </div>';
            }
            //ticket section end
            echo '<p style="color : red;">' . $row['ticket_comment'] . '</p><hr></div>
                
            <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
            <label class="form-label"><b>ข้อมูลผู้จัดคอนเสิร์ต :</b></label>
                <div class="mb-3">
                    <label for="id_card_img" class="form-label"><b>สำเนาบัตรประชาชนผู้จัดคอนเสิร์ต</b></label><br>
                    <img src="' . $row['copy_id_card_img'] . '" style="max-width : 40vw"><br><br>
                    <p style="color : red;">' . $row['copy_id_card_comment'] . '</p><hr>
                </div>
                <div class="mb-3">
                    <label for="license_img" class="form-label"><b>ใบอนุญาตจัดคอนเสิร์ต</b></label><br>
                    <img src="' . $row['con_permission_img'] . '" style="max-width : 40vw"><br><br>
                    <p style="color : red;">' . $row['con_permission_comment'] . '</p><hr>
                </div>
                
            <div class="mb-3">
                    <label for="bank_acc_name" class="form-label"><b>ชื่อธนาคารรับเงิน</b></label>
                    <input type="text" class="form-control" name="bank_acc_name"  value = "' . $row['bank_name'] . '" disabled>
                    <p style="color : red;">' . $row['bank_name_comment'] . '</p><hr>
                    <label for="bank_acc_number" class="form-label"><b>เลขที่บัญชีธนาคารรับเงิน</b></label>
                    <input type="text" class="form-control" name="bank_acc_number"  value = "' . $row['bank_code'] . '" disabled> 
                    <p style="color : red;">' . $row['bank_code_comment'] . '</p><hr>
                </div></div>
                <div class="">
            <button type="submit" class="btn btn-secondary" name="button" value="edit">Edit</button>
            <button type="submit" class="btn btn-outline-success" name="button" value="save" disabled>Save</button>
            <button type="submit" class="btn btn-';
            if (!isset($_SESSION['count_save'])) {
                echo 'outline-';
            }
            echo 'primary" name="button"  value="submit"';
            if (!isset($_SESSION['count_save'])) {
                echo 'disabled';
            }
            echo '>Submit</button>';
            if ($row['status'] != 'approved') {
                echo '<button type="submit" class="btn btn-danger float-end" name="button" value="delete" >Delete Concert</button>';
            }
            echo '</div></form><br>
            </div>';
        } else if ($_POST['button'] == 'delete') {
            $sql_del = <<<EOF
                DELETE FROM concert
                WHERE concert_id = $concert_id;
            EOF;
            $ret_del = $db->exec($sql_del);
            header("location:my_concert.php");
        }
    }
    ?>
    <footer class="py-3 my-4 ">
        <hr>
        <p class="text-center text-muted">© 2023 TICKCON</p>
    </footer>
</body>

</html>