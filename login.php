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
         $query = "SELECT * FROM student_info WHERE name = '$name' AND email = '$email' LIMIT 1";
         $result = mysqli_query($connect, $query);

        if($result)
        {
            $user_data = mysqli_fetch_assoc($result);
            if($user_data['password'] == $password)
            {
                $_SESSION['id'] = $user_data['id'];
                $temp = $_SESSION['id'];

                $query = "SELECT 1 FROM information_schema.tables
                 WHERE table_name = '$temp'
                 AND table_schema = 'attendanceTracker' LIMIT 1";
                $result = mysqli_query($connect, $query);

                if($result && mysqli_num_rows($result) > 0)
                {
                    header("Location: attendance_marking.php");
                    die;
                }
                else
                {
                    header("Location: accept_subjects.php");
                    die;
                }
            }
        }
     }
     else
     {
         echo "<script>alert('Please enter valid information')</script>"; 
     }
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <title>Login</title>
</head>
<body>
    <div>
        <form action="login.php" method="POST">
            <div style="font-size: 20px; margin: 10px;">Login</div>
            <input type="text" name="name" placeholder="Name">
            <br>
            <input type="email" name="email" placeholder="EmailID">
            <br>
            <input type="password" name="password" placeholder="Password">
            <br>
            <input id="button" type="submit" value="login">
            <br>
            <br>
            <a href="signup.php" >Click to SignUp</a>
            <br>
            
        </form>
    </div>
    
</body>
</html>