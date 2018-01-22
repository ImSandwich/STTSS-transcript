<html>
    <head>
        <title>Student Data</title>
    </head>
    <body>
        <?php
        $con = new mysqli("localhost", "root","", "otsdatabase");
        if (!$con->connect_error)
        {
            echo "Successfully connected to database.";
        }
        $query = "SELECT * FROM transcript";
        $result = $con->query($query);
        if (!$result){
            die($query);
        }else{
            echo "<table border='1'>
            <tr>
            <th>student_name</th>
            <th>english</th>
            <th>maths</th>
            <th>science</th>
            </tr>";

            while($row = mysqli_fetch_array($result))
            {
                echo "<tr>";
                echo "<td>" . $row['student_name'] . "</td>";
                echo "<td>" . $row['english'] . "</td>";
                echo "<td>" . $row['maths'] . "</td>";
                echo "<td>" . $row['science'] . "</td>";                
                echo "</tr>";
            }
            echo "</table>";
        }
        $con->close();
        ?>
    </body>
</html>