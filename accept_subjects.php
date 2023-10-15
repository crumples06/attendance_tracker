<?php
    session_start();
    include("database.php");

    $studentID=$_SESSION['id'];
    if(isset($_POST['login']))
    {
        $subject = filter_input(INPUT_POST, "subjects", FILTER_SANITIZE_SPECIAL_CHARS);
        if(!empty($subject))
        {
            $studentSubjects = explode(',', $subject);
            $studentSubjects = array_map('trim', $studentSubjects);

            // sql query to create table
            $sql = "CREATE TABLE IF NOT EXISTS `$studentID` (Date DATE NOT NULL,";
            // adding columns for each subject
            foreach($studentSubjects as $a)
            {
                $sql .=" `$a` VARCHAR(50),";
            }
            $sql = rtrim($sql, ',').")";

            try
            {
                $test = mysqli_query($connect, $sql);
                if(!$test)
                {
                    echo "<script>alert('table not created')</script>";
                }
                else
                {
                    header("Location: attendance_marking.php");
                    die;
                }
            }
            catch(mysqli_sql_exception)
            {
                echo "<script>alert('error in creating table')</script>";
            }
            $connect->close();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <title>Subjects</title>
</head>
<body>
    <form action="accept_subjects.php" method="post">
        <label>Subjects (comma-separated):</label>
        <br>
        <input type="text" name="subjects" required>
        <br>
        <input type="submit" value="login" name="login">
    </form>
</body>
</html>

