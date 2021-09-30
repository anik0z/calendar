<!DOCTYPE html>
<html>
<head>
    <title>Calendar</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <h1>Calendar</h1>
    <img src="../img/Icinga_logo.png" alt="icinga" width="150" height="50">
    <img src="../img/favicon.png" alt="nextways" width="50" height="50">
</header>
<main>
    <form class="form" action="../../Form/User/RegisterForm.php" method="post">
        <div class="container">
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>
            <button type="submit">Register</button>
        </div>
    </form>
</main>
</body>
</html>
