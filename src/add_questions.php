<?php
    session_start();
    if(isset($_POST)){


		$input['question'] = $_POST['question'];
		$input['one'] = $_POST['one'];
		$input['two'] = $_POST['two'];
		$input['three'] = $_POST['three'];
		$input['four'] = $_POST['four'];
		$input['answer'] = $_POST['answer'];
        

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
            $quizID = $row['quiz_ID'];
        }

        $question = $input['question'];
        $answer = $input['answer'];
        $answer = $input[$answer];

        $sql = "INSERT INTO questions (quiz_ID, question)
        VALUES (:quizID, :question)" ;	

        $stmt = $pdo->prepare($sql); 
        $stmt->execute([
            'quizID'=> $quizID,
            'question' => $question
        ]);


        $sql = "SELECT question_num FROM questions WHERE quiz_ID = '$quizID' AND question = '$question'" ;	

        $stmt = $pdo->prepare($sql); 
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while($row = $stmt->fetch()) {
            $questionNum = $row['question_num'];
        }

        $options['one'] = $input['one'];
        $options['two'] = $input['two'];
        $options['three'] = $input['three'];
        $options['four'] = $input['four'];

        foreach ($options as $value) {
            echo "$value <br>";
            $qOption = $value;

            $optionChosen = null;
            if($value == $answer){
                $correct = 1;
            }
            else{
                $correct = 0;
            }
            $sql = "INSERT INTO options (question_option, quiz_ID, question_num, option_chosen, correct)
            VALUES (:qOption,:quizID, :questionNum, :optionChosen, :correct)" ;	

            $stmt = $pdo->prepare($sql); 
            $stmt->execute([

                'qOption'=> $qOption,
                'quizID'=> $quizID,
                'questionNum' => $questionNum,
                'optionChosen' => $optionChosen,
                'correct' => $correct
            ]);

        }


        header("Location: edit_quiz.php");



    }


?>