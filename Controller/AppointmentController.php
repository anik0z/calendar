<?php

include_once __DIR__ . '/../Model/Repository/AppointmentRepository.php';

/*
 * Call Handler for manage the different calls
 * - edit
 * - delete
 * - create
 */


if(!isset($_COOKIE["currentUser"])){
    header("Location: ../View/User/login.php");
}elseif (!empty($_POST)){
    if(!empty($_POST["action"])){
        if(!empty($_POST["id"])){
            $action = $_POST["action"];
            $id = $_POST["id"];
            $appointmentController = new AppointmentController();
            switch ($action){
                case "edit":
                    //$appointmentController->edit($id);
                    break;
                case "delete":
                    $appointmentController->remove($id);
                    break;
                case "create":
                    //$appointmentController->add();
                    break;
            }
        }
    }

}

/*
 * Class controller for the management of the appointment
 */


class AppointmentController
{

    private $appointmentRepository;

    public function __construct()
    {
        $this->appointmentRepository = new AppointmentRepository();
    }

    public function getMonthAppointment($currentMonth,$currentYear){
        $appointmentRepository = new AppointmentRepository();
        $calendar = $appointmentRepository->getMonthAppointment($currentMonth,$currentYear);
        return $calendar;
    }


    public function add($title,$description,$date){
        $appointment = new Appointment();
        $appointment->setTitle($title);
        $appointment->setDescription($description);
        $appointment->setDate($date);
        $newAppointment = $this->appointmentRepository->addAppointment($appointment);
        return $newAppointment;
    }

    public function remove($id){
        $this->appointmentRepository->remove($id);
        header("Location: ../View/index.php");
    }

    public function edit($id,$title,$description,$date){
        $appointment = new Appointment();
        $appointment->setId($id);
        $appointment->setTitle($title);
        $appointment->setDescription($description);
        $appointment->setDate($date);
        $newAppointment = $this->appointmentRepository->edit($appointment);
        return $newAppointment;
    }

    public function getAppointment($id){
        return $this->appointmentRepository->findById($id);
    }
}
