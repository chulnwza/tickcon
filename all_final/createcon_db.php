<?php session_start();
if(!isset($_SESSION['member_id']) || (isset($_SESSION['type']) && $_SESSION['type'] == 'admin')){
    header('location:index_notlogin.php');
}
ob_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TICKCON</title>
    <!-- google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@500;700&family=IBM+Plex+Sans+Thai:wght@500&family=Mohave:wght@700&display=swap" rel="stylesheet">

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
            font-family: 'IBM Plex Sans Thai', sans-serif;
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

        .btn-outline-danger-1 {
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
        p {
  margin: 25px;
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
                <div class="mb-lg-0 me-3 mt-1">
                    <p style="color:black"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle"
                        viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd"
                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                    </svg>
                        <?= $_SESSION['firstname'] ?>
                    </p>
                </div>
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
                <form class="d-flex mb-2 mb-lg-0" action="index_notlogin.php">
                    <button class="btn btn-outline-danger-1 btn-outline-danger" type="submit">Log Out</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- code -->
    <div class="container" style="width: 80%">
        <h3 class="mt-4">สร้างคอนเสิร์ต</h3>
        <hr>
        <?php
        if (isset($_POST['create_con'])) {
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
            //ticket amount
            $tic_amount = $_POST['tic_amount'];
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
            $status = "checking";
            $member_id = $_SESSION['member_id'];
            $alert_msg = "";
            $lolink = $_POST['lo_link'];

            if (empty($cname)) {
                $alert_msg .= 'กรุณาระบุชื่อคอนเสิร์ต<br>';
            } elseif (empty($address)) {
                $alert_msg .= 'กรุณาระบุสถานที่จัดคอนเสิร์ต<br>';
            } elseif (empty($bdate)) {
                $alert_msg .= 'กรุณาระบุวันที่เปิดให้จองบัตรคอนเสิร์ต<br>';
            } elseif (empty($cdate)) {
                $alert_msg .= 'กรุณาระบุวันที่จัดคอนเสิร์ต<br>';
            } elseif (empty($ctime)) {
                $alert_msg .= 'กรุณาระบุเวลาเริ่มคอนเสิร์ต<br>';
            } elseif (empty($tic_name)) {
                $alert_msg .= 'กรุณาระบุชื่อบัตร<br>';
            } elseif (empty($tic_price)) {
                $alert_msg .= 'กรุณาระบุราคาบัตร<br>';
            } elseif (empty($tic_amount)) {
                $alert_msg .= 'กรุณาระบุจำนวนบัตร<br>';
            } elseif (empty($detail)) {
                $alert_msg .= 'กรุณาระบุรายละเอียดคอนเสิร์ต<br>';
            } elseif (empty($require)) {
                $alert_msg .= 'กรุณาระบุข้อจำกัดของคอนเสิร์ต หากไม่มีให้ใส่ (-)<br>';
            } elseif (empty($poster_img)) {
                $alert_msg .= 'กรุณาอัพโหลดภาพโปสเตอร์คอนเสิร์ต<br>';
            } elseif (empty($id_card_img)) {
                $alert_msg .= 'กรุณาอัพโหลดสำเนาบัตรประชาชนผู้จัดคอนเสิร์ต<br>';
            } elseif (empty($license_img)) {
                $alert_msg .= 'กรุณาอัพโหลดภาพใบอนุญาตจัดคอนเสิร์ต<br>';
            } elseif (empty($bank_acc_name)) {
                $alert_msg .= 'กรุณาระบุชื่อธนาคารรับเงิน<br>';
            } elseif (empty($bank_acc_number)) {
                $alert_msg .= 'กรุณาระบุเลขที่บัญชีของธนาคารรับเงิน<br>';
            } elseif (strtotime($bdate) > strtotime($cdate)) {
                $alert_msg .= 'กรุณากรอกวันที่เปิดจำหน่ายบัตรให้เป็นวันที่ก่อนวันจัดแสดง<br>';
            } elseif (empty($lolink)) {
                $alert_msg .= 'กรุณากรอกลิ้งค์ google map<br>';
            }
            if ($alert_msg != "") {

                echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">' . $alert_msg
                    . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
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
                INSERT INTO concert(concert_name, detail, requirement, status, concert_img_path, open_booking_date, show_date, show_time, copy_id_card_img, con_permission_img, bank_name, bank_code, address, member_id, lo_link)
                VALUES ("$cname","$detail","$require",'$status','$poster_img_path','$bdate','$cdate','$ctime','$id_card_img_path','$license_img_path',"$bank_acc_name",'$bank_acc_number',"$address",'$member_id',"$lolink");
                EOF;
                    $ret2 = $db->exec($sql2);
                    if ($ret2) {
                        //เอา concert_id ล่าสุด
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
        
                            //ticket name replace string for avoid error
                            $tic_name_clean = $tic_name[$i];
                            $tic_name_clean = str_replace('"', '”', $tic_name_clean);
                            $tic_name_clean = str_replace('‘', "'", $tic_name_clean);
                            $tic_name_clean = str_replace('’', "'", $tic_name_clean);
                            //ticket detail replace string for avoid error
                            $tic_detail_clean = $tic_detail[$i];
                            $tic_detail_clean = str_replace('"', '”', $tic_detail_clean);
                            $tic_detail_clean = str_replace('‘', "'", $tic_detail_clean);
                            $tic_detail_clean = str_replace('’', "'", $tic_detail_clean);

                            $sql = <<<EOF
                            INSERT INTO ticket_detail(name,price,description,concert_id,amount)
                            VALUES("$tic_name_clean",$tic_price[$i],"$tic_detail_clean",'$concert_id','$tic_amount[$i]');
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
                        echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert">สร้างคอนเสิร์ตเสร็จสิ้น กรุณารอการตรวจสอบข้อมูล สามารถตรวจสอบตอบกลับจากผู้ตรวจสอบในหน้า <a href="my_concert.php">My Concert</a><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';

                    } else {
                        echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">ไม่สามารถสร้างคอนเสิร์ตได้ กรุณาลองใหม่อีกครั้ง EMSG:1<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';

                    }
                } else {
                    echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">ไม่สามารถสร้างคอนเสิร์ตได้ กรุณาลองใหม่อีกครั้ง EMSG:2<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
                }
                $db->close();
            }
        }

        ?>
        <form action="createcon_db.php" method="post" enctype="multipart/form-data">
            <!-- concert information section -->
            <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                <label class="form-label"><b>ข้อมูลคอนเสิร์ต</b></label>
                <div class="mb-3">
                    <label for="cname" class="form-label">ชื่อคอนเสิร์ต</label>
                    <input type="text" class="form-control" name="cname" placeholder="Concert name">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">สถานที่จัดคอนเสิร์ต</label><br>
                    <textarea name="address" style="width: 100%; height: 50px;" class="form-control"
                    placeholder="Location"></textarea>
                </div>
                <div class="mb-3">
                    <label for="lo_link" class="form-label">ลิ้งค์ google map สถานที่จัดคอนเสิร์ต</label>
                    <input type="text" class="form-control" name="lo_link" placeholder="Google Map link">
                </div>
                <div class="mb-3">
                    <label for="bdate" class="form-label">วันที่เปิดให้จองบัตรคอนเสิร์ต</label>
                    <input type="date" class="form-control" name="bdate" placeholder="Open booking date">
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
                    <textarea name="detail" style="width: 100%; height: 100px;" class="form-control"
                        placeholder="Concert Description"></textarea>
                </div>
                <div class="mb-3">
                    <label for="require" class="form-label">ข้อจำกัดของคอนเสิร์ต</label>
                    <input type="text" class="form-control" name="require"
                        placeholder="Concert requirements (Ex. Must be 18 + or anothers)">
                </div>
                <div class="mb-3">
                    <label for="poster_img" class="form-label">โปสเตอร์คอนเสิร์ต</label>
                    <input type="file" class="form-control" name="poster_img" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="con_img" class="form-label">แผนผังคอนเสิร์ต</label>
                    <input type="file" class="form-control" name="con_img" accept="image/*">
                </div>
            </div>
            <!-- ticket section -->
            <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                <div class="mb-3" id="tic_type_add">
                    <label class="form-label"><b>บัตรคอนเสิร์ต</b></label>
                    <div class="row">
                        <div class="col">
                            <label class="form-label">ชื่อบัตร</label>
                            <input type="text" class="form-control" name="tic_name[]" placeholder="Ticket name">
                        </div>
                        <div class="col">
                            <label class="form-label">ราคาบัตร</label>
                            <input type="number" min="0" class="form-control" name="tic_price[]" placeholder="Price">
                        </div>
                        <div class="col">
                            <label class="form-label">จำนวนบัตร</label>
                            <input type="number" min="0" class="form-control" name="tic_amount[]" placeholder="Amount">
                        </div>
                        <div class="col">
                            <label class="form-label">คำอธิบาย</label>
                            <textarea name="tic_detail[]" style="width: 100%; height: 40px;" class="form-control"
                                placeholder="Ticket description"></textarea>
                        </div>
                        <div class="col">
                            <br>
                            <input type="button" class="btn btn-outline-danger" value="x" style="border-radius: 45%;" disabled>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <input type="button" class="btn btn-secondary" onclick="add_type()" value="เพิ่มชนิดบัตร">
                </div>
            </div>

            <!-- creator section -->
            <div class="shadow p-3 mb-3 bg-body-tertiary rounded">
                <label class="form-label"><b>ข้อมูลผู้จัดคอนเสิร์ต</b></label>
                <div class="mb-3">
                    <label for="id_card_img" class="form-label">สำเนาบัตรประชาชนผู้จัดคอนเสิร์ต</label>
                    <input type="file" class="form-control" name="id_card_img" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="license_img" class="form-label">ใบอนุญาตจัดคอนเสิร์ต</label>
                    <input type="file" class="form-control" name="license_img" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="bank_acc_name" class="form-label">ชื่อธนาคารรับเงิน</label>
                    <input type="text" class="form-control" name="bank_acc_name">
                    <label for="bank_acc_number" class="form-label">เลขที่บัญชีธนาคารรับเงิน</label>
                    <input type="text" class="form-control" name="bank_acc_number">
                </div>
            </div>

            <button type="submit" class="btn btn-info" name="create_con">Submit</button>
        </form>
    </div>

    <script>

        function add_type() {
            // <div class="col">
            // <label class="form-label">ชื่อบัตร</label>
            //         <input type="text" class="form-control" name="tic_name[]" placeholder="Ticket name">
            // </div>
            //         <div class="col">
            //         <label class="form-label">ราคาบัตร</label>
            //         <input type="number" min="0" class="form-control" name="tic_price[]" placeholder="Price">
            //         </div>
            //         <div class="col">
            //         <label class="form-label">จำนวนบัตร</label>
            //         <input type="number" min="0" class="form-control" name="tic_amount[]" placeholder="Amount">
            //         </div>
            //         <div class="col">
            //         <label class="form-label">คำอธิบาย</label>
            //         <textarea name="tic_detail[]" style="width: 100%; height: 40px;" class="form-control" placeholder="Ticket description"></textarea> 
            //         </div>
            //parent
            let parent = document.getElementById("tic_type_add");
            //name
            let div1 = document.createElement("div");
            div1.setAttribute("class", "col");
            let tname_label = document.createElement("label");
            tname_label.setAttribute("class", "form-label");
            tname_label.innerText = "ชื่อบัตร";
            let tname = document.createElement("input");
            tname.setAttribute("type", "text");
            tname.setAttribute("class", "form-control");
            tname.setAttribute("name", "tic_name[]");
            tname.setAttribute("placeholder", "Ticket name");
            div1.appendChild(tname_label);
            div1.appendChild(tname);
            //price
            let div2 = document.createElement("div");
            div2.setAttribute("class", "col");
            let price_label = document.createElement("label");
            price_label.setAttribute("class", "form-label");
            price_label.innerText = "ราคาบัตร";
            let price = document.createElement("input");
            price.setAttribute("type", "number");
            price.setAttribute("class", "form-control");
            price.setAttribute("name", "tic_price[]");
            price.setAttribute("min", "0");
            price.setAttribute("placeholder", "Price");
            div2.appendChild(price_label);
            div2.appendChild(price);
            //amount
            let div3 = document.createElement("div");
            div3.setAttribute("class", "col");
            let amount_label = document.createElement("label");
            amount_label.setAttribute("class", "form-label");
            amount_label.innerText = "จำนวนบัตร";
            let amount = document.createElement("input");
            amount.setAttribute("type", "number");
            amount.setAttribute("class", "form-control");
            amount.setAttribute("name", "tic_amount[]");
            amount.setAttribute("min", "0");
            amount.setAttribute("placeholder", "Amount");
            div3.appendChild(amount_label);
            div3.appendChild(amount);
            //detail
            //<textarea name="tic_detail[]" style="width: 100%; height: 40px;" class="form-control" placeholder="Ticket description"></textarea> 
            let div4 = document.createElement("div");
            div4.setAttribute("class", "col");
            let detail_label = document.createElement("label");
            detail_label.setAttribute("class", "form-label");
            detail_label.innerText = "คำอธิบาย";
            let detail = document.createElement("textarea");
            detail.setAttribute("style", "width: 100%; height: 40px;");
            detail.setAttribute("name", "tic_detail[]");
            detail.setAttribute("class", "form-control");
            detail.setAttribute("class", "form-control");
            detail.setAttribute("placeholder", "Ticket description");
            div4.appendChild(detail_label);
            div4.appendChild(detail);
            
            //hr br
            let hr = document.createElement("hr");
            let br = document.createElement("br");
            let div_all = document.createElement("div");
            div_all.setAttribute("class","row")
            //append child
            div_all.appendChild(div1);
            div_all.appendChild(div2);
            div_all.appendChild(div3);
            div_all.appendChild(div4);

            //remove button
            //<input type="button" class="btn btn-secondary" onclick="add_type()" value="เพิ่มชนิดบัตร">
            let div5 = document.createElement("div");
            div5.setAttribute("class", "col");
            let removeButton = document.createElement('input');
            removeButton.setAttribute("type","button");
            removeButton.setAttribute("class","btn btn-outline-danger");
            removeButton.setAttribute("value","x");
            removeButton.setAttribute("style","border-radius: 45%;");
            removeButton.onclick = function() {
                parent.removeChild(div_all);
            };
            div5.appendChild(br);
            div5.appendChild(br);
            div5.appendChild(removeButton);


            div_all.appendChild(div5);
            parent.appendChild(div_all)
        }
    </script>
    <!-- footer -->
    <footer class="py-3 my-4 ">
        <hr>
        <p class="text-center text-muted">© 2023 TICKCON</p>
    </footer>
</body>

</html>