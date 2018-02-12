<?php
    $SERVER_HOST = "sql12.freemysqlhosting.net";
    $SERVER_USERNAME = "sql12218230";
    $SERVER_PASSWORD = "X2gGvTDMZH";
    $SERVER_DATABASE = "sql12218230";
    $SERVER_TABLE = "Teachers"; 
    $SERVER_TABLE_UAC = "UAC";
    $conn = new mysqli($SERVER_HOST, $SERVER_USERNAME, $SERVER_PASSWORD, $SERVER_DATABASE);

    if ($conn->connect_error)
    {
        echo "ERROR#0001";
        $conn->close();
        die();
    }

    if (isset($_GET["del"]))
    {
        $del_id = $_GET["del"];
        $query = "DELETE FROM $SERVER_TABLE WHERE _id='$del_id'";
        $conn->query($query); 
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

        $new_reg = $_POST["new_reg"];
        $new_name = $_POST["new_name"];
        $new_password = $_POST["new_password"];
        $new_UAC = $_POST["new_UAC"];

        if ($new_reg=="" or $new_name=="" or $new_password=="" or $new_UAC=="")
        {
            echo "*Please fill up all fields. <br>";
        }
        else
        {
            $query = "INSERT INTO $SERVER_TABLE (_reg, _name, _password, _UAC) VALUES ('$new_reg', '$new_name', '$new_password', '$new_UAC')";

            if (!$conn->query($query))
            {
                echo "ERROR#0003";
            } 
        }

        
    }
?>

<html>
    <head>
        <title>
            UAC
        </title>
    </head>
    <body>
    <a href="admin_presets.php">Manage Presets..</a>
        <?php
        TableInitialization();
        

        function TableInitialization()
        {
            global $conn;
            global $SERVER_TABLE;
            $query = "CREATE TABLE IF NOT EXISTS $SERVER_TABLE(
                _id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                _reg INT(10) UNSIGNED UNIQUE NOT NULL,
                _name VARCHAR(60) UNIQUE NOT NULL,
                _password VARCHAR(60) NOT NULL,
                _UAC VARCHAR(100))";

            if (!$conn->query($query))
            {
                echo "ERROR#0002";
                $conn->close();                
                die();
            }
        }

        function TableDisplay()
        {
            global $conn;
            global $SERVER_TABLE;
            $query = "SELECT * FROM $SERVER_TABLE";
            $results = $conn->query($query);

            //PRINT TABLE HEADER
            echo "<tr>
            <th>Index</th>
            <th>Reg.</th>
            <th>Name</th>
            <th>Password</th>
            <th>UAC</th>
            <th> </th>
            </tr>";

            if ($results->num_rows > 0)
            {
                while($row = $results->fetch_assoc())
                {
                    $ID = $row["_id"];
                    echo "<tr>";
                    echo "<td>".$ID."</td>";
                    echo "<td>".$row["_reg"]."</td>";
                    echo "<td>".$row["_name"]."</td>";
                    echo "<td>".$row["_password"]."</td>";
                    echo "<td>".$row["_UAC"]."</td>";
                    echo "<td>" . "<a href='admin.php?del=$ID'>X</a>"."</td>";                                                         
                    echo "</tr>";                 
                }
            }
          
        }
        ?>

        <form method='POST' action='admin.php'>
            <table>
                <?php
                $query = "SELECT _preset from $SERVER_TABLE_UAC";
                $res = $conn->query($query);
                $res_array = array();
                if ($res->num_rows > 0)
                {
                    while ($row=$res->fetch_array())
                    {
                        $res_array[] = $row[0];
                    }
                }
                
                TableDisplay();         
                ?>
                <tr>
                <td>*</td>
                <td><input name="new_reg" type="text" hint="Reg."></td>
                <td><input name="new_name" type="text" hint="Name"></td>
                <td><input name="new_password" type="text" hint="Password"></td>
                <td>
                    <select name="new_UAC"> 
                        <?php
                        foreach($res_array as $selection)
                        {
                            echo "<option value='$selection'>$selection</option>";
                        }
                        ?>
                    </select>
                </td>                
                </tr>
            </table>
            <br>
            <input type="submit" value="Submit">
        </form>

        <?php
            $conn->close();
        ?>

    </body>
</html>