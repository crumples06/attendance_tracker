<?php

include("database.php");
include("functions.php");
//$user_data = check_login($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home page</title>
</head>
<body>
    hello <?php echo $_SESSION['id']; ?>
</body>
</html>