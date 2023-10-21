<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create concert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
    </style>
</head>

<body>
    <a href="my_concert.php"><button class="btn btn-secondary">back</button></a>
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
        <h3 class="mt-4">my concert</h3>
        <hr>
        <form action="createcon_db.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="cname" class="form-label">ชื่อคอนเสิร์ต</label>
                <input type="text" class="form-control" name="cname" value = "' . $row['concert_name'] . '">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">สถานที่จัดคอนเสิร์ต</label><br>
                <textarea name="address" style="width: 100%; height: 100px;">' . $row['address'] . '</textarea>
            </div>
            <div class="mb-3">
                <label for="bdate" class="form-label">วันที่เปิดให้จองบัตรคอนเสิร์ต</label>
                <input type="date" class="form-control" name="bdate" value = "' . $row['open_booking_date'] . '">
            </div>
            <div class="mb-3">
                <label for="cdate" class="form-label">วันที่จัดคอนเสิร์ต</label>
                <input type="date" class="form-control" name="cdate" value = "' . $row['show_date'] . '">
            </div>
            <div class="mb-3">
                <label for="ctime" class="form-label">เวลาเริ่มคอนเสิร์ต</label>
                <input type="time" class="form-control" name="ctime" value = "' . $row['show_time'] . '">
            </div>
            <div class="mb-3" id="tic_type_add">';
    //ticket section start
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
        echo '<label class="form-label">ชื่อบัตร</label>
                <input type="text" class="form-control" name="tic_name[]"  value = "' . $row3['name'] . '">
                <label class="form-label">ราคาบัตร</label>
                <input type="number" class="form-control" name="tic_price[]"  value = "' . $row3['price'] . '">
                <label class="form-label">จำนวนบัตร</label>
                <input type="number" class="form-control" name="tic_amount[]"  value = "' . $row3['COUNT(price)'] . '">
                <label class="form-label">คำอธิบาย</label>
                <input type="text" class="form-control" name="tic_detail[]"  value = "' . $row3['description'] . '">';
    }
    //ticket section end
    echo '</div>
    <div class="mb-3">
                <input type="button" onclick="add_type()" value="เพิ่มชนิดบัตร">
            </div>
            <div class="mb-3">
                <label class="form-label">รายละเอียดคอนเสิร์ต</label><br>
                <textarea name="detail" style="width: 100%; height: 100px;">'.$row['detail'].'</textarea>
            </div>
            <div class="mb-3">
                <label for="require" class="form-label">ข้อจำกัดของคอนเสิร์ต</label>
                <input type="require" class="form-control" name="require" value = "' . $row['requirement'] . '">
            </div>
            <div class="mb-3">
                <label for="poster_img" class="form-label">โปสเตอร์คอนเสิร์ต</label>
                <input type="file" class="form-control" name="poster_img" accept="image/*" value = "' . $row['concert_img_path'] . '">
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
                <label for="bank_acc_name" class="form-label">ชื่อบัญชีรับเงิน</label>
                <input type="text" class="form-control" name="bank_acc_name">
                <label for="bank_acc_number" class="form-label">เลขที่บัญชีรับเงิน</label>
                <input type="text" class="form-control" name="bank_acc_number">
            </div>
            <button type="submit" class="btn btn-primary" name="create_con">Submit</button>
        </form>
        <hr>
    </div>';

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
        $detail = $_POST['detail'];
        $require = $_POST['require'];
        $poster_img = basename($_FILES["poster_img"]["name"]);
        $id_card_img = basename($_FILES["id_card_img"]["name"]);
        $license_img = basename($_FILES["license_img"]["name"]);
        $bank_acc_name = $_POST['bank_acc_name'];
        $bank_acc_number = $_POST['bank_acc_number'];
        $status = "checking";
        $user_id = $_SESSION['user_id']; #อย่าลืมแก้
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
            $poster_img_path = "upload/poster/" . $poster_img;
            $id_card_img_path = "upload/id_card/" . $id_card_img;
            $license_img_path = "upload/license/" . $license_img;

            if ($_FILES["con_img"]["name"] != "") {
                $con_img = basename($_FILES["con_img"]["name"]);
                $con_img_path = "upload/concert_map/" . $con_img;
                if (
                    (move_uploaded_file($_FILES["poster_img"]["tmp_name"], $poster_img_path)) &&
                    (move_uploaded_file($_FILES["id_card_img"]["tmp_name"], $id_card_img_path)) &&
                    (move_uploaded_file($_FILES["license_img"]["tmp_name"], $license_img_path)) &&
                    (move_uploaded_file($_FILES["con_img"]["tmp_name"], $con_img_path))
                ) {
                    $sql = <<<EOF
                        INSERT INTO concert(concert_name, detail, requirement, status, concert_img_path, open_booking_date, show_date, show_time, copy_id_card_img, con_permission_img, stage_img, bank_name, bank_code, address, user_id)
                        VALUES('$cname','$detail','$require','$status','$poster_img_path','$bdate','$cdate','$ctime','$id_card_img_path','$license_img_path','$con_img_path','$bank_acc_name','$bank_acc_number','$address','$user_id');
                        EOF;
                    $ret = $db->exec($sql);
                    if ($ret) {
                        $sql = <<<EOF
                            SELECT * from concert
                            ORDER BY concert_id DESC;
                            EOF;
                        $ret = $db->query($sql);
                        $row = $ret->fetchArray(SQLITE3_ASSOC);
                        $c_id = $row['concert_id'];

                        for ($i = 0; $i < count($tic_price); $i++) {
                            //store ticket detail in to ticket_detail
                            $sql = <<<EOF
                            INSERT INTO ticket_detail(name,price,description)
                            VALUES('$tic_name[$i]',$tic_price[$i],'$tic_detail[$i]');
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
                                        INSERT INTO ticket(concert_id,detail_id)
                                        VALUES('$c_id','$detail_id');
                                    EOF;
                                $ret = $db->exec($sql);
                            }

                        }
                        echo "<script>alert('Create concert successfully, Please wait for approve the the concert.');</script>";
                        header('location:index_user.php');
                    } else {
                        echo "<script>alert('1Can not create concert something went wrong, Please try again.');</script>";

                    }
                } else {
                    echo "<script>alert('2Can not create concert something went wrong, Please try again.');</script>";
                }
            } else {
                if (
                    (move_uploaded_file($_FILES["poster_img"]["tmp_name"], $poster_img_path)) &&
                    (move_uploaded_file($_FILES["id_card_img"]["tmp_name"], $id_card_img_path)) &&
                    (move_uploaded_file($_FILES["license_img"]["tmp_name"], $license_img_path))
                ) {
                    $sql = <<<EOF
                        INSERT INTO concert(concert_name, detail, requirement, status, concert_img_path, open_booking_date, show_date, show_time, copy_id_card_img, con_permission_img, bank_name, bank_code, address, user_id)
                        VALUES('$cname','$detail','$require','$status','$poster_img_path','$bdate','$cdate','$ctime','$id_card_img_path','$license_img_path','$bank_acc_name','$bank_acc_number','$address','$user_id');
                        EOF;
                    $ret = $db->exec($sql);
                    if ($ret) {
                        $sql = <<<EOF
                            SELECT * from concert
                            ORDER BY concert_id DESC;
                            EOF;
                        $ret = $db->query($sql);
                        $row = $ret->fetchArray(SQLITE3_ASSOC);
                        $c_id = $row['concert_id'];
                        //store ticket cost and amount into db
                        for ($i = 0; $i < count($tic_price); $i++) {
                            for ($j = 0; $j < $tic_amount[$i]; $j++) {
                                $sql = <<<EOF
                                        INSERT INTO ticket(concert_id,price,name,detail)
                                        VALUES('$c_id','$tic_price[$i]','$tic_name[$i]','$tic_detail[$i]');
                                    EOF;
                                $ret = $db->exec($sql);
                            }
                            echo "<script>alert('Create concert successfully, Please wait for approve the the concert.');</script>";
                            header('location:index_user.php');
                        }
                    } else {
                        echo "<script>alert('3Can not create concert something went wrong, Please try again.');</script>";
                    }
                } else {
                    echo "<script>alert('4Can not create concert something went wrong, Please try again.');</script>";
                }
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
            //name
            let tname_label = document.createElement("label");
            tname_label.setAttribute("class", "form-label");
            tname_label.innerText = "ชื่อบัตร";
            let tname = document.createElement("input");
            tname.setAttribute("type", "text");
            tname.setAttribute("class", "form-control");
            tname.setAttribute("name", "tic_name[]");
            //detail
            let detail_label = document.createElement("label");
            detail_label.setAttribute("class", "form-label");
            detail_label.innerText = "คำอธิบาย";
            let detail = document.createElement("input");
            detail.setAttribute("type", "text");
            detail.setAttribute("class", "form-control");
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
</body>

</html>