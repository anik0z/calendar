<?php


class UserAppointment
{
    private $idUser;
    private $idAppointment;

    /**
     * @return mixed
     */
    public function getIdAppointment()
    {
        return $this->idAppointment;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idAppointment
     */
    public function setIdAppointment($idAppointment)
    {
        $this->idAppointment = $idAppointment;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }


}
