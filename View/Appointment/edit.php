<?php

include_once __DIR__ . '/../../Controller/AppointmentController.php';

/*
 * Getting the information about the user to can edit
 */

if(!isset($_COOKIE["currentUser"])){
    header("Location: ../View/User/login.php");
}elseif (!empty($_POST)){
    if(!empty($_POST["id"])){
        $id = $_POST["id"];
        $appointmentController = new AppointmentController();
        $appointment = $appointmentController->getAppointment($id);
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
    <form class="" action="../../Form/Appointment/editAppointmentForm.php" method="post">
        <div class="container">
            <label for="title"><b>Title</b></label>
            <input type="text" placeholder="<?php echo $appointment->getTitle();?>" value="<?php echo $appointment->getTitle();?>" name="title" required>

            <label for="description"><b>Description</b></label>
            <input type="text" placeholder="<?php echo $appointment->getDescription(); ?>" value="<?php echo $appointment->getDescription(); ?>" name="description" required>

            <label for="date"><b>Date</b></label>
            <input type="datetime-local" name="date" value="<?php echo str_replace(" ","T",$appointment->getDate()->format("Y-m-d H:i")); ?>" required>

            <input type="hidden" name="id" value="<?php echo $appointment->getId(); ?>">

            <button type="submit">edit appointment</button>
        </div>
    </form>
    <a href="../index.php">return</a>
</main>
</body>
</html>
