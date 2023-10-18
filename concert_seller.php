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
<div class="container">
  <div class="row">
    <?php
    $sql1 = 'SELECT * FROM concert
    WHERE status="Approved"; AND show_date < "'. date("y/m/d") . '";';
    $result = $db->query($sql1);
    while($row = $result->fetchArray(SQLITE3_ASSOC) ) {


    ?>
    <div class="col-sm-3">
      <img src="toei_backend/<?=$row['concert_img_path']?>" width="200px" height="250"> <br>
      <?=$row['concert_name']?> <br>
      <b>Showtime:</b> <?=$row['show_time']?>, <?=$row['show_date']?> <br>
    </div>
    <?php
    }
    $db->close();
    ?>
  </div>
</div>
</body>
</html>