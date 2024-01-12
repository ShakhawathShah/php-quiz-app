<?php include("header.php")?>

<body>
    <div id="wrapper">
        <?php 
            echo("<h1>Take Quiz</h1>");
			if(empty($_POST)){
				echo(show_quiz());
			}
			else{
                $quiz = getChosenQuiz();
                $_SESSION['quizchoice'] = $quiz['quizchoice'];
                header("Location: take_quiz.php");
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

        // get quiz id
        $id = $_SESSION['user'];

        echo("<form method='POST'>");

        echo("<h3>Quizzes Available</h3>
                    <table class='center'>
                    <tbody>
                    <tr style='height: 25%; font-size: 20px;'>
                        <th>Quiz ID</th>
                        <th>Quiz Name</th>
                        <th>Author</th>
                        <th>Duration</th>
                        <th>Total Score</th>
                       
                    </tr>");
        
        $sql = "SELECT quiz_ID FROM studentInfo WHERE stud_ID = '$id' AND available = 'Yes'" ;	

        $stmt = $pdo->prepare($sql); 
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($row = $stmt->fetch()) {
            $quizID = $row['quiz_ID'];
        


            // Get quiz details using id
            $sql2 = "SELECT * FROM quizDetails WHERE quiz_ID = '$quizID'" ;	

            $stmt2 = $pdo->prepare($sql2); 
            $stmt2->execute();
            $result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);

            while($row2 = $stmt2->fetch()) {

                $quizID = $row2['quiz_ID'];
                $staffID = $row2['staff_ID'];
                $quizName = $row2['quiz_name'];
                $dur = $row2['duration'];
                $score = $row2['total_score'];

                        echo("<tr style='height: 25%; font-size: 15px;' id='$quizID'>
                                <td>$quizID</td>
                                <td>$quizName</td>
                                <td>$staffID</td>
                                <td>$dur</td>
                                <td>$score</td>
                                <td><input type='radio' id=$quizID name='quizchoice' value=$quizName></td>
                            </tr>");

            }
        }
                    echo("</tbody>
                        </table>
                            ");
        echo("<br><input type='submit' value='Take'>");
        echo("</form>");
        
    }

	function getChosenQuiz(){
		$quiz = array(); 
		$quiz['quizchoice'] = $_POST['quizchoice'];
        
		return $quiz;
	}


?>