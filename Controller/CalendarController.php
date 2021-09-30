<?php


class CalendarController
{

    private $listCalendar = [];

    public function getDailyAppointment($day,$month,$year){
        $appointmentRepository = new AppointmentRepository();
        return $appointmentRepository->getDailyAppointment($day,$month,$year);
    }

}
