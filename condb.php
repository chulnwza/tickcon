<?php
    session_start();
    class MyDB extends SQLite3 {
       function __construct() {
          $this->open('mainDatabase.db');
       }
    }
 
    // 2. Open Database 
    $db = new MyDB();
    if(!$db) {
       echo $db->lastErrorMsg();
    } else {
       // echo "Opened database successfully<br>";
    }
?>