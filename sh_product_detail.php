<?php
include 'condb.php'
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickcon</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
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
    </style>
</head>
<body>
<div class="container">
        <!--แยกฝั่งหน้าจอ-->
        <?php
        $ids = $_GET['id'];
        $sql = 'SELECT * FROM concert WHERE concert_id = "'.$ids.'";';
        $result = $db->query($sql);
        $row = $result->fetchArray(SQLITE3_ASSOC);
        ?>
        <div class="row h-100">
            <!--ฝั่งแรกยาว 7/12 ใช้แสดงรูป + description-->
            <div class="col-lg-7 div-1">
                <div class="card my-3 text-center" style="width: 50%;margin: 0 auto;">

                    <img style="width: 100%;" class="card-img"
                        src="toei_backend/<?=$row['concert_img_path']?>">

                </div>

                <h4 class="mt-2" >Description</h4>
                <hr>
                <p><small>
                <?=$row['detail']?>
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
                                <h6 class="card-title"><?=$row['concert_name']?></h6>
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
                                    <li><b>วัน/เวลา</b> <?=$row['show_date']?>, <?=$row['show_time']?></li>
                                    <li><b>สถานที่</b> <?=$row['address']?></li>
                                    <li><b>ข้อกำหนด</b> <?=$row['requirements']?></li>
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
                <?php
    $sql1 = 'SELECT * FROM ticket_detail
    WHERE concert_id= "'.$ids.'";';
    $result = $db->query($sql1);
    while($row1 = $result->fetchArray(SQLITE3_ASSOC) ) {
    ?>
                                        <li class="list-group-item">
                                        <div class="row border border-top-0">
                                            <!--แบ่งเป็น 8/12 ไว้แสดงข้อมูล-->
                                            <div class="col-6 align-items-center my-1">
                                            <h6 class="my-0 fw-bold" id="type"><?=$row1['name']?></h6>
                                                <?php
                                                $ticket_det1 = $row1['description'];
                                                if (is_null($ticket_det1)){
                                                    $ticket_det1 = '';
                                                }
                                                ?>
                                                <small class="text-secondary my-0">'<?=$ticket_det1?></small>
                                            </div>
                                            <div class="col-3 d-flex align-items-center text-center">
                                                <!--ใช้เป็น selected เพราะจะได้เห็นค่าที่เลือก-->
                                                <p class="my-0 fs-6"><?=$row1['price']?></p>
                                            </div>
                                            <div class="col-3 d-flex align-items-center text-center my-1">
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#payment"
                                                data-ticket-name="<?=$row1['name']?>"
                                                data-ticket-description="<?=$row1['description']?>"
                                                data-ticket-price="<?=$row1['price']?>">Buy Now</button>
                                            </div>
                                        </div>
                                    </li>
    <?php
    }
    ?>
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
</body>
</html>