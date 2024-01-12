<?php include("header.php")?>

<body>
    <div id="wrapper">
        <h1>User Login</h1>
        <?php 
			if(isset($_SESSION['user'])){
				if(strtolower($_SESSION['usertype']) == "student"){
					header("Location: student_home.php");
				}
				else{
					header("Location: staff_home.php");
				}
			}

			if(empty($_POST))
			{
				echo(showLoginForm());
			}
			else
			{
				$user = getUserCredentials();
				checkUserLogin($user);
				// header("Location: student_home.php");
			}

		?>
    </div>
</body>


</html>


<?php

	function showLoginForm()
	{
		return '
		<form method="POST">
			
			<label class="form-label"  for="name">Username</label>
			<input class="form-control"  type="text" name="id" required>

			<label class="form-label"  for="name">Password</label>
			<input class="form-control"  type="password" name="pass" required>
			
			<input type="radio" id="student" name="usertype" value="Student" required>
			<label for="student">Student</label><br>

			<input type="radio" id="staff" name="usertype" value="Staff" required>
			<label for="staff">Staff</label><br>

			<input type="submit" value="Login">

		</form>

		<a href="/app/register.php" >Need an account? Register now!</a>
		

		';

	}

	function getUserCredentials()
	{
		$user = array(); 

		$user['id'] = $_POST['id'];
		$user['pass'] = $_POST['pass'];
		$user['usertype'] = $_POST['usertype'];

		return $user;
	}

	function checkUserLogin($user){
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "testdb";

        $pdo = new pdo('mysql:host=localhost;dbname=testdb', '$username', '$password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        if($pdo === null){
            echo("FAIL");
        }

		$id = $user['id'];
		$pass = $user['pass'];
		$usertype = $_POST['usertype'];

		if(strtolower($usertype) == 'student'){
			$sql = "SELECT stud_ID,pass FROM student WHERE stud_ID = '$id'" ;
			
			$stmt = $pdo->prepare($sql); 
			$stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			while($row = $stmt->fetch()) {
				if($pass == $row["pass"] && $id == $row["stud_ID"] ){
					$_SESSION['user'] = $id;
					$_SESSION['usertype'] = $usertype;
					header("Location: student_home.php");
					echo("Connected successfully");
				}
				else{
					echo(showLoginForm());
					echo('<script language="javascript"> alert("incorrect username or password")
						</script>');
				}
			}
		}
		else if (strtolower($usertype) == 'staff'){
			$sql = "SELECT pass FROM staff WHERE staff_ID = '$id'" ;	

			$stmt = $pdo->prepare($sql); 
			$stmt->execute();
			$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
			while($row = $stmt->fetch()) {
				if($pass == $row["pass"]){
					$_SESSION['user'] = $id;
					$_SESSION['usertype'] = $usertype;
					
					header("Location: staff_home.php");
					echo("Connected successfully");
				}
				else{
					echo(showLoginForm());
					echo('<script language="javascript"> alert("incorrect username or password")
						</script>');
				}
			}
		}
		else{
			echo("no type inputted");
		}
	}

?>