<?php
/**
 * Created by PhpStorm.
 * User: danielhoschele
 * Date: 23.07.16
 * Time: 11:57
 */
class Cases
{
    //Variables
    private $events;
    private $frequency;
    //Constructor
   function __construct($frequency,...$event){
        $this->events = $event;
        $this->frequency = $frequency;
   }
    public function getEvents()
    {
        return $this->events;
    }
    /**
     * @return mixed
     */
    public function getFrequency()
    {
        return $this->frequency;
    }
}