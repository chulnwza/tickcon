<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create concert</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <!-- 1)ชื่อคอนเสิร์ต
2)ที่อยู่คอนเสิร์ต
3)สำเนาบัตรประชาชนผู้จัด
4)ใบอนุญาต
5)ภาพเวที
6)ภาพที่จอดรถพร้อมระบบควบคุมการจราจร
8)จำนวนบัตรที่เปิดขาย
9)ราคาบัตร
10)บัญชีรับเงิน -->
    <div class="container">
        <h3 class="mt-4">สร้างคอนเสิร์ต</h3>
        <hr>
        <form action="createcon_db.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="cname" class="form-label">ชื่อคอนเสิร์ต</label>
                <input type="text" class="form-control" name="cname" aria-describedby="cname">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">สถานที่จัดคอนเสิร์ต</label><br>
                <textarea name="address" style="width: 100%; height: 100px;"></textarea>
            </div>
            <div class="mb-3">
                <label for="cdate" class="form-label">วันที่จัดคอนเสิร์ต</label>
                <input type="date" class="form-control" name="cdate" aria-describedby="cname">
            </div>
            <div class="mb-3">
                <label for="ctime" class="form-label">เวลาเริ่มคอนเสิร์ต</label>
                <input type="time" class="form-control" name="ctime" aria-describedby="cname">
            </div>
            <div class="mb-3" id="tic_price_add">
                <label class="form-label">ราคาบัตร</label>
                <input type="text" class="form-control" name="tic_price[]">
                <label class="form-label">จำนวนบัตร</label>
                <input type="number" class="form-control" name="tic_amount[]">
            </div>
            <div class="mb-3">
                <input type="button" name="tic_price_add" onclick="add_price()" value="เพิ่มราคาบัตร">
            </div>
            <div class="mb-3">
                <label class="form-label">รายละเอียดคอนเสิร์ต</label><br>
                <textarea name="detail" style="width: 100%; height: 100px;"></textarea>
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
                <label for="bank_acc_name" class="form-label">ชื่อบัญชีรับเงิน</label>
                <input type="text" class="form-control" name="bank_acc_name">
                <label for="bank_acc_number" class="form-label">เลขที่บัญชีรับเงิน</label>
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
            $cdate = $_POST['cdate'];
            $ctime = $_POST['ctime'];
            $tic_price = $_POST['tic_price'];
            $tic_amount = $_POST['tic_amount'];
            $detail = $_POST['detail'];
            $poster_img = basename($_FILES["poster_img"]["name"]);
            $id_card_img = basename($_FILES["id_card_img"]["name"]);
            $license_img = basename($_FILES["license_img"]["name"]);
            $con_img = basename($_FILES["con_img"]["name"]);
            $bank_acc_name = $_POST['bank_acc_name'];
            $bank_acc_number = $_POST['bank_acc_number'];
            $status = "not approve";
            $alert_msg = "";
            if (empty($cname)) {
                $alert_msg .= 'กรุณาระบุชื่อคอนเสิร์ต\n';
            }
            if (empty($address)) {
                $alert_msg .= 'กรุณาระบุสถานที่จัดคอนเสิร์ต\n';
            }
            if (empty($cdate)) {
                $alert_msg .= 'กรุณาระบุวันที่จัดคอนเสิร์ต\n';
            }
            if (empty($ctime)) {
                $alert_msg .= 'กรุณาระบุเวลาเริ่มคอนเสิร์ต\n';
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
            if (empty($poster_img)) {
                $alert_msg .= 'กรุณาอัพโหลดภาพโปสเตอร์คอนเสิร์ต\n';
            }
            if (empty($id_card_img)) {
                $alert_msg .= 'กรุณาอัพโหลดสำเนาบัตรประชาชนผู้จัดคอนเสิร์ต\n';
            }
            if (empty($license_img)) {
                $alert_msg .= 'กรุณาอัพโหลดภาพใบอนุญาตจัดคอนเสิร์ต\n';
            }
            if (empty($con_img)) {
                $alert_msg .= 'กรุณาอัพโหลดภาพแผนผังคอนเสิร์ต\n';
            }
            if (empty($bank_acc_name)) {
                $alert_msg .= 'กรุณาระบุชื่อบัญชีรับเงิน\n';
            }
            if (empty($bank_acc_number)) {
                $alert_msg .= 'กรุณาระบุเลขที่บัญชีรับเงิน\n';
            }
            if ($alert_msg != "") {
                echo "<script>alert('" . $alert_msg . "');</script>";
            } else {
                echo "<script>alert('Create concert successfully, Please wait for approve the the concert.');</script>";
                //cennect to database
                require_once 'config/db.php';
                //get data...
        
                $poster_img_path = "upload/poster/" . $poster_img;
                $id_card_img_path = "upload/id_card/" . $id_card_img;
                $license_img_path = "upload/license/" . $license_img;
                $con_img_path = "upload/concert_map/" . $con_img;

                $sql = <<<EOF
                INSERT INTO concert(concert_name, detail, status, concert_img_path, show_date, show_time, copy_id_card_img, con_permission_img, stage_img, bank_name, bank_code)
                VALUES('$cname','$detail','$status','$poster_img_path','$cdate','$ctime','$id_card_img_path','$license_img_path','$con_img_path','$bank_acc_name','$bank_acc_number');
                EOF;


                // Upload file to server 
                if (
                    (move_uploaded_file($_FILES["poster_img"]["tmp_name"], $poster_img_path)) &&
                    (move_uploaded_file($_FILES["id_card_img"]["tmp_name"], $id_card_img_path)) &&
                    (move_uploaded_file($_FILES["license_img"]["tmp_name"], $license_img_path)) &&
                    (move_uploaded_file($_FILES["con_img"]["tmp_name"], $con_img_path))
                ) {
                    // Insert image file name into database 
                    $ret = $db->exec($sql);
                    //get concert_id
                    $sql = <<<EOF
                    SELECT * from concert
                    ORDER BY concert_id DESC;
                    EOF;
                    $ret = $db->query($sql);
                    $row = $ret->fetchArray(SQLITE3_ASSOC);
                    $c_id = $row['concert_id'];
                    //store ticket cost and amount into db
                    for($i = 0; $i < count($tic_price) ; $i++){
                        $sql = <<<EOF
                        INSERT INTO ticket(concert_id,cost,amount)
                        VALUES('$c_id','$tic_price[$i]','$tic_amount[$i]');
                        EOF;
                        $ret = $db->exec($sql);
                    }
                    
                }
                $db->close();
            }
        }
    ?>
    <script>
        function add_price() {
            //parent
            let parent = document.getElementById("tic_price_add");
            //price
            let price_label = document.createElement("label");
            price_label.setAttribute("class", "form-label");
            price_label.innerText = "ราคาบัตร";
            let price = document.createElement("input");
            price.setAttribute("type", "text");
            price.setAttribute("class", "form-control");
            price.setAttribute("name", "tic_price[]");
            //amount
            let amount_lable = document.createElement("label");
            amount_lable.setAttribute("class", "form-label");
            amount_lable.innerText = "จำนวนบัตร";
            let amount = document.createElement("input");
            amount.setAttribute("type", "number");
            amount.setAttribute("class", "form-control");
            amount.setAttribute("name", "tic_amount[]");
            //append child
            parent.appendChild(price_label);
            parent.appendChild(price);
            parent.appendChild(amount_lable);
            parent.appendChild(amount);
        }
    </script>
</body>

</html>