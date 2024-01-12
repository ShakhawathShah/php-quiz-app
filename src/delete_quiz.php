<?php include("header.php")?>

<body>
    <div id="wrapper">
        <?php 
            echo("<h1>Delete Quiz</h1>");
			if(empty($_POST)){
				echo(show_quiz());
			}
			else{
                $quiz = getChosenQuiz();
                delete_quiz($quiz);
                echo(show_quiz());
			}
	    ?>


    </div>
</body>

</html>


<?php

    function delete_quiz($quiz){

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "testdb";

        $pdo = new pdo('mysql:host=localhost;dbname=testdb', '$username', '$password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        if($pdo === null){
            echo("FAIL");
        }

        $quizName = $quiz['quizchoice'];

        $sql = "SELECT quiz_ID FROM quizDetails WHERE quiz_name = '$quizName'" ;	

        $stmt = $pdo->prepare($sql); 
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while($row = $stmt->fetch()) {
            $quizID = $row['quiz_ID'];
        }

        
        $id = $_SESSION['user'];
        $sql2 = "DELETE FROM quizdetails WHERE quiz_ID = '$quizID' AND staff_ID = '$id'";

        $stmt2 = $pdo->prepare($sql2); 
        $stmt2->execute();

    }

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
                    <h3>Choose quiz to delete</h3>
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

        }
                    echo("</tbody>
                        </table>
                            ");
        echo("<br><input type='submit' value='Delete'>");
        echo("</form>");
        
    }

	function getChosenQuiz(){
		$quiz = array(); 
		$quiz['quizchoice'] = $_POST['quizchoice'];
        
		return $quiz;
	}


?>