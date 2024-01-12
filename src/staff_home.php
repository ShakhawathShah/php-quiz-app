<?php include("header.php")?>

<body>
    <div id="wrapper">
        <h1> Staff Home Page</h1>

        <button class="button" style="vertical-align:middle" onclick="window.location.href='/app/create_quiz.php'">
            <span>Create New Quiz </span></button>

        <button class="button" style="vertical-align:middle" onclick="window.location.href='/app/edit.php'">
            <span>Edit Quiz </span></button>

        <button class="button" style="vertical-align:middle" onclick="window.location.href='/app/delete_quiz.php'">
            <span>Delete Quiz </span></button>

        <button class="button" style="vertical-align:middle" onclick="window.location.href='/app/logout.php'">
            <span>Logout </span></button>

    </div>
</body>

</html>