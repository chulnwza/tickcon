<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="test.php" method="post">
        <input type="text" name="t">
        <input type="submit" name="butt">
    </form>

    </form>
    <?php
    if(isset($_POST['butt'])){
        $str = $_POST['t'];
        echo str_replace("'","\'",$str).'<br>';
        echo str_replace("\'","'",$str);
    }
    
    ?>
</body>
</html>