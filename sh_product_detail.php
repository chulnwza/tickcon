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
                                            <div class="col-8">
                                                Detail
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
                                            <div class="col-8 align-items-center my-1">
                                                <h6 class="my-0"><?=$row1['name']?></h6>
                                                <?php
                                                $ticket_det1 = $row1['description'];
                                                if (is_null($ticket_det1)){
                                                    $ticket_det1 = '';
                                                }
                                                ?>
                                                <p class="my-0"><small><?=$ticket_det1?></small></p>
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
                            <div class="card-footer border-danger border-2 text-center">
                            <br>
                            <!-- Button trigger modal -->
<!-- Button to Open the Modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
  Buy ticket
</button>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h2 class="modal-title">Buy ticket</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <!-- Modal body -->
      <form id="BuyTicket">
        <div class="container">
      <br>
      <label for="TicketType">เลือกประเภทตั๋ว:</label>
      <select name="TicketType" id="TicketType">
      <?php
    $sql2 = 'SELECT * FROM ticket_detail
    WHERE concert_id= '.$ids.' AND detail_id IN (SELECT detail_id FROM ticket WHERE payment_id IS NULL)';
    $result = $db->query($sql2);
    while($row2 = $result->fetchArray(SQLITE3_ASSOC) ) {
    ?>
    <option value="<?=$row2['name']?>"><?=$row2['name']?></option>
    <?php
}
?>
    </select>
    <div class="form-group">
    <br>
    <label for="card_number"><b>หมายเลขบัตร</b></label>
    <input type="email" class="form-control" id="card_number" placeholder="โปรดใส่หมายเลขบัตร">
    </div>
    <div class="form-group">
    <br>
    <label for="card_owner"><b>ชื่อ-นามสกุล</b></label>
    <input type="email" class="form-control" id="card_owner" placeholder="โปรดใส่ชื่อ-นามสกุล">
    </div>
    <div class="form-group">
    <br>
    <label for="card_month"><b>เดือน</b></label>
    <select name="card_month" id="card_mont">
        <option value="January">มกราคม</option>
        <option value="February ">กุมภาพันธ์</option>
        <option value="March">มีนาคม</option>
        <option value="April">เมษายน</option>
        <option value="May">พฤษภาคม</option>
        <option value="June">มิถุนายน</option>
        <option value="July">กรกฎาคม</option>
        <option value="August">สิงหาคม</option>
        <option value="September">กันยายน</option>
        <option value="October">ตุลาคม</option>
        <option value="November">พฤศจิกายน</option>
        <option value="December">ธันวาคม</option>
    </select>
    <br>
    <div class="form-group">
    <br>
    <label for="card_year"><b>ปี</b></label>
    <input type="year" class="form-control" id="card_year">
    </div>
    <div class="form-group">
    <br>
    <label for="card_cvv"><b>cvv</b></label>
    <input type="cvv" class="form-control" id="card_cvv">
    </div>
    </div>
    </div>
    </form>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
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