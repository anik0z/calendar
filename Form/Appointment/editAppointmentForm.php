<?php

include_once __DIR__ . '/../../Model/Repository/AppointmentRepository.php';
include_once __DIR__ . '/../../Controller/AppointmentController.php';

if(isset($_POST["date"])) {
    if (isset($_POST["title"])) {
        if (isset($_POST["description"])) {
            if(isset($_POST["id"])){
                $appointmentController = new AppointmentController();
                $newAppointment = $appointmentController->edit($_POST["id"],$_POST["title"],$_POST["description"],$_POST["date"]);
                header("Location: ../../View/index.php");
            }
        }
    }
}

