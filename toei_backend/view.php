<?php session_start(); ?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    //cennect to database
    require_once 'config/db.php';
    //member
    echo "<h3>member</h3>";
    $sql = <<<EOF
        SELECT * from user;
        EOF;
    $ret = $db->query($sql);
    while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
        echo $row['email'] . '    ' . $row['pwd'].'<br>';
    }
    //concert
    echo "<h3>concert</h3>";
    $sql = <<<EOF
        SELECT * from concert;
        EOF;
    $ret = $db->query($sql);
    while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
        echo $row['concert_id'].' '.$row['concert_name'] . '    ' . $row['status'].'<br>';
    }
    //ticket
    echo "<h3>ticket</h3>";
    $sql = <<<EOF
        SELECT * from ticket;
        EOF;
    $ret = $db->query($sql);
    while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
        echo $row['ticket_id'] . ' ' . $row['concert_id']. ' ' . $row['amount']. ' ' . $row['cost'].'<br>';
    }

    $db->close();
    ?>
</body>

</html>