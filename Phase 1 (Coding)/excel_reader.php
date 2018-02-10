<html>
    <head>
        <title>Excel Reader</title>
    </head>
    <body>
        <p>Please select an excel file to upload.</p>

        <!-- A form that allows user to upload any file and redirects to file processing page -->
        <form method="post" action="excel_display.php" enctype="multipart/form-data">
            <input type = "file" name = "excel_file" >
            <input type = "submit" value = "Submit">
        </form>

    </body>
</html>