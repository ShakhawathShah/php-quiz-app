<?php include("header.php")?>

<body>
    <div id="wrapper">
        <h1>Create Quiz</h1>
        <?php 
			if(empty($_POST)){
				echo(show_quiz());
			}
			else{
                $user = getQuizDetails();
                addQuizToDatabase($user);
			}
	    ?>


    </div>
</body>

</html>


<?php

	function addQuizToDatabase($user){

		$id = $_SESSION['user'];
		$quizName = $user['quizName'];
		$duration = $user['duration'];
		$score = $user['score'];
		$available = $user['available'];


        $sql = "INSERT INTO quizDetails (staff_ID, quiz_name, duration, total_score)
                VALUES (:id, :quizName, :duration, :score)" ;	
		
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "testdb";

        $pdo = new pdo('mysql:host=localhost;dbname=testdb', '$username', '$password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        if($pdo === null){
            echo("FAIL");
        }

        $stmt = $pdo->prepare($sql); 
		$stmt->execute([
			'id'=> $id,
			'quizName' => $quizName,
			'duration' => $duration,
			'score' => $score
		]);

		// get new quizID
		$sql = "SELECT quiz_ID FROM quizDetails where staff_ID = '$id' AND quiz_name = '$quizName'" ;

        $stmt = $pdo->prepare($sql); 
		$stmt->execute();

		while($row = $stmt->fetch()) {
			$quizID = $row['quiz_ID'];
		}


		// creating student details record for every student
		$sql = "SELECT stud_ID FROM student" ;

        $stmt = $pdo->prepare($sql); 
		$stmt->execute();

		while($row = $stmt->fetch()) {
			$studID = $row['stud_ID'];

			$sql2 = "INSERT INTO studentInfo (stud_ID, quiz_ID, available, date_attempted, score)
					VALUES (:studID, :quizID, :available, :date, :score)" ;	
					
			$date = null;
			$score = null;

			$stmt2 = $pdo->prepare($sql2); 
			$stmt2->execute([
				'studID'=> $studID,
				'quizID'=> $quizID,
				'available' => $available,
				'date' => $date,
				'score' => $score
			]);
		}

		header("Location: edit_quiz.php");


	}

function show_quiz(){

    return '
    <form action="" method="POST">

        <label class="form-label"  for="name">Quiz Name</label>
        <input class="form-control"  type="text" name="quizName">

        <label class="form-label" for="name">Duration</label>
        <input class="form-control" type="text" name="duration">

        <label class="form-label"  for="name">Total Score</label>
        <input class="form-control"  type="text" name="score">

		<label>Quiz Available?</label><br>
		<input type="radio" name="available" value="Yes">
		<label>Yes</label>
		<input type="radio" name="available" value="No">
		<label>No</label><br>

        <input type="submit" value="Create">
        
    </form>

    ';

}

	function getQuizDetails(){
		
		$user = array(); 

		// $user['id'] = $_POST['id'];
		$user['quizName'] = $_POST['quizName'];
		$user['duration'] = $_POST['duration'];
		$user['score'] = $_POST['score'];
		$user['available'] = $_POST['available'];
        
		return $user;
	}


?>