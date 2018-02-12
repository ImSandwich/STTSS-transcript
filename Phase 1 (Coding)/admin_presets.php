<?php
    $SERVER_HOST = "sql12.freemysqlhosting.net";
    $SERVER_USERNAME = "sql12218230";
    $SERVER_PASSWORD = "X2gGvTDMZH";
    $SERVER_DATABASE = "sql12218230";
    $SERVER_TABLE = "UAC"; 

    $conn = new mysqli($SERVER_HOST, $SERVER_USERNAME, $SERVER_PASSWORD, $SERVER_DATABASE);
    $privileges = array("Edit Subject Marks", "View Subject Marks", "Edit Conduct Marks", "View Conduct Marks", "Edit CCA Marks", "View CCA Marks");
    if ($conn->connect_error)
    {
        echo "ERROR#0001";
        $conn->close();
        die();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //Check if preset is empty
        if (isset($_POST["new_preset"]))
        {
            $preset_name = $_POST["new_preset"];
            $line = "";
            for ($i = 0; $i< sizeof($privileges); $i++)
            {
                $checked = isset($_POST["new_" . $i]);
                if ($checked)
                {
                    $line = $line . "1";
                }
                else
                {
                    $line = $line . "0";
                }
            }
            $query = "INSERT INTO $SERVER_TABLE (_preset, _privileges) VALUES ('$preset_name', '$line')";
            if (!$conn->query($query))
            {
                echo "ERROR#0002";
                die();
            }
        }
    }
?>
<html>
    <head>
        <title>UAC</title>
    </head>
    <body>
        <a href="admin.php">Back</a><br>
        <form method="POST" action="admin_presets.php">
            <table>
                <tr>
                    <th>Index</th>
                    <th>Preset</th>
                    <th>Privileges</th>  
                </tr>
                <?php
                    TableInitialization();
                    $query = "SELECT * FROM $SERVER_TABLE";
                    $results = $conn->query($query);
                    if ($results->num_rows > 0)
                    {
                        $row_count = 0;
                        while ($row=$results->fetch_assoc())
                        {
                            echo "<tr>";                        
                            echo "<td>".$row["_id"]."</td>";
                            echo "<td>".$row["_preset"]."</td>";
                            echo "<td>";
                            $privileges_array = str_split($row["_privileges"]);                        
                            for ($i = 0; $i < sizeof($privileges); $i++)
                            {
                                $checked = $privileges_array[$i];
                                $checkbox_name = $row_count . "_" . $i;
                                if ($checked == 1)
                                {
                                    echo "<input type='checkbox' name='$checkbox_name' checked='checked' value='true'>$privileges[$i]</input><br>";
                                }else
                                {
                                    echo "<input type='checkbox'name=' $checkbox_name' value='true'>$privileges[$i]</input><br>";                           
                                }
                            }
                            echo "</td>";                        
                            echo "</tr>"; 
                            $row_count = $row_count + 1;                                               
                        }
                    }

                    function TableInitialization()
                    {
                        global $conn;
                        global $SERVER_TABLE;
                        $query = "CREATE TABLE IF NOT EXISTS $SERVER_TABLE(
                            _id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                            _preset VARCHAR(20) UNIQUE NOT NULL,
                            _privileges VARCHAR(20))";
            
                        if (!$conn->query($query))
                        {
                            echo "ERROR#0002";
                            $conn->close();                
                            die();
                        }
                    }
                ?>
                <tr>
                    <td>*</td>
                    <td><input type="text" name="new_preset" /></td>
                    <td>
                        <?php
                        $privileges_array = str_split($row["_privileges"]);                        
                        for ($i = 0; $i < sizeof($privileges); $i++)
                        {
                            echo "<input type='checkbox' name='new_$i' value='true'>$privileges[$i]</input><br>";                           
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <br>
            <input type="submit" value="Submit">
        </form>
        
        
    </body>
</html>