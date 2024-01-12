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

        $quizName = $_SESSION['quizchoice'];
        
        $sql = "SELECT quiz_ID FROM quizDetails WHERE quiz_name = '$quizName'" ;	

        $stmt = $pdo->prepare($sql); 
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while($row = $stmt->fetch()) {
            $id = $row['quiz_ID'];
        }

        $sql = "SELECT * FROM quizDetails WHERE quiz_ID = '$id'" ;	

        $stmt = $pdo->prepare($sql); 
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while($row = $stmt->fetch()) {
            $dur = $row['duration'];
            $score = $row['total_score'];
        }
        
        echo("<h1>Taking Quiz: $quizName</h1><br>");
        echo("<p>Welcome! The duration of this quiz is $dur mins and the maximum score is $score</p>");
        echo("<p>Good Luck!!!!</p>");

        $sql = "SELECT question_num, question FROM questions WHERE quiz_ID = '$id'" ;	

        $stmt = $pdo->prepare($sql); 
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        echo("<form action='check_quiz.php' method='POST'>");
        $numArray = array();
        while($row = $stmt->fetch()) {
            $num = $row['question_num'];
            $question = $row['question'];
            array_push($numArray, $num);

            // each question option
            $sql2 = "SELECT question_option, correct FROM options WHERE  question_num = '$num' AND quiz_ID = '$id'" ;	

            $stmt2 = $pdo->prepare($sql2); 
            $stmt2->execute();
            $result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);

            echo("<h4>$question</h4>");
            while($row2 = $stmt2->fetch()) {
                $opt = $row2['question_option'];
                $correct = $row2['correct'];
                echo("<input type='radio' name='$num' value=$opt>
                <label>$opt</label><br>");
            }

        }
        echo("<br><input type='submit' value='Submit Quiz'>");
        echo("</form>");
        $_SESSION['numlist'] = $numArray;
        $_SESSION['quizID'] = $id;


    }



?>