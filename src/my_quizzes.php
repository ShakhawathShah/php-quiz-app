<?php include("header.php")?>

<body>
    <div id="wrapper">
        <?php 
            echo("<h1>My Quizzes</h1>");
            echo(show_quiz());
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


        echo("<h3>Quizzes Taken</h3>
                    <table class='center'>
                    <tbody>
                    <tr style='height: 25%; font-size: 20px;'>
                        <th>Quiz ID</th>
                        <th>Quiz Name</th>
                        <th>Date Attempted</th>
                        <th>Score</th>
                       
                    </tr>");
        
        $sql = "SELECT * FROM studentInfo WHERE stud_ID = '$id' AND available = 'No'" ;	

        $stmt = $pdo->prepare($sql); 
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while($row = $stmt->fetch()) {

            $quizID = $row['quiz_ID'];
            $date = $row['date_attempted'];
            $score = $row['score'];

            $sql2 = "SELECT quiz_name FROM quizDetails WHERE quiz_ID = '$quizID'" ;	

            $stmt2 = $pdo->prepare($sql2); 
            $stmt2->execute();
            $result2 = $stmt2->setFetchMode(PDO::FETCH_ASSOC);
            while($row2 = $stmt2->fetch()) {
                $quizName = $row2['quiz_name'];
            }
            echo("<tr style='height: 25%; font-size: 15px;' id='$quizID'>
                    <td>$quizID</td>
                    <td>$quizName</td>
                    <td>$date</td>
                    <td>$score</td>
                </tr>");
        }
            echo("</tbody>
                </table>
                    ");
            echo("<br><a href='/app/student_home.php'><input type='button' value='Return Home'></a>");
        
    }


?>