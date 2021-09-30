<?php

include_once __DIR__ . '/../Class/Appointment.php';
include_once __DIR__ . '/../../Util/Connection.php';

class AppointmentRepository
{

    public function findById($id){
        $conn = new Connection();

        $sql = "SELECT * FROM appointment WHERE id=:id";
        $args = ['id' => $id];

        $stmt = $conn->run($sql,$args);

        $row = $stmt->fetch();
        $appointment = new Appointment();
        $appointment->setId($row["id"]);
        $appointment->setDate($row["date"]);
        $appointment->setDescription($row["description"]);
        $appointment->setTitle($row["title"]);
        return $appointment;
    }

    public function getMonthAppointment($month,$year){
        $conn = new Connection();

        $sql = "SELECT a.id,a.title,a.description,a.date FROM appointment as a,user_appointment as ua WHERE ua.id_user =:idCurrentUser AND YEAR(a.date)=:yearNow  AND MONTH(a.date)=:monthNow  ORDER BY a.date ASC";
        $args = ['yearNow' => $year,"monthNow" => $month,"idCurrentUser" => $_COOKIE["currentUser"]];

        $stmt = $conn->run($sql,$args);

        $calendar = [];
        while($row = $stmt->fetch()){
            $appointment = new Appointment();
            $appointment->setId($row["id"]);
            $appointment->setDate($row["date"]);
            $appointment->setDescription($row["description"]);
            $appointment->setTitle($row["title"]);
            $calendar[] = $appointment;
        }

        return $calendar;
    }

    public function getDailyAppointment($day,$month,$year){
        $conn = new Connection();

        $sql = "SELECT a.id,a.title,a.description,a.date FROM appointment as a,user_appointment as ua WHERE a.id = ua.id_appointment AND ua.id_user =:idCurrentUser AND YEAR(a.date)=:yearNow  AND MONTH(a.date)=:monthNow AND DAY(a.date)=:dayNow ORDER BY a.date ASC";
        $args = ['yearNow' => $year,"monthNow" => $month,"dayNow" => $day, "idCurrentUser" => $_COOKIE["currentUser"]];

        $stmt = $conn->run($sql,$args);

        $calendar = [];
        while($row = $stmt->fetch()){
            $appointment = new Appointment();
            $appointment->setId($row["id"]);
            $appointment->setDate($row["date"]);
            $appointment->setDescription($row["description"]);
            $appointment->setTitle($row["title"]);
            $calendar[] = $appointment;
        }
        return $calendar;
    }


    public function addAppointment($appointment){
        $haveAppointment = false;

        $conn = new Connection();

        /*
         * Check if have a appointment in this time
         *
         *  $stmt = $conn->prepare("SELECT a.id,a.title,a.date,a.description FROM appointment as a,user_appointment as ua WHERE a.id = ua.id_appointment AND ua.id_user=:id AND date BETWEEN :dateMin and :dateMax");
            $stmt->execute(['id' => $_COOKIE["currentUser"]]);

            while($row = $stmt->fetch()){
                $exist = true;
            }
         *
         */


        $sql = "INSERT INTO appointment (title,description,date) VALUES (?,?,?)";
        $args = [$appointment->getTitle(),$appointment->getDescription(),$appointment->getDate()->format('Y-m-d H:i:s')];
        $conn->run($sql,$args);
        $idAppointment = $conn->lastInsertId();

        $sql = "INSERT INTO user_appointment (id_user,id_appointment) VALUES (?,?)";
        $args = [$_COOKIE["currentUser"], $idAppointment];
        $conn->run($sql,$args);

        return !$haveAppointment;
    }

    public function remove($id){
        $conn = new Connection();
        $sql = "DELETE FROM appointment WHERE id=:id";
        $args = ["id" => $id];
        $conn->run($sql,$args);
    }

    /* It´s not use for right now, it´s working with the add */
    public function edit($appointment){
        $conn = new Connection();
        $sql = "UPDATE appointment SET title=?, description=?,date=? WHERE id=?";
        $args = [$appointment->getTitle(),$appointment->getDescription(),$appointment->getDate()->format('Y-m-d H:i:s'),$appointment->getId()];
        $stmt= $conn->run($sql,$args);
    }

}
