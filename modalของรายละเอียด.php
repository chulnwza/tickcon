<html lang="en">
<?php
include 'condb.php'
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>Document</title>
    <style>
        hr {
            color: brown;
        }
    </style>
</head>

<body>
    <?php
        $ids = 1;
        $sql = 'SELECT * FROM concert WHERE concert_id = "'.$ids.'";';
        $result = $db->query($sql);
        $row = $result->fetchArray(SQLITE3_ASSOC);
        ?>
    <div class="container">
        <!--แยกฝั่งหน้าจอ-->
        <div class="row h-100">
            <!--ฝั่งแรกยาว 7/12 ใช้แสดงรูป + description-->
            <div class="col-lg-7 bg-primary">
                <div class="card my-3 text-center" style="width: 50%;margin: 0 auto;">

                    <img style="width: 100%;" class="card-img"
                        src="toei_backend/upload/poster/8e1a0c16bf0c2cfa3bc131c209051cf5b64a2c46.jpg">

                </div>

                <p class="mt-2 fw-bold fs-4">Description</p>
                <hr>
                <p><small>
                        กติกาการซื้อบัตร <br>
                        - ซื้อบัตรขั้นต่ำ 4 ใบ (สำหรับ 1 โต๊ะ) หากต้องการเพิ่มที่นั่ง ซื้อบัตรเพิ่มหน้างาน 300 บาท
                        เพิ่มได้จำกัดโต๊ะละ 2 ที่ (นั่งสูงสุด 6 คน)
                        - เปิดประตูเปิดให้เข้า 17.00 น. ท่านใดมาก่อนเลือกโต๊ะนั่งได้ก่อน
                        - จำกัดอายุ 20 ปีขึ้นไป โดยใช้บัตรประชาชนหรือใบขับขี่ตัวจริงเท่านั้น เพื่อรับริสแบนด์เข้างาน
                        หากไม่มีไม่สามารถเข้างานได้ทุกกรณี
                        - ก่อนเข้างานเตรียมแสดง QR Code ในแอพ Ticket Melon ให้พร้อม
                        - เมื่อมารับโต๊ะ ต้องทำการเปิดบิลโต๊ะเพื่อรักษาสิทธิ์ และอยู่ประจำโต๊ะ ห้ามวางของจองแล้วไป
                        มาก่อนมีสิทธิ์ได้เลือกโต๊ะก่อน
                        - บัตร Normal ต้องมารับโต๊ะก่อน 21.00
                        - บัตร VIP และ VVIP ไม่ต้องต่อคิว
                        ขอสงวนสิทธิในการเปลี่ยนแปลงกติกาได้ตามสถานการณ์
                    </small></p>

                <img style="width: 50%;" class="mx-auto d-block" src="toei_backend/upload/concert_map/IMG_9614.JPG">

            </div>
            <!--ฝั่งสองยาว 5/12 ใช้แสดงรายละเอียดสำคัญและการจองตัว-->
            <div class="col-lg-5 bg-dark">
                <!--แบ่งเป็นแถวๆเพื่อง่ายต่อการจัดระเบียบ-->
                <div class="row">
                    <!--แถวแรกเต็มแสดงชื่อคอนเสิร์ต-->
                    <div class="col-12 mt-3 my-2">
                        <div class="card">
                            <div class="card-body text-center">
                                <p class="card-title mb-0 fs-4 fw-bold" id="name">Safeplanet ณ บ้านเพื่อนบางแสน</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--แถวสองแบ่งเป็น 8/12 4/12-->
                <div class="row">
                    <!--ใช้แสดงวัน เวลา สถานที่ ข้อกำหนด-->
                    <div class="col-8">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center my-0 pb-0">
                                <ul class="list-unstyled">
                                    <li><small><i class="bi bi-clock"></i> วัน/เวลา</li></small>
                                    <li><small><i class="bi bi-geo-alt"></i> สถานที่</li></small>
                                    <li><small><i class="bi bi-exclamation-circle-fill"></i> ข้อกำหนด</li></small>
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
                        <div class="card border-danger border-2">
                            <!--ส่วนหัว-->
                            <p class="card-header border-danger border-2 fw-bold">ประเภทตั๋วที่จำหน่าย</p>
                            <!--ส่วนเนื้อหา-->
                            <div class="card-body">
                                <!--ใช้ list เพราะจะได้แสดงเป็นประเภทๆ ได้สะดวก-->
                                <ul class="list-unstyled list-group-light align-middle">
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
                                    $sql1 = 'SELECT * FROM ticket_detail
                                    WHERE concert_id= "'.$ids.'";';
                                    $result = $db->query($sql1);
                                    while($row1 = $result->fetchArray(SQLITE3_ASSOC) ) {
                                echo '
                                    
                                    <li class="list-group-item">
                                        <div class="row border border-top-0">
                                            <!--แบ่งเป็น 6/12 ไว้แสดงข้อมูล-->
                                            <div class="col-6 align-items-center my-1">
                                                <h6 class="my-0 fw-bold" id="type">'. $row1['name']. '</h6>
                                                <small class="text-secondary my-0">'
                                                
                                                .$row1['description']. '</small>
                                            </div>
                                            <!--แบ่งเป็น 3/12 ไว้ให้แสดงราคา-->
                                            <div class="col-3 d-flex align-items-center text-center">
                                                <!--ใช้เป็น selected เพราะจะได้เห็นค่าที่เลือก-->
                                                <p class="my-0 fs-6">'. $row1['price'] .' </p>
                                            </div>
                                            <div class="col-3 d-flex align-items-center text-center my-1">
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#payment"
                                                data-ticket-name="'. $row1['name'].'"
                                                data-ticket-description="'. $row1['description'] .'"
                                                data-ticket-price="'.$row1['price'].'">Buy Now</button>
                                            </div>
                                        </div>
                                    </li>';
                                    }
                                    ?>
                                    
                                </ul>
                            </div>
                            <!--ปุ่มที่กดแล้วจะเกิด modal buy ticket-->

                            <!--modal buy ticket-->
                            <div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="Title"
                                aria-hidden="true">
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
                                                                src="toei_backend/<?=$row['concert_img_path']?>" id="buying-poster" alt="poster">
                                                        </div>
                                                        <div class="col-8 d-flex align-items-center">
                                                            <ul class="list-unstyled">
                                                                <li class="d-flex"><p class="fw-bold">ประเภทที่นั่ง:&nbsp;</p><span id="modal-ticket-name"></span></li>
                                                                <li class="d-flex"><p class="fw-bold">รายละเอียด:&nbsp;</p><span id="modal-ticket-description"></span></li>
                                                                <li class="d-flex"><p class="fw-bold">ราคา:&nbsp;</p><span id="modal-ticket-price"></span></li>
                                                                <li class="mb-2"><p class="my-0 fw-bold">วันที่และเวลา:&nbsp;</p><?=date('l d F Y', strtotime($row['show_date']));?>, <?=$row['show_time']?></li>
                                                                <li class="d-flex"><p class="fw-bold">สถานที่จัด:&nbsp;</p><?=$row['address']?></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="test2.php" method="POST">
                                                <div class="form-floating mb-2">
                                                    <input type="text" class="form-control" id="credit_number"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                        placeholder="เลขบัตรเครดิต">
                                                    <label for="credit_number">เลขบัตรเครดิต</label>
                                                </div>
                                                <div class="form-floating mb-2">
                                                    <input type="text" class="form-control" id="credit_name"
                                                        placeholder="ชื่อ-นามสกุลผู้ถือบัตร">
                                                    <label for="credit_name">ชื่อ-นามสกุลผู้ถือบัตร</label>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4 col-sm-6">
                                                        <div class="form-floating mb-2">
                                                            <input type="text" id="form" name="credit_month"
                                                                class="form-control"
                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                                maxlength="2" placeholder="Month" />
                                                            <label for="credit_month">MM</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 col-sm-6">
                                                        <div class="form-floating mb-2">
                                                            <input type="text" id="form" name="credit_year"
                                                                class="form-control"
                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                                maxlength="4" placeholder="Year" />
                                                            <label for="credit_year">YY</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 col-sm-12 text-center">
                                                        <div class="form-floating mb-2">
                                                            <input type="text" id="form" name="credit_cvv"
                                                                class="form-control"
                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                                maxlength="3" placeholder="CVV" />
                                                            <label for="credit_cvv">CVV</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--ส่วนท้าย-->
                                                <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger" name="confirm">Confirm</button>
                                                </div>
                                            </form>


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
    #ยังไม่เสร็จ ทำต่อวันอาทิตย์
    if (isset($_POST['confirm'])) {
        echo '<script>alert("hi");</script>';
    }
    ?>
<script>
    $('#payment').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var modal = $(this);
        modal.find('#modal-ticket-name').text(button.data('ticket-name'));
        modal.find('#modal-ticket-description').text(button.data('ticket-description'));
        modal.find('#modal-ticket-price').text(button.data('ticket-price'));
    });
</script>

</body>
</html>