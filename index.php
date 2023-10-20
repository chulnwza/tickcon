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
</head>
<body>
<br>
<div class="text-center"><h1>คอนเสิร์ตที่เปิดขาย</h1></div>
<div class="container">
<br>
  <div class="row">
    <?php
    $sql1 = 'SELECT * FROM concert
    WHERE status="approved" AND open_booking_date < "'. date("Y-m-d") . '"' . ' AND show_date > "' . date("Y-m-d") . '"';
    $result = $db->query($sql1);
    while($row = $result->fetchArray(SQLITE3_ASSOC) ) {


    ?>
    <div class="col-sm-3">
      <div class="text-center">
        <img src="toei_backend/<?=$row['concert_img_path']?>" width="200px" height="250" class="mt-5 p-1 my-1 border"> <br>
        <b><?=$row['concert_name']?></b><br>
        <b>Showtime:</b> <?=$row['show_time']?>, <?=$row['show_date']?><br>
        <a class="btn btn-outline-primary" href="sh_product_detail.php?id=<?=$row['concert_id']?>">รายละเอียด</a>
        <a class="btn btn-outline-dark">ซื้อบัตร</a>
      </div>
    <br>
    </div>
    <?php
    }
    $db->close();
    ?>
  </div>
</div>
</body>
</html>