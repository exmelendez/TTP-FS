<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Buy Stock</title>
    <link type="text/css" rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Purchase Stock</h1>

    <?php
        //error_reporting(0);
        if(isset($_GET['error'])) {
            if($_GET['error'] == "emptyfields") {
                echo '<p>Fill in all fields!</p>';
            } else if($_GET['error'] == "symbolnotfound") {
                echo '<p>Invalid or Incorrect Symbol!</p>';
            } 
        } else if($_GET['process'] == "success") {   
            echo '<p>Found successful!</p>';
        }
    ?>

    <form action="includes/buy.inc.php" method="post">
        <input type="text" name="symbol" placeholder="Enter Stock Symbol">
        <button type="submit" name="buyBtn">Purchase</button>
    </form>
</body>
</html>