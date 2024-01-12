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
			    echo(addQuestionsForm());
			}
			else{
                // $quiz = getChosenQuiz();
                // $_SESSION['quizchoice'] = $quiz['quizchoice'];
                // addQuizToDatabase($user);
			}
	    ?>


    </div>
</body>


</html>


<?php

function addQuestionsForm(){

    return '
    <div class="split left">
        <div class="centered">
        <h1>Add Questions</h1>
        <p>Enter the new question below and select an answer</p>
        <form action="add_questions.php" method="POST">
        
            <label class="form-label"  for="name">Question</label>
            <input class="form-control"  type="text" name="question" required>
            <br>

            <input class="form-control"  type="text" name="one" required>
            <input type="radio" name="answer" value="one" required>
            <label class="form-label"  for="name">Option One</label>

            <input class="form-control"  type="text" name="two" required>
            <input type="radio" name="answer" value="two" required>
            <label class="form-label"  for="name">Option Two</label>

            <input class="form-control"  type="text" name="three" required>
            <input type="radio" name="answer" value="three" required>
            <label class="form-label"  for="name">Option Three</label>

            <input class="form-control"  type="text" name="four" required>
            <input type="radio" name="answer" value="four" required>
            <label class="form-label"  for="name">Option Four</label>

            <br>
            <input type="submit" value="Add">
            
        </form>
        </div>
    </div>

    ';

}

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

        $quizName = $_SESSION['quizchoice'];
        
        $sql = "SELECT quiz_ID FROM quizDetails WHERE quiz_name = '$quizName'" ;	

        $stmt = $pdo->prepare($sql); 
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while($row = $stmt->fetch()) {
            $id = $row['quiz_ID'];
        }
        $_SESSION['quizID'] = $id;
        
        $sql = "SELECT question_num, question FROM questions WHERE quiz_ID = '$id'" ;	

        $stmt = $pdo->prepare($sql); 
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        echo("<div class='split right'>
                <div class='centered'>
                    <h1>Delete Questions</h1>
                    <form action='delete_question.php' method='POST'>
                    <table>
                    <tr>
                        <th>Question Number</th>
                        <th>Question</th>
                        <th>Answer</th>
                    </tr>");


        while($row = $stmt->fetch()) {

            $questionNum = $row['question_num'];
            $question = $row['question'];

            $sql2 = "SELECT question_option FROM options WHERE quiz_ID = '$id' AND question_num = '$questionNum' AND correct = 1" ;	

            $stmt2 = $pdo->prepare($sql2); 
            $stmt2->execute();
            $result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);

            while($row2 = $stmt2->fetch()) {
                $answer = $row2['question_option'];

                    echo("<tr>
                            <td>$questionNum</td>
                            <td>$question</td>
                            <td>$answer</td>
                            <td><input type='radio' name='choice' value='$questionNum'></td>
                        </tr>");
            }
        }
                    echo("</table>
                    <a href='/app/staff_home.php'>
                    <input type='button' value='Save'>
                    </a>
                    <input  type='submit' value='Delete'>
                    </form>
                            </div>
                            </div>
                                
                            ");

    }

	// function getChosenQuiz(){
	// 	$quiz = array(); 
	// 	$quiz['quizchoice'] = $_POST['quizchoice'];
        
	// 	return $quiz;
	// }


?>