<?php
session_start();
require_once 'config/db.php';
?>
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

    <!-- icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- add style -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .div-1 {
            background-color: rgba(0,151,178,0.8);
        }

        h4 {
            color: #FFFFFF;
        }

        * {
            font-family: 'Dosis', sans-serif;
            font-family: 'IBM Plex Sans Thai', sans-serif;
        }

        .navbar-brand {
            
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

        body {
            background-color: #04364A;
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <?php if (isset($_SESSION['member_id'])) { ?>
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
                            <a class="nav-link" href="index_admin.php" style="color:white;">Concerts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="con_waiting_list.php">Pending List</a>

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
                    <form class="d-flex mb-2 mb-lg-0" action="index_notlogin.php">
                        <button class="btn btn-outline-danger" type="submit">Log Out</button>
                    </form>
                </div>
            </div>
        </nav>
    <?php } ?>
    <?php if (!isset($_SESSION['member_id'])) { ?>
        <nav class="navbar navbar-expand-md sticky-top shadow p-2 mb-5 " style="background-color : #0097B2">
            <div class="container-fluid">
                <a class="navbar-brand" href="index_notlogin.php">
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
                                <a class="nav-link" href="index_notlogin.php">Home</a>
                            </li> -->
                        <li class="nav-item">
                            <a class="nav-link " href="index_notlogin.php" style="color:white;">Concerts</a>
                        </li>
                    </ul>
                    <form class="d-flex mb-2 mb-lg-0 me-1" action="signup_db.php">
                        <button class="btn btn-outline-light" type="submit">Sign Up</button>
                    </form>
                    <form class="d-flex mb-2 mb-lg-0" action="login_db.php">
                        <button class="btn btn-outline-light" type="submit">Log In</button>
                    </form>
                </div>
            </div>
        </nav>
    <?php } ?>
        <!-- code -->
        <div class="container">
    <?php
    if (isset($_POST['confirm'])) {
        $member_id = $_SESSION['member_id'];
        $number = $_POST['credit_number'];
        $name = $_POST['credit_name'];
        $month = $_POST['credit_month'];
        $year = $_POST['credit_year'];
        $cvv = $_POST['credit_cvv'];
        $detail_id = $_POST['detail_id'];
        $alert_text = '';
        if (empty($number)) {
            $alert_text .= 'กรุณากรอกเลขบัตรเครดิต';
        }
        elseif (empty($name)) {
            $alert_text .= 'กรุณากรอกเลขชื่อ-นามสกุลผู้ถือบัตร';
        }
        elseif (empty($month)) {
            $alert_text .= 'กรุณากรอกเดือนที่บัตรหมดอายุ';
        }
        elseif (empty($year)) {
            $alert_text .= 'กรุณากรอกปีที่บัตรหมดอายุ';
        }
        elseif (empty($cvv)) {
            $alert_text .= 'กรุณากรอกรหัสรักษาความปลอดภัยของบัตร';
        }
        elseif ($month > 12) {
            $alert_text .= 'กรุณากรอกเดือนที่หมดอายุตามความเป็นจริง';
        }
        elseif ($year < date("Y")) {
            $alert_text .= 'กรุณากรอกปีที่หมดอายุให้ไม่น้อยกว่าปัจจุบัน';
        }
        if ($alert_text != "") {
            echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                ' . $alert_text . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
        } else {
            #หาว่าตั๋ว id ที่น้อยที่สุดคือ id ที่เท่าไหร่
            $sql_find = <<<EOF
            SELECT ticket_id
            FROM ticket
            WHERE detail_id = $detail_id
            AND payment_id IS NULL
            ORDER BY ticket_id ASC
            LIMIT 1;
            EOF;
            $ret = $db->query($sql_find);
            $row = $ret->fetchArray(SQLITE3_ASSOC);
            $current_id = $row['ticket_id'];

            $sql_insert_paymemt = <<<EOF
            INSERT INTO payment(member_id, card_number, card_holder, month, year, CVV)
            VALUES ($member_id, $number, '$name', $month, $year, $cvv);
            EOF;
            $ret_insert_payment = $db->exec($sql_insert_paymemt);

            $sql_get_payment_id = <<<EOF
            SELECT payment_id
            FROM payment
            ORDER BY payment_id DESC
            LIMIT 1;
            EOF;
            $ret_payment_id = $db->query($sql_get_payment_id);
            $row = $ret_payment_id->fetchArray(SQLITE3_ASSOC);
            $payment_id = $row['payment_id'];

            $sql_update_ticket = <<<EOF
            UPDATE ticket
            SET payment_id = $payment_id
            WHERE ticket_id = $current_id;
            EOF;
                $ret_update_ticket = $db->exec($sql_update_ticket);
                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert">ชำระเงินเสร็จสิ้น สามารถดูบัตรคอนเสิร์ตได้ในหน้า <a href="myticket.php" style="text-decoration:none;">My Tickets</a><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
        }
    }
    ?>
        <!--แยกฝั่งหน้าจอ-->
        <?php
        $ids = $_GET['id'];
        $sql = 'SELECT * FROM concert WHERE concert_id = "' . $ids . '";';
        $result = $db->query($sql);
        $row = $result->fetchArray(SQLITE3_ASSOC);
        ?>
        <div class="row mt-0">
            <!--ฝั่งแรกยาว 7/12 ใช้แสดงรูป + description-->
            <div class="col-lg-7 div-1 shadow-lg p-3 mb-3  rounded">
                <div class="card my-3 text-center" style="width: 50%;margin: 0 auto;">

                    <img style="width: 100%;" class="card-img shadow-lg rounded" src="<?= $row['concert_img_path'] ?>">

                </div>
                <h4 class="mt-2" style="color:White;"><b>Description</b></h4>
                <hr>
                <small style="white-space: pre-line; color:White;" class="text-break">
                    <?= $row['detail'] ?>
                </small>
                <div class="card my-3 text-center"
                    style="width: 50%;margin: 0 auto;<?php if (is_null($row['stage_img']) == TRUE) {
                        echo 'display:none;';
                    } ?>">

                    <img style="width: 100%;" class="card-img" src="<?= $row['stage_img'] ?>">

                </div>
                <?php
            $sqlj = 'SELECT firstname, lastname FROM member WHERE member_id = "' . $row['member_id'] . '";';
            $resultj = $db->query($sqlj);
            $rowj = $resultj->fetchArray(SQLITE3_ASSOC);
            ?>
                <h4 class="mt-2" style="color:White;"><b>Concert Organizer</b></h4>
                <hr>
                <h4><?= $rowj['firstname'] ?> <?= $rowj['lastname'] ?><h4>
                <!-- ชื่อผู้จัด -->
            </div>
            <!--ฝั่งสองยาว 5/12 ใช้แสดงรายละเอียดสำคัญและการจองตัว-->
            <div class="col-lg-5">
                <!--แบ่งเป็นแถวๆเพื่อง่ายต่อการจัดระเบียบ-->
                <div class="row">
                    <!--แถวแรกเต็มแสดงชื่อคอนเสิร์ต-->
                    <div class="col-12 mb-2">
                        <div class="card  shadow-lg rounded">
                            <div class="card-body text-center">
                                <h6 class="card-title mb-0 fw-bold fs-5">
                                    <?= $row['concert_name'] ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!--แถวสองแบ่งเป็น 8/12 4/12-->
                <div class="row ">
                    <!--ใช้แสดงวัน เวลา สถานที่ ข้อกำหนด-->
                    <div class="col-12">
                        <div class="card h-100 shadow-lg rounded">
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li><b><i class="bi bi-clock"></i>&nbsp;</b>
                                        <?php echo date('l d F Y', strtotime($row['show_date'])); ?>,
                                        <?= $row['show_time'] ?>
                                    </li>
                                    <li><b><i class="bi bi-geo-alt"></i>&nbsp;</b>
                                        <?= $row['address'] ?>
                                    </li>
                                    <li><b><i class="bi bi-geo-alt"></i>&nbsp;</b>
                                    <a href ="<?= $row['lo_link']?>" target="_blank">Google Map</a>
                                    </li>
                                    <li><b><i class="bi bi-exclamation-circle-fill"></i>&nbsp;</b>
                                        <?= $row['requirement'] ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!--แถวสามเต็มแถว ใช้แสดงประเภทตั๋ว-->
                <div class="row mt-2">
                    <div class="col-12">
                        <!--ใช้รูปแบบ card เพราะเป็นกรอบมาให้ แบ่งหัวท้ายง่าย-->
                        <div class="card border-info border mb-4">
                            <!--ส่วนหัว-->
                            <p class="card-header border-info border-2 shadow-lg">ประเภทตั๋วที่จำหน่าย</p>
                            <!--ส่วนเนื้อหา-->
                            <div class="card-body pb-0 shadow-lg rounded ">
                                <!--ใช้ list เพราะจะได้แสดงเป็นประเภทๆ ได้สะดวก-->
                                <ul class="list-unstyled list-group-light align-middle">
                                    <!--ในแต่ละข้อมูลจะแบ่งเป็นซ้ายขวาอีกทีนึง-->
                                    <li class="list-group-item">
                                        <!--สร้างแถว ที่มีกรอบมนด้านบน-->
                                        <div class="row border rounded-top">
                                            <!--แบ่งเป็น 8/12 ไว้แสดงข้อมูล-->
                                            <div class="col-6 my-2">
                                                <p class="fw-bold fs-6 my-0">Detail</p>
                                            </div>
                                            <div class="col-3 my-2">
                                                <p class="fw-bold fs-6 my-0">Price</p>
                                            </div>
                                    </li>
                                    <?php
                                    $sql1 = 'SELECT *, count(detail_id) `amount_each`
                                    FROM (SELECT detail_id, name, description, price, payment_id, amount
                                    FROM ticket_detail
                                    JOIN ticket
                                    USING (detail_id)
                                    WHERE concert_id= ' . $ids . ')
                                    GROUP by detail_id, payment_id IS NULL;';
                                    $result1 = $db->query($sql1);
                                    while ($row1 = $result1->fetchArray(SQLITE3_ASSOC)) {
                                        if ((is_null($row1['payment_id']) == TRUE) || ((is_null($row1['payment_id']) == FALSE) && ($row1['amount'] == $row1['amount_each']))) {
                                            ?>
                                            <li class="list-group-item">
                                                <div class="row border border-top-0">
                                                    <div class="col-6 align-items-center my-1">
                                                        <h6 class="my-0 fw-bold" id="type">
                                                            <?= $row1['name'] ?>
                                                        </h6>
                                                        <?php
                                                        $ticket_det1 = $row1['description'];
                                                        if (is_null($ticket_det1)) {
                                                            $ticket_det1 = '';
                                                        }
                                                        ?>
                                                        <small class="text-secondary my-0">
                                                            <?= $ticket_det1 ?>
                                                        </small>
                                                    </div>
                                                    <div class="col-3 d-flex align-items-center text-center">
                                                        <p class="my-0 fs-6">
                                                            <?= $row1['price'] . '฿' ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-3 d-flex align-items-center text-center my-1">

                                                        <button type="button" class="btn btn-danger border-0"
                                                            data-bs-toggle="modal" data-bs-target="#payment"
                                                            data-ticket-name="<?= $row1['name'] ?>"
                                                            data-ticket-description="<?= $row1['description'] ?>"
                                                            data-ticket-price="<?= $row1['price'] ?>฿"
                                                            data-ticket-detail-id="<?= $row1['detail_id'] ?>" <?php
                                                              if ((is_null($row1['payment_id']) == FALSE) && ($row1['amount'] == $row1['amount_each'])) {
                                                                  echo 'style="background-color:black;" disabled> Sold Out </button>';
                                                              } else {
                                                                  echo ' disabled>Buy Now</button>';
                                                              }
                                                              ?> </div>
                                                    </div>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <div class="modal fade" id="payment" tabindex="-1" role="dialog"
                                        aria-labelledby="Title" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <!--ส่วนหัว-->
                                                <div class="modal-header">
                                                    <p class="modal-title fw-bold fs-6" id="Title">Buy ticket</p>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                    </button>
                                                </div>
                                                <!--ส่วนฟอร์ม-->
                                                <div class="modal-body">
                                                    <div class="card mb-4">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <img class="rounded rounded-4 border border-3 border-dark w-100"
                                                                        src="<?= $row['concert_img_path'] ?>"
                                                                        id="buying-poster" alt="poster">
                                                                </div>
                                                                <div class="col-8 d-flex align-items-center">
                                                                    <ul class="list-unstyled">
                                                                        <li class="mb-2">
                                                                            <p class="my-0 fw-bold">ประเภทที่นั่ง:&nbsp;
                                                                            </p><span id="modal-ticket-name"></span>
                                                                        </li>
                                                                        <li class="mb-2">
                                                                            <p class="my-0 fw-bold">รายละเอียด:&nbsp;
                                                                            </p><span
                                                                                id="modal-ticket-description"></span>
                                                                        </li>
                                                                        <li class="mb-2">
                                                                            <p class="my-0 fw-bold">ราคา:&nbsp;</p><span
                                                                                id="modal-ticket-price"></span>
                                                                        </li>
                                                                        <li class="mb-2">
                                                                            <p class="my-0 fw-bold">วันที่และเวลา:&nbsp;
                                                                            </p>
                                                                            <?= date('l d F Y', strtotime($row['show_date'])); ?>,
                                                                            <?= $row['show_time'] ?>
                                                                        </li>
                                                                        <li class="mb-2">
                                                                            <p class="my-0 fw-bold">สถานที่จัด:&nbsp;
                                                                            </p>
                                                                            <?= $row['address'] ?>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <form
                                                        action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_GET['id']; ?>"
                                                        method="POST">
                                                        <div class="form-floating mb-2">
                                                            <input type="text" class="form-control" id="credit_number"
                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                                placeholder="เลขบัตรเครดิต" name="credit_number">
                                                            <label for="credit_number">เลขบัตรเครดิต</label>
                                                        </div>
                                                        <div class="form-floating mb-2">
                                                            <input type="text" class="form-control" id="credit_name"
                                                                placeholder="ชื่อ-นามสกุลผู้ถือบัตร" name="credit_name">
                                                            <label for="credit_name">ชื่อ-นามสกุลผู้ถือบัตร</label>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-4 col-sm-6">
                                                                <div class="form-floating mb-2">
                                                                    <input type="text" id="form" name="credit_month"
                                                                        class="form-control"
                                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                                        maxlength="2" placeholder="Month"
                                                                        name="credit_month" />
                                                                    <label for="credit_month">MM</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-sm-6">
                                                                <div class="form-floating mb-2">
                                                                    <input type="text" id="form" name="credit_year"
                                                                        class="form-control"
                                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                                        maxlength="4" placeholder="Year"
                                                                        name="credit_year" />
                                                                    <label for="credit_year">YY</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 col-sm-12 text-center">
                                                                <div class="form-floating mb-2">
                                                                    <input type="text" id="form" name="credit_cvv"
                                                                        class="form-control"
                                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                                        maxlength="3" placeholder="CVV"
                                                                        name="credit_cvv" />
                                                                    <label for="credit_cvv">CVV</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--ส่วนท้าย-->
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="detail_id" id="ticket-detail-id">
                                                            <button type="submit" class="btn btn-success"
                                                                name="confirm">Confirm</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- footer -->
    <footer class="py-3 my-4">
        <hr  style="color:white">
        <p class="text-center "  style="color:white">© 2023 TICKCON</p>
    </footer>
</body>
<script>
    $('#payment').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find('#modal-ticket-name').text(button.data('ticket-name'));
        modal.find('#modal-ticket-description').text(button.data('ticket-description'));
        modal.find('#modal-ticket-price').text(button.data('ticket-price'));
        modal.find('#ticket-detail-id').val(button.data('ticket-detail-id'));
    });
</script>

</html>