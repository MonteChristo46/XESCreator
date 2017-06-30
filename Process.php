<?php
/**
 * Created by PhpStorm.
 * User: danielhoschele
 * Date: 23.07.16
 * Time: 11:45
 */
class Process
{
        //Variables
        private $process;
        private $frequency;
        private $machineProcess;

        private $arrayMG1= array("Bohrer 1", "Bohrer 2", "Bohrer 3");
        private $arrayMG2 = array("Messgeraet 1", "Messgeraet 2");
        private $arrayMG3 = array("Schleifmaschine 1", "Schleifmaschine 2", "Schleifmaschine 3");
        private $arrayMG4 = array("Lackieranlage 1", "Lackieranlage 2", "Lackieranlage 3");
        private $arrayMG5= array("Bohrschrauber 1", "Bohrschrauber 2");
        private $arrayMG6= array("Leimmaschine 1");
        private $arrayMG7= array("Pruefmaschine 1", "Pruefmaschine 2");
        private $arrayMG8= array("Recycling");

        //Constructor
        function __construct($frequency ,$StartTime,...$case){
            $this->process = $case;
            $this->frequency = $frequency;
            $this->factoryMethod();
            $this->calculateTimes();
            $this->setResource();
            $this->removeParallelWorkingResource();
            $this->calculateCosts();
            $this->adjustEnergyConsumptions();
        }
        //Methods
        private function factoryMethod(){
            $result = array();
            foreach($this->process as $case){
                $frequencyForCase = $case->getFrequency();
               for($i=0; $i < round(($frequencyForCase*$this->frequency)); $i++){
                   $arrayCaseHandle = array();
                   foreach($case->getEvents() as $event){
                       $name = $event->getName();
                       $resourceGroup = $event->getResourceGroup();
                       $costs = $event->getCosts();
                       $energyPower = $event->getEnergyPower();
                       $transition = $event->getTransition();
                       $type = $event->getType();

                      array_push($arrayCaseHandle,new Event($name, $resourceGroup, $costs, $energyPower, $transition, $type));
                   }
                   array_push($result, $arrayCaseHandle);
               }
            }
            shuffle($result);
            $this->machineProcess = $result;
        }
        //Funktion soll die Zeitstempel für die Cases setzen. Kriegt ein Zeitintervall gegeben
        private function calculateTimes(){
            foreach ($this->machineProcess as $case){
                $timeStamp = TimeGenerator::getTimeStamp("01.January.2016", "15.January.2016");
                $processingTime = 0;
                $waitingTime = 0;
                foreach($case as $index=>$event){
                    $timeForStart = new DateTime($timeStamp);
                    $waitingTime += mt_rand(5, 120); //calculates an random time between the activities.
                    $startTime = $timeForStart->add(new DateInterval("PT".$waitingTime."M"));
                    $event->setTimeStart($startTime);
                    $timeForEnd = new DateTime($startTime->format("c"));
                    $processingTime += $event->getProcessingTime();
                    $endTime = $timeForEnd->add(new DateInterval("PT".($processingTime)."M"));
                    $event->setTimeEnd($endTime);
                }
            }
        }
        //Setting resources
        private function setResource(){
            foreach ($this->machineProcess as $case){
                $event = $case;
                for($i = 0; $i<count($event); $i++){
                    if(count($event) < $i+1){
                        break;
                    }
                    $group = $event[$i]->getResourceGroup();
                        switch ($group){
                            case "MG1":
                                $j = mt_rand(0,count($this->arrayMG1)-1);
                                $resource = $this->arrayMG1[$j];
                                $event[$i]->setResource($resource);
                                break;
                            case "MG2":
                                $j = mt_rand(0,count($this->arrayMG2)-1);
                                $resource = $this->arrayMG2[$j];
                                $event[$i]->setResource($resource);
                                break;
                            case "MG3":
                                $j = mt_rand(0,count($this->arrayMG3)-1);
                                $resource = $this->arrayMG3[$j];
                                $event[$i]->setResource($resource);
                                break;
                            case "MG4":
                                $j = mt_rand(0,count($this->arrayMG4)-1);
                                $resource = $this->arrayMG4[$j];
                                $event[$i]->setResource($resource);
                                break;
                            case "MG5":
                                $j = mt_rand(0,count($this->arrayMG5)-1);
                                $resource = $this->arrayMG5[$j];
                                $event[$i]->setResource($resource);
                                break;
                            case "MG6":
                                $j = mt_rand(0,count($this->arrayMG6)-1);
                                $resource = $this->arrayMG6[$j];
                                $event[$i]->setResource($resource);
                                break;
                            case "MG7":
                                $j = mt_rand(0,count($this->arrayMG7)-1);
                                $resource = $this->arrayMG7[$j];
                                $event[$i]->setResource($resource);
                                break;
                            case "MG8":
                                $j = mt_rand(0,count($this->arrayMG8)-1);
                                $resource = $this->arrayMG8[$j];
                                $event[$i]->setResource($resource);
                                break;
                            default:
                               break;
                        }
                }
            }
        }
        private function removeParallelWorkingResource(){
            $allEvents = array();
            $allEventsHandle = array();
            foreach ($this->machineProcess as $case){
                foreach($case as $event){
                    array_push($allEvents, $event);
                    array_push($allEventsHandle, $event);
                }
            }
            for($i = 0; $i<count($allEvents); $i++){
                for($j = 1; $j<$i; $j++){
                    $timeFirstElement = strtotime($allEvents[$i]->getTimeEnd()->format("c"));
                    $timeLastElement = strtotime($allEventsHandle[$j]->getTimeStart()->format("c"));
                    $firstMachine = $allEvents[$i]->getResource();
                    $lastMachine = $allEventsHandle[$j]->getResource();
                    if($timeFirstElement > $timeLastElement && $firstMachine == $lastMachine) {
                        //Adding Waiting between 5_10 Minutes.
                        $dateStart = $allEvents[$i]->getTimeStart();
                        $dateEnd = $allEvents[$i]->getTimeEnd();
                        $min = 10;
                        $max = 15;
                        $additionalWaitingTime = mt_rand($min, $max);
                        $dateStart->add(new DateInterval("PT".$additionalWaitingTime."M"));
                        $dateEnd->add(new DateInterval("PT".$additionalWaitingTime."M"));


                    }
                }
            }
        }
        private function calculateCosts(){
            foreach ($this->machineProcess as $case){
                foreach($case as $event) {
                    $costs = 0;
                    switch ($event->getResource()){
                        case "Bohrer 1":
                            $costs = 0.30;
                            break;
                        case "Bohrer 2":
                            $costs = 0.32;
                            break;
                        case "Bohrer 3":
                            $costs = 0.35;
                            break;
                        case "Messgeraet 1":
                            $costs = 0.1;
                            break;
                        case "Messgeraet 2":
                            $costs = 0.11;
                            break;
                        case "Schleifmaschine 1":
                            $costs = 0.58;
                            break;
                        case "Schleifmaschine 2":
                            $costs = 0.52;
                            break;
                        case "Schleifmaschine 3":
                            $costs = 0.50;
                            break;
                        case "Lackieranlage 1":
                            $costs = 1.4;
                            break;
                        case "Lackieranlage 2":
                            $costs = 1.7;
                            break;
                        case "Lackieranlage 3":
                            $costs = 1.6;
                            break;
                        case "Bohrschrauber 1":
                            $costs = 0.30;
                            break;
                        case "Bohrschrauber 2":
                            $costs = 0.32;
                            break;
                        case "Leimmaschine 1":
                            $costs = 1.3;
                            break;
                        case "Leimmaschine 2":
                            $costs = 1.7;
                            break;
                        case "Pruefmaschine 1":
                            $costs = 0.9;
                            break;
                        case "Pruefmaschine 2":
                            $costs = 1.0;
                            break;
                        case "Recycling":
                            $costs = 3.0;
                            break;

                        default:
                            //throw new InvalidArgumentException("The Machine is no support: "+$event->getResource());
                            break;
                    }
                    $event->setCosts($costs*$event->getProcessingTime());
                }
            }

        }
        private function adjustEnergyConsumptions(){
            foreach ($this->machineProcess as $case) {
                foreach ($case as $event) {
                    switch ($event->getResource()) {
                        case "Bohrer 1":
                            $consumption = $event->getEnergy()->getConsumption();
                            $event->getEnergy()->setConsumption($consumption*0.8);
                            break;
                        case "Bohrer 2":
                            $consumption = $event->getEnergy()->getConsumption();
                            $event->getEnergy()->setConsumption($consumption);
                            break;
                        case "Bohrer 3":
                            $consumption = $event->getEnergy()->getConsumption();
                            $event->getEnergy()->setConsumption($consumption*1.2);
                            break;
                    }
                }
            }
        }

        //Counts the all Cases
        public function getLength(){
            return count($this->machineProcess);
        }

        public function getProcess(){
            return $this->machineProcess;
        }


}