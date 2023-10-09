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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .container-box {
            text-align: center;
            border: 2px solid grey;
            border-radius: 25px;
            padding: 3%;
        }
        .btn-primary{
            background-color: grey;
        }
    </style>

</head>

<body class="p-5">
    <div class="position-absolute top-50 start-50 translate-middle container-box">
        <form action="signup_db.php" method="post">
            <?php if (isset($_SESSION['error'])) {?>
                <div class="alert alert-danger" role="alert">
                    <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
            <?php }?>
            <?php if (isset($_SESSION['success'])) {?>
                <div class="alert alert-success" role="alert">
                    <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
            <?php }?>
            <?php if (isset($_SESSION['warning'])) {?>
                <div class="alert alert-danger" role="alert">
                    <?php
                        echo $_SESSION['warning'];
                        unset($_SESSION['warning']);
                    ?>
            <?php }?>
            <h1>REGISTER</h1>
            <div class="form-outline mb-4">
                <i class='bx bxs-user trailing' ></i>
                <input type="username" id="form" class="form-control" name='username'/>
                <label class="form-label">Username ( ไม่ต่ำกว่า 5 )</label>
            </div>
            <div class="form-outline mb-4">
                <i class='trailing'>@</i>
                <input type="email" id="form" class="form-control" name='email'/>
                <label class="form-label">Email address ( xx@xx.xx )</label>
            </div>
            <div class="form-outline mb-4">
                <i class='bx bxs-lock-alt trailing'></i>
                <input type="password" id="form" class="form-control" name='password'/>
                <label class="form-label">Password ( ไม่ต่ำกว่า 5 )</label>
            </div>
            <div class="form-outline mb-4">
                <i class='bx bxs-lock-alt trailing'></i>
                <input type="password" id="form" class="form-control" name='c_password'/>
                <label class="form-label">Confirm Password</label>
            </div>
            <button type="submit" class="btn btn-primary btn-block mb-4" name="signup">REGISTER</button>
            <div class="text-center">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
    <?php
    $db->close();
    ?>
</body>

</html>