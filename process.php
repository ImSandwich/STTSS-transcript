<!DOCTYPE html>
<html>
<head>
    <title>Welcome Page</title>
</head>
<body>
    <?php 
    $name = $_POST["student_name"];
    $english_marks = $_POST["english_marks"];
    $maths_marks = $_POST["maths_marks"];
    $science_marks = $_POST["science_marks"];

    $host = "localhost";
    $user="root";
    $pass="";
    $db="otsdatabase";

    $connection=new mysqli($host, $user, $pass, $db);
    if ($connection->connect_error == FALSE)
    {
        echo nl2br("Successfully connected to the MySQL Database \r\n");
    }

    $sql_request="INSERT INTO transcript (student_name, english, maths, science) VALUES ('%1s', %2d, %3d, %4d)";

    $sql_request=sprintf($sql_request, $name, $english_marks, $maths_marks, $science_marks);
    echo nl2br($sql_request . "\r\n");
    if ($connection->query($sql_request) == TRUE)
    {
        echo nl2br("Data insertion successful. \r\n");
    }

    $connection->close();

    
    ?>
    <a href="index.php">Return</a>
</body>
</html>