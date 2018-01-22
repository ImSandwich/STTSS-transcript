<html>
<head>
    <title>SQL Test </title>    
</head>
<body>
    Welcome to the Online Transcript System!
    <form id="form1" action="process.php" method="POST">
        Name:<input name="student_name" type="text"> <br>
        English:<input name="english_marks" type="number"> <br>
        Maths:<input name="maths_marks" type="number"> <br>
        Science:<input name="science_marks" type="number"> <br>
        
    </form>
    <button name="add_button" value="add_button" onclick="add_field()">Add more</button>
    <button name="submit_button" form="form1" type="submit" value="Submit">Submit</button>
    <p>
    Click here to view the
    <a href="view.php"> student data.</a>
    </p>
    <script>
        var subjectList = ["English", "Maths", "Physics", "Biology", "Chemistry", "Accounts", "Moral", "BM", "Sejarah", "C. History", "Chinese", 
        "KHB", "Add Maths I", "Add Maths II", "Civic", "Bookkeeping", "Science"];
        subjectList.sort();
        function change_detection()
        {
            alert("Change detected");
        }
        function add_field(){
            //alert(subjectList.toString())
            var new_dropdown = document.createElement("select");
            for(var i = 0; i < subjectList.length; i++)
            {
                var opt1 = document.createElement("option");
                var node1 = document.createTextNode(subjectList[i]);
                opt1.appendChild(node1);

                new_dropdown.appendChild(opt1);
            }
            new_dropdown.onchange = function()
            {
                change_detection();
            };
            var new_linebreak = document.createElement("br");
            var element = document.getElementById("form1");
            element.appendChild(new_dropdown);
            element.appendChild(new_linebreak);
            
        }
      
    </script>
</body>
</html>