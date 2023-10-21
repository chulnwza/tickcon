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
        .show {
            display: flex;
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
    <a href="index_admin.php"><button class="btn btn-secondary">back</button></a>
    <h4 style="text-align:center">Approve Queue</h4>
    <?php
    require_once 'config/db.php';
    $sql = <<<EOF
    SELECT * from concert
    WHERE status = 'checking';
    EOF;
    $ret = $db->query($sql);
    $count = 0;
    while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
        $count++;
    }
    if ($count > 0) {
        echo "<div class = 'show'>";
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            echo '<div class="card" style="width: 18rem;">
            <img src="' . $row['concert_img_path'] . '" class="card-img-top">
                <div class="card-body">
                <h5 class="card-title">' . $row['concert_name'] . '</h5>
                <p class="card-text">' . $row['show_date'] .' / '. $row['show_time'] . '</p>
                <a href="each_con_check.php?concert_id=' . $row['concert_id'] . '" class="btn btn-primary">see more</a>
                </div>
            </div>';
        }
        echo "</div>";
    } else {
        echo "<p>don't have concert to approve in queue.</p>";
    }
    ?>

</body>

</html>