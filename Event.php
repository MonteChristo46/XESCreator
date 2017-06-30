<?php
/**
 * Created by PhpStorm.
 * User: danielhoschele
 * Date: 23.07.16
 * Time: 12:00
 */
class Event
{
    //Variables
    private $name;
    private $resourceGroup;
    private $energyPower;
    private $type;
    private $costs;
    private $processingTime;
    private $transition;

    private $energy;
    private $resource;
    private $timeStart;
    private $timeEnd;

    function __construct($name, $resourceGroup, $costs, $energyPower,$transition, $type){
        //Take a lock at the static method in the time class. Processing Time is calculated random between some range
        $this->processingTime = TimeGenerator::calculateTimeForEvent($type);
        $this->name = $name;
        $this->resourceGroup = $resourceGroup;
        $this->energyPower = $energyPower;
        $this->energy = $energyPower*$this->processingTime;
        $this->type = $type;
        $this->transition = $transition;
        $this->energy = new Energy($this);
    }

    //Getter
    public function getName()
    {
        return $this->name;
    }

    public function getResourceGroup()
    {
        return $this->resourceGroup;
    }

    public function getEnergyPower()
    {
        return $this->energyPower;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCosts()
    {
        return $this->costs;
    }

    public function getProcessingTime()
    {
        return $this->processingTime;
    }

    public function getTransition()
    {
        return $this->transition;
    }
    public function getTimeStart()
    {
        return $this->timeStart;
    }
    public function getTimeEnd()
    {
        return $this->timeEnd;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function getEnergy()
    {
        return $this->energy;
    }

    //Setter
    public function setEnergy($energy)
    {
        $this->energy = $energy;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    public function setTimeStart($timeStart)
    {
        $this->timeStart = $timeStart;
    }

    public function setTimeEnd($timeEnd)
    {
        $this->timeEnd = $timeEnd;
    }

    public function setCosts($costs)
    {
        $this->costs = $costs;
    }

}