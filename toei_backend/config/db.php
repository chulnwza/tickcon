<?php
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('tickcon.db');
    }
}

// 2. Open Database 
$db = new MyDB();
?>