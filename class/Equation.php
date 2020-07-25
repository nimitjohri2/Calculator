<?php

class Equation
{
    var $id;
    var $equation;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEquation()
    {
        return $this->equation;
    }

    /**
     * @param mixed $equation
     */
    public function setEquation($equation): void
    {
        $this->equation = $equation;
    }
}