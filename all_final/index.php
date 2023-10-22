<?php
session_start();
if (isset($_SESSION['member_id'])) {
    require_once 'config/db.php';
    $member_id = $_SESSION['member_id'];
    $sql = <<<EOF
    SELECT * from member
    WHERE member_id = $member_id;
    EOF;
    $ret = $db->query($sql);
    $row = $ret->fetchArray(SQLITE3_ASSOC);
    if($row['type'] == 'user'){
        header("location:index_user.php");
    }else{
        header("location:index_admin.php");
    }
}else{
    header("location:login_db.php");
}
?>