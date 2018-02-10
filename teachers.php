<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $host = "localhost";
    $user="root";
    $pass="";
    $db="otsdatabase";
    $table="teachers";
    $teacher_name = $_POST["teacher_name"];
    $teacher_no = $_POST["teacher_no"];
    
    $connection=new mysqli($host, $user, $pass, $db);
    if ($connection->connect_error)
    {
        echo ("ERROR ENCOUNTERED");
        die();
    }

    $query = "INSERT INTO $table (TEACHER_NO, TEACHER_NAME) VALUES ('$teacher_no', '$teacher_name')";
    if(!$connection->query($query))
    {
        echo ("ERROR INSERTING DATA");
        die();
    }

    $connection->close();
}
?>
<html>
    <head>
        <title>Teachers</title>
    </head>
    <body>
        <?php
            $host = "localhost";
            $user="root";
            $pass="";
            $db="otsdatabase";
            $table="teachers";
        
            $connection=new mysqli($host, $user, $pass, $db);
            if ($connection->connect_error)
            {
                echo ("ERROR ENCOUNTERED");
                die();
            }

            $prelim_check = "CREATE TABLE IF NOT EXISTS $table (ID INT PRIMARY KEY AUTO_INCREMENT, TEACHER_NO VARCHAR(20) NOT NULL UNIQUE, TEACHER_NAME VARCHAR(50) NOT NULL)";
            if(!$connection->query($prelim_check))
            {
                echo ("ERROR CHECKING TABLE");
                die();
            }

            $sql_request="SELECT * FROM $table";
            $result = $connection->query($sql_request);
            echo "<table>";
            echo "<tr><th>Index</th><th>ID</th><th>Name</th></tr>";
            while ($row = $result->fetch_assoc())
            {
                echo  "<tr>". "<td> ". $row['ID'] . "</td>" . "<td> ". $row['TEACHER_NO'] . "</td>" . "<td> ". $row['TEACHER_NAME'] . "</td>" . "</tr>";
            }
            $connection->close();
             
        ?>
        <form method="POST" action="teachers.php">
            <input name="teacher_name" type="text" placeholder="Teacher name"/> <br>
            <input name="teacher_no" type="text" placeholder = "Teacher id"/> <br>
            <input type="submit" value="Submit" />
        </form>
    </body>
</html>