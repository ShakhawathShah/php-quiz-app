<?php include("header.php")?>

<body>
    <div id="wrapper">
        <?php 
            echo("<h1>Edit Quiz</h1>");
			if(empty($_POST)){
				echo(show_quiz());
			}
			else{
                $quiz = getChosenQuiz();
                $_SESSION['quizchoice'] = $quiz['quizchoice'];
                header("Location: edit_quiz.php");
			}
	    ?>


    </div>
</body>

</html>


<?php

    function show_quiz(){

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
        
        $sql = "SELECT * FROM quizDetails WHERE staff_ID = '$id'" ;	

        $stmt = $pdo->prepare($sql); 
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        echo("<form method='POST'>");

        echo("
                    <h3>Choose quiz to edit</h3>
                    <table class='center'>
                    <tbody>
                    <tr style='height: 25%; font-size: 20px;'>
                        <th>Quiz ID</th>
                        <th>Quiz Name</th>
                        <th>Author</th>
                        <th>Duration</th>
                        <th>Total Score</th>
                       
                    </tr>");
        while($row = $stmt->fetch()) {

            $quizID = $row['quiz_ID'];
            $quizName = $row['quiz_name'];
            $dur = $row['duration'];
            $score = $row['total_score'];

                    echo("<tr style='height: 25%; font-size: 15px;' id='$quizID'>
                            <td>$quizID</td>
                            <td>$quizName</td>
                            <td>$id</td>
                            <td>$dur</td>
                            <td>$score</td>
                            <td><input type='radio' id=$quizID name='quizchoice' value=$quizName></td>
                        </tr>");

            
            // echo("<input type='radio' id=$quizID name='quizchoice' value=$quizName>");
            // echo("<label>$quizName</label><br>");

        }
                    echo("</tbody>
                        </table>
                            ");
        echo("<br><input type='submit' value='Edit'>");
        echo("</form>");
        
    }

	function getChosenQuiz(){
		$quiz = array(); 
		$quiz['quizchoice'] = $_POST['quizchoice'];
        
		return $quiz;
	}


?>