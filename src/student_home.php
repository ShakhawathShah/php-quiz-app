<?php include("header.php")?>

<body>
    <div id="wrapper">
        <h1> Student Home Page</h1>

        <button class="button" style="vertical-align:middle" onclick="window.location.href='/app/show_quizzes.php'">
            <span>Take Quiz </span></button>

        <button class="button" style="vertical-align:middle" onclick="window.location.href='/app/my_quizzes.php'">
            <span>View my Quizzes</span></button>

        <button class="button" style="vertical-align:middle" onclick="window.location.href='/app/logout.php'">
            <span>Logout </span></button>

    </div>
</body>

</html>