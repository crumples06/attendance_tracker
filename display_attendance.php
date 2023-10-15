<?php
    include("database.php");
    session_start();

    $id = 1; 

    $sql = "SELECT * FROM `$id`";
    $result = mysqli_query($connect, $sql);

    if (!$result) 
    {
        die("Error fetching attendance data: " . mysqli_error($connect));
    }

    // Retrieve the list of subjects for this student
    $sql = "SHOW COLUMNS FROM `$id`";
    $result_columns = mysqli_query($connect, $sql);

    $subject_columns = [];
    while ($row = mysqli_fetch_assoc($result_columns)) 
    {

        if ($row['Field'] !== 'id' && $row['Field'] !== 'Date') 
        {
            $subject_columns[] = $row['Field'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <title>View Attendance</title>

</head>
<body>
    <h1>Student Attendance</h1>

    <table>
        <tr>
            <th>Date</th>
            <?php foreach ($subject_columns as $subject): ?>
                <th><?= $subject ?></th>
            <?php endforeach; ?>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['Date'] ?></td>
                <?php foreach ($subject_columns as $subject): ?>
                    <td><?= $row[$subject] === 'Present' ? 'Present' : ($row[$subject] === 'Absent' ? 'Absent' : 'Null') ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php

    mysqli_close($connect);
?>
