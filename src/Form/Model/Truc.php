<?php

namespace App\Form\Model;

class Truc
{

    private int $number;

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     * @return Truc
     */
    public function setNumber(int $number): Truc
    {
        $this->number = $number;
        return $this;
    }

}