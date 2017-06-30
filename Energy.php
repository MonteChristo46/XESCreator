<?php
/**
 * Created by PhpStorm.
 * User: danielhoschele
 * Date: 25.07.16
 * Time: 09:14
 */
class Energy
{
    private $measurement;
    private $consumption;
    private $event;

    function __construct($event){
        $this->event = $event;
        $this->measurement = "Energy Unit";
        $this->calculateConsumption($event);
    }
    private function calculateConsumption($event){
        $max  = $this->event->getEnergyPower();
        $this->event->getProcessingTime();

        $min = $max-($max/3);
        $this->consumption = mt_rand($min, $max);
    }

    /**
     * @return mixed
     */
    public function getConsumption()
    {
        return $this->consumption;
    }

    /**
     * @param mixed $consumption
     */
    public function setConsumption($consumption)
    {
        $this->consumption = $consumption;
    }
}