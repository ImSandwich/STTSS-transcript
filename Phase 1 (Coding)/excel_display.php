<?php
if (!empty($_FILES["excel_file"]))
{
    $uploaddir = "uploads\\";
    $uploadpath = $uploaddir . basename($_FILES['excel_file']['name']);

    //Attempt to move uploaded file to a pre-set folder
    move_uploaded_file($_FILES['excel_file']['tmp_name'], $uploadpath);
    echo "<p> Currently reviewing " . basename($_FILES['excel_file']['name']) . " </p>";

    $python = "C:\Users\m7720\AppData\Local\Programs\Python\Python36-32\\python.exe";
    $pyscript = __DIR__ . "\\excel_reader.py";
    echo "$python $pyscript " . $_FILES['excel_file']['name'];
    echo "<br>";
    $res = exec("$python $pyscript " . $_FILES['excel_file']['name'], $output, $return);
    foreach($output as $idv_output)
    {
        show_table($idv_output);
    }
}

function show_table($table)
{
    $sep = explode(":", $table);
    $entries = explode("|", $sep[1]);
    echo "<b>$sep[0]<br>";
    foreach($entries as $entry)
    {
        $boxes = explode(";", $entry);
        foreach($boxes as $box)
        {
            if ($box != ""){
                echo "<input type='text' value='$box'>";                            
            }
        }
        echo "<br>";
    }
}
?>
<html>
    <head>
        <title>Excel Display</title>
    </head>
</html>