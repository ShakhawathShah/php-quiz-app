<?php
    session_start();
    if(isset($_POST)){

		$quizID = $_SESSION['quizID'];
		$questionNum = $_POST['choice'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "testdb";

        $pdo = new pdo('mysql:host=localhost;dbname=testdb', '$username', '$password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        if($pdo === null){
            echo("FAIL");
        }

        
        $sql = "DELETE FROM questions WHERE question_num = '$questionNum' AND quiz_ID = '$quizID'" ;	

        $stmt = $pdo->prepare($sql); 
        $stmt->execute();
        header("Location: edit_quiz.php");



    }


?>