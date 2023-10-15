<?php
    session_start();
    include("database.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        if(!empty($name) && !empty($password) && !empty($email))
        {
            $query = "INSERT INTO student_info (name,password,email) 
                      VALUES ('$name','$password','$email')";
            
            mysqli_query($connect, $query);
            header("Location: login.php");
            die;
        }
        else
        {
            echo "<script>alert('Please enter some valid information')</script>"; 
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <title>SignUp</title>
</head>
<body>
    <div>
        <form action="signup.php" method="POST">
            <div style="font-size: 20px; margin: 10px;">SignUp</div>
            <input type="text" name="name" placeholder="Name">
            <br>
            <input type="password" name="password" placeholder="Password">
            <br>
            <input type="email" name="email" placeholder="EmailID">
            <br>
            <input id="button" type="submit" value="SignUp">
            <br>
            <br>
            
            <br>
        </form>
    </div>
    
</body>
</html>