<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lab 10</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
<style>
body {
  font-family: "Audiowide", sans-serif;
}
</style>
    </head>
<?php
class MyDB extends SQLite3 {
    function __construct() {
       $this->open('customers.db');
    }
 }

 // 2. Open Database 
 $db1 = new MyDB();
 if(!$db1) {
    echo $db1->lastErrorMsg();
 } else {
    // echo "Opened database successfully<br>";
 }
    $sql1 = "DELETE FROM customers WHERE CustomerId=(SELECT MAX(CustomerId) FROM customers)";
    $ret = $db1->exec($sql1);
    if(!$ret){
        echo $db1->lastErrorMsg();
    } else {
        echo '<form id="CourseForm" method="get" action="deletedata.php">
        <input type="submit" value="Delete last row">
    </form>';
   $sql = "SELECT * FROM customers";
   echo '<table class="table">  <thead>
   <tr>
   <th scope="col">ID</th>
<th scope="col">Name</th>
<th scope="col">Phone</th>
<th scope="col">Email</th>
</tr>
</thead><tbody>';
$data_array = array();
$ret = $db1->query($sql);
while($row = $ret->fetchArray(SQLITE3_ASSOC) ) {
    echo "<tr>".'<td>'.$row['CustomerId']."</td>";
    array_push($data_array , $row['CustomerId']);
    echo "<td>".$row['FirstName']." ".$row['LastName']."</td>";
    echo "<td>".$row['Phone']."</td>";
    echo "<td>".$row['Email']."</td></tr>";
   }
    }
    echo "</tbody></table>";
    // 4. Close database
    $db1->close();
?>