<?php include("header.php")?>

<body>
    <div id="wrapper">
        <h1>Register</h1>
        <?php 
			if(empty($_POST)){
				echo(showRegisterForm());
			}
			else{
				$user = getUserCredentials();
				if(isset($user['badinput'])){
					echo ("something went wrong: " .$user['badinput'] );
				}
				else{
					addUserToDatabase($user);
				}
			}
		?>
    </div>
</body>

</html>

<?php

	function addUserToDatabase($user){

		$id = $user['id'];
		$fname = $user['fname'];
		$sname = $user['sname'];
		$pass = $user['pass'];
		$usertype = $user['usertype'];

		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "testdb";

        $pdo = new pdo('mysql:host=localhost;dbname=testdb', '$username', '$password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        if($pdo === null){
            echo("FAIL");
        }

		// Check for existing id

		if(strtolower($usertype) == 'student'){
			$sql = "SELECT stud_ID FROM student WHERE stud_ID = '$id'" ;	
			$stmt = $pdo->prepare($sql); 
			$stmt->execute();
			while($row = $stmt->fetch()) {
				if($id == $row['stud_ID']){
					echo('<script language="javascript"> alert("Account exists aleady")
						</script>');
					echo(showRegisterForm());
				}
				else{
					$sql2 = "INSERT INTO student (stud_ID, fname, sname, pass)
							VALUES (:id, :fname, :sname, :pass)" ;	
					$stmt2 = $pdo->prepare($sql2); 
					$stmt2->execute([
						'id'=> $id,
						'fname' => $fname,
						'sname' => $sname,
						'pass' => $pass
					]);
					header("Location: login.php");

				}
			}
		}
		else if (strtolower($usertype) == 'staff'){
			$sql = "SELECT staff_ID FROM staff WHERE staff_ID = '$id'" ;	
			$stmt = $pdo->prepare($sql); 
			$stmt->execute();
			while($row = $stmt->fetch()) {
				if($id == $row['staff_ID']){
					echo('<script language="javascript"> alert("Account exists aleady")
						</script>');
					echo(showRegisterForm());
				}
				else{
					$sql2 = "INSERT INTO staff (staff_ID, fname, sname, pass)
							VALUES (:id, :fname, :sname, :pass)" ;	
					$stmt2 = $pdo->prepare($sql2); 
					$stmt2->execute([
						'id'=> $id,
						'fname' => $fname,
						'sname' => $sname,
						'pass' => $pass
					]);
					header("Location: login.php");

				}
			}
		}
	}

	function showRegisterForm(){
		
		return '
		<form method="POST">
			
			<label class="form-label"  for="name">Username</label>
			<input class="form-control"  type="text" name="id" required>

			<label class="form-label" for="name">First Name</label>
			<input class="form-control" type="text" name="fname" required>

			<label class="form-label"  for="name">Surname</label>
			<input class="form-control"  type="text" name="sname" required>

			<label class="form-label"  for="name">Password</label>
			<input class="form-control"  type="password" name="pass" required>		

			<label class="form-label"  for="cname">Confirm Password</label>
			<input class="form-control"  type="password" name="cpassword" required>

			<input type="radio" id="student" name="usertype" value="Student" required>
			<label for="student">Student</label><br>

			<input type="radio" id="staff" name="usertype" value="Staff" required>
			<label for="staff">Staff</label><br>

			<input type="submit" value="Register">

		</form>

		<a href="/app/login.php" >Already have an account? Login now!</a>

		';

	}

	function getUserCredentials(){
		
		$user = array(); 
		if ($_POST['pass'] != $_POST['cpassword']){
			
			$user['badinput'] = "Passwords don't match";
			return $user;
		}

		$user['id'] = $_POST['id'];
		$user['fname'] = $_POST['fname'];
		$user['sname'] = $_POST['sname'];
		$user['pass'] = $_POST['pass'];
		$user['cpassword'] = $_POST['cpassword'];
		$user['usertype'] = $_POST['usertype'];

		return $user;
	}

?>