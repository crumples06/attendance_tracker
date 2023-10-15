<?php
session_start();
include("database.php");
function check_login($connect)
{
    if(isset($_SESSION['name']) && isset($_SESSION['email']) && isset($_SESSION['password']))
    {
        $dbname = $_SESSION['name'];
        $dbemail = $_SESSION['email'];
        $dbpassword = $_SESSION['password'];

        $query = "SELECT * 
                  FROM student_info
                  WHERE name = $dbname
                  AND password = $dbpassword
                  AND email = $dbemail";
        
        $result = mysqli_query($connect, $query);
        if($result)
        {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }
   header("Location: login.php");
    die;
}
?>