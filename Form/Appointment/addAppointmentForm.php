<?php

include_once __DIR__ . '/../../Model/Repository/AppointmentRepository.php';
include_once __DIR__ . '/../../Controller/AppointmentController.php';

if(isset($_POST["date"])) {
    if (isset($_POST["title"])) {
        if (isset($_POST["description"])) {
            $appointmentController = new AppointmentController();
            $newAppointment = $appointmentController->add($_POST["title"],$_POST["description"],$_POST["date"]);
            header("Location: ../../View/index.php");
        }
    }
}

