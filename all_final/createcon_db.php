<?php session_start();
ob_start(); ?>

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
            font-weight: 700;
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
                        <a class="nav-link" href="myticket.php">My Tickets</a>
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
                    if(in_array("approved", $status) || in_array("rejected", $status)){
                        echo '<span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger rounded-circle">
                        </span>';
                    }
                    
                    echo '</button>
                    </form>';
                }
                ?>
                <form class="d-flex mb-2 mb-lg-0 me-1" action="createcon_db.php">
                    <button class="btn btn-light" type="submit" style = "background-color: white;">Create Concert</button>
                </form>
                <form class="d-flex mb-2 mb-lg-0" action="index_notlogin.php">
                    <button class="btn btn-outline-danger" type="submit">Log Out</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- code -->
    <a href="index_user.php"><button class="btn btn-secondary">back</button></a>
    <div class="container">
        <h3 class="mt-4">สร้างคอนเสิร์ต</h3>
        <hr>
        <form action="createcon_db.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="cname" class="form-label">ชื่อคอนเสิร์ต</label>
                <input type="text" class="form-control" name="cname">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">สถานที่จัดคอนเสิร์ต</label><br>
                <textarea name="address" style="width: 100%; height: 50px;"></textarea>
            </div>
            <div class="mb-3">
                <label for="bdate" class="form-label">วันที่เปิดให้จองบัตรคอนเสิร์ต</label>
                <input type="date" class="form-control" name="bdate">
            </div>
            <div class="mb-3">
                <label for="cdate" class="form-label">วันที่จัดคอนเสิร์ต</label>
                <input type="date" class="form-control" name="cdate">
            </div>
            <div class="mb-3">
                <label for="ctime" class="form-label">เวลาเริ่มคอนเสิร์ต</label>
                <input type="time" class="form-control" name="ctime">
            </div>
            <div class="mb-3">
                <label class="form-label">รายละเอียดคอนเสิร์ต</label><br>
                <textarea name="detail" style="width: 100%; height: 100px;"></textarea>
            </div>
            <div class="mb-3">
                <label for="require" class="form-label">ข้อจำกัดของคอนเสิร์ต</label>
                <input type="text" class="form-control" name="require">
            </div>
            <div class="mb-3" id="tic_type_add">
                <label class="form-label">ชื่อบัตร</label>
                <input type="text" class="form-control" name="tic_name[]">
                <label class="form-label">ราคาบัตร</label>
                <input type="number" class="form-control" name="tic_price[]">
                <label class="form-label">จำนวนบัตร</label>
                <input type="number" min="0" class="form-control" name="tic_amount[]">
                <label class="form-label">คำอธิบาย</label>
                <textarea name="tic_detail[]" style="width: 100%; height: 70px;"></textarea>
            </div>
            <div class="mb-3">
                <input type="button" onclick="add_type()" value="เพิ่มชนิดบัตร">
            </div>

            <div class="mb-3">
                <label for="poster_img" class="form-label">โปสเตอร์คอนเสิร์ต</label>
                <input type="file" class="form-control" name="poster_img" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="id_card_img" class="form-label">สำเนาบัตรประชาชนผู้จัดคอนเสิร์ต</label>
                <input type="file" class="form-control" name="id_card_img" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="license_img" class="form-label">ใบอนุญาตจัดคอนเสิร์ต</label>
                <input type="file" class="form-control" name="license_img" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="con_img" class="form-label">แผนผังคอนเสิร์ต</label>
                <input type="file" class="form-control" name="con_img" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="bank_acc_name" class="form-label">ชื่อธนาคารรับเงิน</label>
                <input type="text" class="form-control" name="bank_acc_name">
                <label for="bank_acc_number" class="form-label">เลขที่บัญชีธนาคารรับเงิน</label>
                <input type="text" class="form-control" name="bank_acc_number">
            </div>
            <button type="submit" class="btn btn-primary" name="create_con">Submit</button>
        </form>
        <hr>
    </div>
    <?php
    if (isset($_POST['create_con'])) {
        $cname = $_POST['cname'];
        $address = $_POST['address'];
        $bdate = $_POST['bdate'];
        $cdate = $_POST['cdate'];
        $ctime = $_POST['ctime'];
        $tic_name = $_POST['tic_name'];
        $tic_price = $_POST['tic_price'];
        $tic_amount = $_POST['tic_amount'];
        $tic_detail = $_POST['tic_detail'];
        $detail = strval($_POST['detail']);
        $require = $_POST['require'];
        $poster_img = basename($_FILES["poster_img"]["name"]);
        $id_card_img = basename($_FILES["id_card_img"]["name"]);
        $license_img = basename($_FILES["license_img"]["name"]);
        $con_img = basename($_FILES["con_img"]["name"]);
        $bank_acc_name = $_POST['bank_acc_name'];
        $bank_acc_number = $_POST['bank_acc_number'];
        $status = "checking";
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
        if (empty($tic_amount)) {
            $alert_msg .= 'กรุณาระบุจำนวนบัตร\n';
        }
        if (empty($detail)) {
            $alert_msg .= 'กรุณาระบุรายละเอียดคอนเสิร์ต\n';
        }
        if (empty($require)) {
            $alert_msg .= 'กรุณาระบุข้อจำกัดของคอนเสิร์ต หากไม่มีให้ใส่ (-)\n';
        }
        if (empty($poster_img)) {
            $alert_msg .= 'กรุณาอัพโหลดภาพโปสเตอร์คอนเสิร์ต\n';
        }
        if (empty($id_card_img)) {
            $alert_msg .= 'กรุณาอัพโหลดสำเนาบัตรประชาชนผู้จัดคอนเสิร์ต\n';
        }
        if (empty($license_img)) {
            $alert_msg .= 'กรุณาอัพโหลดภาพใบอนุญาตจัดคอนเสิร์ต\n';
        }
        if (empty($bank_acc_name)) {
            $alert_msg .= 'กรุณาระบุชื่อธนาคารรับเงิน\n';
        }
        if (empty($bank_acc_number)) {
            $alert_msg .= 'กรุณาระบุเลขที่บัญชีของธนาคารรับเงิน\n';
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
            $poster_img_path = "upload/poster/" . $poster_img;
            $id_card_img_path = "upload/id_card/" . $id_card_img;
            $license_img_path = "upload/license/" . $license_img;

            if (
                (move_uploaded_file($_FILES["poster_img"]["tmp_name"], $poster_img_path)) &&
                (move_uploaded_file($_FILES["id_card_img"]["tmp_name"], $id_card_img_path)) &&
                (move_uploaded_file($_FILES["license_img"]["tmp_name"], $license_img_path))
            ) {
                $sql2 = <<<EOF
                INSERT INTO concert(concert_name, detail, requirement, status, concert_img_path, open_booking_date, show_date, show_time, copy_id_card_img, con_permission_img, bank_name, bank_code, address, member_id)
                VALUES ('$cname',"$detail",'$require','$status','$poster_img_path','$bdate','$cdate','$ctime','$id_card_img_path','$license_img_path','$bank_acc_name','$bank_acc_number','$address','$member_id');
                EOF;
                $ret2 = $db->exec($sql2);
                if ($ret2) {
                    $sql = <<<EOF
                            SELECT * from concert
                            ORDER BY concert_id DESC;
                            EOF;
                    $ret = $db->query($sql);
                    $row = $ret->fetchArray(SQLITE3_ASSOC);
                    $concert_id = $row['concert_id'];

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
                    for ($i = 0; $i < count($tic_price); $i++) {
                        //store ticket detail in to ticket_detail
                        $sql = <<<EOF
                            INSERT INTO ticket_detail(name,price,description,concert_id)
                            VALUES('$tic_name[$i]',$tic_price[$i],'$tic_detail[$i]','$concert_id');
                            EOF;
                        $ret = $db->exec($sql);
                        $sql = <<<EOF
                            SELECT * from ticket_detail
                            ORDER BY detail_id DESC;
                            EOF;
                        $ret = $db->query($sql);
                        $row = $ret->fetchArray(SQLITE3_ASSOC);
                        for ($j = 0; $j < $tic_amount[$i]; $j++) {
                            //store all ticket into ticket
                            $detail_id = $row["detail_id"];
                            $sql = <<<EOF
                                        INSERT INTO ticket(detail_id)
                                        VALUES('$detail_id');
                                    EOF;
                            $ret = $db->exec($sql);
                        }

                    }
                    echo "<script>alert('Create concert successfully, Please wait for approve the the concert.');</script>";
                    // header('location:index_user.php');
                } else {
                    echo "<script>alert('Can not create concert something went wrong, Please try again. :emsg1');</script>";
                }
            } else { 
                echo "<script>alert('Can not create concert something went wrong, Please try again. :emsg2');</script>";
            }
            $db->close();
        }
    }

    ?>
    <script>
        function add_type() {
            //parent
            let parent = document.getElementById("tic_type_add");
            //price
            let price_label = document.createElement("label");
            price_label.setAttribute("class", "form-label");
            price_label.innerText = "ราคาบัตร";
            let price = document.createElement("input");
            price.setAttribute("type", "number");
            price.setAttribute("class", "form-control");
            price.setAttribute("name", "tic_price[]");
            //amount
            let amount_label = document.createElement("label");
            amount_label.setAttribute("class", "form-label");
            amount_label.innerText = "จำนวนบัตร";
            let amount = document.createElement("input");
            amount.setAttribute("type", "number");
            amount.setAttribute("class", "form-control");
            amount.setAttribute("name", "tic_amount[]");
            amount.setAttribute("min", "0");
            //name
            let tname_label = document.createElement("label");
            tname_label.setAttribute("class", "form-label");
            tname_label.innerText = "ชื่อบัตร";
            let tname = document.createElement("input");
            tname.setAttribute("type", "text");
            tname.setAttribute("class", "form-control");
            tname.setAttribute("name", "tic_name[]");
            //detail
            // <textarea name="tic_detail[]" style="width: 100%; height: 70px;"></textarea>
            let detail_label = document.createElement("label");
            detail_label.setAttribute("class", "form-label");
            detail_label.innerText = "คำอธิบาย";
            let detail = document.createElement("textarea");
            detail.setAttribute("style", "width: 100%; height: 70px;");
            detail.setAttribute("name", "tic_detail[]");
            //hr
            let hr = document.createElement("hr");
            //append child
            parent.appendChild(hr);
            parent.appendChild(tname_label);
            parent.appendChild(tname);
            parent.appendChild(price_label);
            parent.appendChild(price);
            parent.appendChild(amount_label);
            parent.appendChild(amount);
            parent.appendChild(detail_label);
            parent.appendChild(detail);
        }
    </script>
    <!-- footer -->
    <hr>
    <footer class="py-3 my-4 ">
        <p class="text-center text-muted">© 2023 TICKCON</p>
    </footer>
</body>

</html>