<?php 

    session_start();
    if(isset($_POST)){
        $id = $_SESSION['user'];
        $quizID = $_SESSION['quizID'];
        $numArray = $_SESSION['numlist'];
        $qCount = count($numArray);
        $correctCounter = 0;

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "testdb";

        $pdo = new pdo('mysql:host=localhost;dbname=testdb', '$username', '$password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        if($pdo === null){
            echo("FAIL");
        }

        foreach($numArray as $num){

            foreach($_POST as $opt){
                $sql = "SELECT correct FROM options WHERE quiz_ID = '$quizID' AND question_num = '$num' AND question_option = '$opt'" ;
                $stmt = $pdo->prepare($sql); 
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

                while($row = $stmt->fetch()) {
                    $correct = $row['correct'];
                    if($correct == 1){
                        $correctCounter++;
                    }
                }
            }

        }

        $sql = "SELECT total_score FROM quizDetails WHERE quiz_ID = '$quizID'" ;
        $stmt = $pdo->prepare($sql); 
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while($row = $stmt->fetch()) {
            $totalScore = $row['total_score'];
        }

        $qScore = $totalScore/$qCount;
        $userScore = $correctCounter * $qScore;
        $_SESSION['correctCount'] = $correctCounter;

        $date = date('Y-m-d H:i:s');

        $sql2 = "UPDATE studentinfo SET date_attempted = '$date', score = '$userScore', available = 'No' WHERE stud_ID = '$id' AND quiz_ID = '$quizID'";  
        $stmt2 = $pdo->prepare($sql2); 
        $stmt2->execute();
        
        header("Location: results.php");
    }



?>