<?php
session_start();
require_once 'config/db.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickcon</title>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        hr {
            color: brown;
        }

        .div-1 {
            background-color: #80B3FF;
        }

        h4 {
            color: #FFFFFF;
        }

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
                        <a class="nav-link " href="index_user.php" style="color:white;">Concerts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="myticket.php">My Tickets</a>
                    </li>
                </ul>
                <?php
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
                    echo '<form class="d-flex mb-2 mb-lg-0 me-1" action = "my_concert.php">
                    <button class="btn btn-light position-relative" type="submit">My Concert';
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
                <form class="d-flex mb-2 mb-lg-0" action="index_notlogin.php">
                    <button class="btn btn-outline-danger" type="submit">Log Out</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- code -->
    <div class="container">
        <!--แยกฝั่งหน้าจอ-->
        <?php
        $ids = $_GET['id'];
        $sql = 'SELECT * FROM concert WHERE concert_id = "' . $ids . '";';
        $result = $db->query($sql);
        $row = $result->fetchArray(SQLITE3_ASSOC);
        ?>
        <div class="row h-100">
            <!--ฝั่งแรกยาว 7/12 ใช้แสดงรูป + description-->
            <div class="col-lg-7 div-1">
                <div class="card my-3 text-center" style="width: 50%;margin: 0 auto;">

                    <img style="width: 100%;" class="card-img" src="<?= $row['concert_img_path'] ?>">

                </div>

                <h4 class="mt-2">Description</h4>
                <hr>
                <p><small>
                        <?= $row['detail'] ?>
                    </small></p>
            </div>
            <!--ฝั่งสองยาว 5/12 ใช้แสดงรายละเอียดสำคัญและการจองตัว-->
            <div class="col-lg-5 bg-dark">
                <!--แบ่งเป็นแถวๆเพื่อง่ายต่อการจัดระเบียบ-->
                <div class="row">
                    <!--แถวแรกเต็มแสดงชื่อคอนเสิร์ต-->
                    <div class="col-12 mt-3 my-2">
                        <div class="card">
                            <div class="card-body text-center">
                                <h6 class="card-title">
                                    <?= $row['concert_name'] ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!--แถวสองแบ่งเป็น 8/12 4/12-->
                <div class="row">
                    <!--ใช้แสดงวัน เวลา สถานที่ ข้อกำหนด-->
                    <div class="col-8">
                        <div class="card h-100">
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li><b>วัน/เวลา</b>
                                        <?= $row['show_date'] ?>,
                                        <?= $row['show_time'] ?>
                                    </li>
                                    <li><b>สถานที่</b>
                                        <?= $row['address'] ?>
                                    </li>
                                    <li><b>ข้อกำหนด</b>
                                        <?= $row['requirement'] ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--ใช้ว่าเปิดให้จองหรือยัง-->
                    <div class="col-4">
                        <div class="card h-100">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <p class="card-title"><small>เปิดจองหรือยัง</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <!--แถวสามเต็มแถว ใช้แสดงประเภทตั๋ว-->
                <div class="row mt-2">
                    <div class="col-12">
                        <!--ใช้รูปแบบ card เพราะเป็นกรอบมาให้ แบ่งหัวท้ายง่าย-->
                        <div class="card border-danger border">
                            <!--ส่วนหัว-->
                            <p class="card-header border-danger border-2">ประเภทตั๋วที่จำหน่าย</p>
                            <!--ส่วนเนื้อหา-->
                            <div class="card-body">
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
                                    GROUP by detail_id, payment_id;';
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
                                                        <small class="text-secondary my-0">'
                                                            <?= $ticket_det1 ?>
                                                        </small>
                                                    </div>
                                                    <div class="col-3 d-flex align-items-center text-center">
                                                        <p class="my-0 fs-6">
                                                            <?= $row1['price'] ?>
                                                        </p>
                                                    </div>
                                                    <div class="col-3 d-flex align-items-center text-center my-1">

                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                            data-bs-target="#payment" data-ticket-name="<?= $row1['name'] ?>"
                                                            data-ticket-description="<?= $row1['description'] ?>"
                                                            data-ticket-price="<?= $row1['price'] ?>"
                                                            data-ticket-detail-id="<?= $row1['detail_id'] ?>" <?php
                                                            if ((is_null($row1['payment_id']) == FALSE) && ($row1['amount'] == $row1['amount_each'])) {
                                                                echo 'disabled> Sold Out </button>';
                                                            } else {
                                                                echo '>Buy Now</button>';
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
                                                    <form action="" method="POST">
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
    <?php
    $db->close();
    ?>
    <!-- footer -->
    <hr>
    <footer class="py-3 my-4 ">
        <p class="text-center text-muted">© 2023 TICKCON</p>
    </footer>
</body>
<script>
    $('#payment').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find('#modal-ticket-name').text(button.data('ticket-name'));
        modal.find('#modal-ticket-description').text(button.data('ticket-description'));
        modal.find('#modal-ticket-price').text(button.data('ticket-price'));
    });
</script>

</html>