<?php


if(!isset($_COOKIE["currentUser"])) {
    header("Location: ../View/User/login.php");
}else{
    $month = date('m');
    $year = date('Y');
    $day = date("d");
    $hours = date("H");
    $minutes = date("i");

    if(!empty($_POST)){
        if(!empty($_POST["year"])){
            $year = $_POST["year"];
        }

        if(!empty($_POST["month"])){
            $month = $_POST["month"];
        }

        if(!empty($_POST["day"])){
            $day = $_POST["day"];
        }
    }


?>
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
    <form class="" action="../../Form/Appointment/addAppointmentForm.php" method="post">
        <div class="container">
            <label for="title"><b>Title</b></label>
            <input type="text" placeholder="Enter title" name="title" required>

            <label for="description"><b>Description</b></label>
            <input type="text" placeholder="Enter description" name="description" required>

            <label for="date"><b>Date</b></label>
            <input type="datetime-local" name="date" value="<?php echo $year."-".$month."-".$day."T".$hours.":".$minutes ?>" required>

            <button type="submit">Add appointment</button>
        </div>
    </form>
    <a href="../index.php">return</a>
</main>
</body>
</html>
<?php
}
    ?>
