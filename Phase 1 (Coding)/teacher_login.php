<?php
//TO-DO 
//-Reduce calls to database so that there is only one call to collect all
//
//
//
session_start();

$servername = "sql12.freemysqlhosting.net";
$username = "sql12218230";
$password = "X2gGvTDMZH";
$dbname = "sql12218230";
$conn = new mysqli($servername,$username,$password,$dbname);

if ($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['Username']) &&
	isset($_POST['Password']) &&
	isset($_POST['token']) &&
	!isset($_SESSION['logged_in']))
	{
		if (verifyToken() &&
			verifyUserAndPass())
			{
					$_SESSION['logged_in'] = TRUE;
					$_SESSION['Username'] = $_POST['Username'];
					$_SESSION['UAC'] = getUac();
					$_SESSION['Reg'] = getReg();
					$_SESSION['Subjects'] = getSubjects();
					echo 'Logged in!';
					header("Location: racheltest.php");
					die();

			}
			else
			{						
				header('Location: '. "teacher_login.php?err=0");
				die("Incorrect username/password");
			}
	}

//We want to be logged out	
if (isset($_GET['logout']) &&
	$_GET['logout'] == 'true')
{
	// remove all session variables
	session_unset();

	// destroy the session
	session_destroy();
}

function getSubjects()
{
	global $conn;
	$reg = $conn->real_escape_string($_SESSION['Reg']);
	$sql = "SELECT * FROM Subjects WHERE _teacherReg='" . $reg . "'";
	$result = $conn->query($sql);
	
	if ($result === FALSE)
	{
		header('Location: '. "teacher_login.php?err=1");
		die("Incorrect username/password");
	}
	
	$my_subjects = '';
	
    while ($row = $result->fetch_assoc())
	{
		$my_subjects += $row['_subjectName'] . ", ";
	}
	$my_subjects = substr($my_subjects,0,-2);
	return $my_subjects;
}

function getReg()
{
	global $conn;
	$username = $conn->real_escape_string($_SESSION['Username']);
	$sql = "SELECT _reg FROM Teachers WHERE _name='" . $_SESSION['Username'] . "'";
	$result = $conn->query($sql);
	
	if ($result === FALSE)
	{
		header('Location: '. "teacher_login.php?err=1");
		die("Incorrect username/password");
	}
	
    $row = $result->fetch_assoc();
	return $row['_reg'];
}

function getUac()
{
	global $conn;
	$username = $conn->real_escape_string($_SESSION['Username']);
	$sql = "SELECT _UAC FROM Teachers WHERE _name='" . $username . "'";
	$result = $conn->query($sql);
	
	if ($result === FALSE)
	{
		header('Location: '. "teacher_login.php?err=1");
		die("Incorrect username/password");
	}
	
    $row = $result->fetch_assoc();
	return $row['_UAC'];
}

function verifyToken(){
	//TO-DO 
	//verify $_POST['token']
	return TRUE;
}

function verifyUserAndPass() {
	global $conn;
	
	$username = $conn->real_escape_string($_POST['Username']);
	$username = $_POST['Username'];
	$sql = "SELECT _password FROM Teachers WHERE _name='".$username . "'";
	$result = $conn->query($sql);
	if ($result === FALSE)
	{
		header('Location: '. "teacher_login.php?err=0");
		die("Incorrect username/password");
	}
    $row = $result->fetch_assoc();
	//if (password_verify($_POST['Password'],$row['_password']))
	if ($_POST['Password'] == $row['_password'])
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}
?>

<!DOCTYPE HTML>

<HTML>
<head>
<title>STTSS Transcript</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="stylesheets/userform.css">
</head>
<body>
<div class="loginbox">
<form action="teacher_login.php" method="post">
	<label id="Label2">Username:</label><input name="Username" type="text"><br>
	<label id="Label1">Password:</label><input name="Password" type="password"><br>
	<input type="hidden" name="token" value="ioqwenf4uequi2213r4gufsddHUEWTI3q0w9edr4jewJIWT93"><br>
	<input name="Submit1" type="submit" value="submit"></form>
	<?php if (isset($_GET['err']) && $_GET['err'] == 0): ?>
  Incorrect username/password! <br>
	<?php endif; ?>
	<?php if (isset($_GET['err']) && $_GET['err'] == 1): ?>
  Failed to get UAC! <br>
	<?php endif; ?>
	<?php if (isset($_SESSION['logged_in'])): ?>
  You are logged in! <br>
  UAC : <?php echo $_SESSION['UAC'] ?> <br>
  Reg : <?php echo $_SESSION['Reg'] ?> <br>
  You Teach : <?php echo $_SESSION['Subjects'] ?> <br>
	<?php endif; ?>
<a href="teacher_login.php?logout=true">Log Out</a>
</div>
</body>
</HTML>
