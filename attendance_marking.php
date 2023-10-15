<?php
    include("database.php");
    session_start();

    $id = $_SESSION['id'];

    $sql = "SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = 'attendanceTracker' 
            AND TABLE_NAME = '$id'
            AND COLUMN_NAME != 'date'";

    $Subjects=mysqli_query($connect, $sql);

    if($Subjects)
    {
        $subjectnames=[];
        while($row = mysqli_fetch_assoc($Subjects))
        {
            $subjectnames[] = $row['COLUMN_NAME'];
            
        }
    }
    else
    {
        die("Error fetching subject names: ".mysqli_error($connect));
    }

    




    // Update attendance in the database

    if (isset($_POST['submit'])) 
    {
        $date = $_POST['date'];
        $sql = "INSERT INTO `$id` (Date";
        $valuesSql = "('$date'";
    
        foreach ($subjectnames as $subject) 
        {
            if (isset($_POST['attendance'][$subject])) 
            {
                $attendanceValue = $_POST['attendance'][$subject];
                $sql .= ", `$subject`";
                $valuesSql .= ", '$attendanceValue'";          
            }
        }
    
        $sql .= ") VALUES $valuesSql)";
    
        try 
        {
            mysqli_query($connect, $sql);
            header("Location: attendance_marking.php");
        } 
        catch (mysqli_sql_exception $e) 
        {
          echo "Error: " . $e->getMessage();
        }
        
    }

    
    $attendancePercentages = [];

    foreach ($subjectnames as $subject) 
    {
        // Counting total classes for the subject
        $sql = "SELECT COUNT(*) as total_classes
                FROM `$id`
                WHERE `$subject` IS NOT NULL";

        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);
        $totalClasses = $row['total_classes'];

        // Count attended classes for the subject
        $sql = "SELECT COUNT(*) as attended_classes
                FROM `$id`
                WHERE `$subject` = 'Present'";
        
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);
        $attendedClasses = $row['attended_classes'];

        // Calculate attendance percentage
        $percentage = ($totalClasses > 0) ? ($attendedClasses / $totalClasses) * 100 : 0;
        
        $attendancePercentages[$subject] = $percentage;
    }
    mysqli_close($connect);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <title>Attendance Marking</title>
</head>
<body>
    <style>

        .form {
            max-width: 400px;
            margin-right: 20%;
        }

        .attendance-marking {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px; 
        }

        .attendance-marking label {
            width: 120px; 
            text-align: right; 

        }
    </style>
    <div class="form">
        <form action="attendance_marking.php" method="post">
            <label for="date">Date:</label>
            <input type="date" name="date" id="date">
            <br>
            <?php
                foreach ($subjectnames as $subject)
                {
                    echo '<div class="attendance-marking">';
                    echo '<label for="' . $subject . '">' . $subject . ':</label>';
                    echo '<input type="radio" name="attendance[' . $subject . ']" value="Present">Present';
                    echo '<input type="radio" name="attendance[' . $subject . ']" value="Absent">Absent';
                    echo '</div>';
                }
            ?>
            <br>
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
<h1>Attendance Percentage</h1>
    <table>
        <tr>
            <th>Subject</th>
            <th>Attendance Percentage</th>
        </tr>
        <?php foreach ($attendancePercentages as $subject => $percentage) : ?>
            <tr>
                <td><?= $subject ?></td>
                <td><?= isset($percentage) ? number_format($percentage, 2) . '%' : 'N/A' ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

