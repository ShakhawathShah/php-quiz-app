<?php include("header.php")?>
<style>
<?php include 'style.css';
?>
</style>

<body>
    <div id="wrapper">
        <?php 

			if(empty($_POST)){
			    echo(showQuestions());
			}
			else{

			}
	    ?>


    </div>
</body>


</html>


<?php

    function showQuestions(){

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "testdb";

        $pdo = new pdo('mysql:host=localhost;dbname=testdb', '$username', '$password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        if($pdo === null){
            echo("FAIL");
        }
        $id = $_SESSION['user'];
        $quizID = $_SESSION['quizID'];
        $quizName = $_SESSION['quizchoice'];
        $correctCounter = $_SESSION['correctCount'];
        
        echo("<h1>Results for Quiz: $quizName</h1><br>");

        $sql = "SELECT * FROM studentInfo WHERE stud_ID = '$id' AND quiz_ID = '$quizID' " ;	

        $stmt = $pdo->prepare($sql); 
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while($row = $stmt->fetch()) {
            $date = $row['date_attempted'];
            $score = $row['score'];
        }

        echo("<p>Well Done! You answered ". $correctCounter . " questions correctly!");
        echo("<p>Your Score: $score</p>");
        echo("<p>Date Attmpted: $date</p>");
        echo("<br><a href='/app/student_home.php'><input type='button' value='Return Home'></a>");

    }



?>