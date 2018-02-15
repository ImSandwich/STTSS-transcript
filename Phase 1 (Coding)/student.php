
<?php
    session_start();
    $SERVER_HOST = "sql12.freemysqlhosting.net";
    $SERVER_USERNAME = "sql12218230";
    $SERVER_PASSWORD = "X2gGvTDMZH";
    $SERVER_DATABASE = "sql12218230";
    $SERVER_TABLE = "Students"; 
    $SERVER_TABLE_CLASSES = "Classes";
    #students have _reg, _name, _className and _classNo
    $conn = new mysqli($SERVER_HOST, $SERVER_USERNAME, $SERVER_PASSWORD, $SERVER_DATABASE);

    if ($conn->connect_error)
    {
        echo "ERROR#0001";
        $conn->close();
        die();
    }

    if (isset($_GET["class"]))
    {
        $class_name = $_GET["class"];
    }else{
        $class_name = null;
    }

    if (isset($_GET["del"]))
    {
        $del_id = $_GET["del"];
        $query = "DELETE FROM $SERVER_TABLE WHERE _reg='$del_id'";
        $conn->query($query); 
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

        $new_reg = $_POST["new_reg"];
        $new_name = $_POST["new_name"];
        $new_class = $_POST["new_className"];
        $new_index = $_POST["new_classNo"]; #some magic here

        if ($new_reg=="" or $new_name=="" or $new_class=="" or $new_index=="")
        {
            echo "*Please fill up all fields. <br>";
        }
        else
        {
            $query = "INSERT INTO $SERVER_TABLE (_reg, _name, _className, _classNo) VALUES ('$new_reg', '$new_name', '$new_class', '$new_index')";

            if (!$conn->query($query))
            {
                echo "ERROR#0003";
            } 
        }

        
    }
?>

<html>
    <script>
    function onClassSelect()
    {
        var value = document.getElementsByName("class_name")[0].value;
        if (value=="all")
        {
            window.location.href="student.php";            
        }else{
            window.location.href="student.php?class=" + value;            
        }
    }
    </script>
    <head>
        <title>
            UAC
        </title>
    </head>
    <body>
    Select a class: 
    <select name="class_name" onChange="onClassSelect()">
        <option value='all'>All</option>
    <?php
    $query = "SELECT _name from $SERVER_TABLE_CLASSES";
    $res = $conn->query($query);
    while ($row=$res->fetch_array())
    {
        $row_class_name = $row[0];
        if (!empty($class_name) and $row_class_name == $class_name)
        {
            echo "<option value='$row_class_name' selected>$row_class_name</option>";  
        }else{
            echo "<option value='$row_class_name'>$row_class_name</option>";
        }
    }
    ?>
    </select>
        
        <?php
        TableInitialization();
        

        function TableInitialization()
        {
            global $conn;
            global $SERVER_TABLE;
            $query = "CREATE TABLE IF NOT EXISTS $SERVER_TABLE(
                _reg INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                _name VARCHAR(60) UNIQUE NOT NULL,
                _className VARCHAR(10),
                _classNo VARCHAR(100))";

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
            global $class_name;
            if (!empty($class_name))
            {
                $query = "SELECT * FROM $SERVER_TABLE WHERE _className='$class_name'";                
            }else{
                $query = "SELECT * FROM $SERVER_TABLE";                                
            }
            $results = $conn->query($query);

            //PRINT TABLE HEADER
            echo "<tr>
            <th>Reg.</th>
            <th>Name.</th>
            <th>Class</th>
            <th>Class No.</th>
            <th> </th>
            </tr>";

            if ($results->num_rows > 0)
            {
                while($row = $results->fetch_assoc())
                {
                    $_reg = $row["_reg"];
                    echo "<tr>";
                    echo "<td>".$row["_reg"]."</td>";
                    echo "<td>".$row["_name"]."</td>";
                    echo "<td>".$row["_className"]."</td>";
                    echo "<td>".$row["_classNo"]."</td>";
                    echo "<td>" . "<a href='student.php?del=$_reg'>X</a>"."</td>";                                                         
                    echo "</tr>";                 
                }
            }
          
        }
        ?>

        <form method='POST'>
            <table>
                <?php
                TableDisplay();         
                ?>
                <tr>
                <td><input name="new_reg" type="text" hint="Reg."></td>
                <td><input name="new_name" type="text" hint="Name"></td>
                <td><input name="new_className" type="text" hint="Class"
                value = <?php
                if (!empty($class_name))
                {
                    echo $class_name;
                }else{
                    echo "";
                }
                ?>
                />
                <td><input name="new_classNo" type="text" hint="No."></td>              
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