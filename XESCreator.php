<?php
/**
 * Created by PhpStorm.
 * User: danielhoschele
 * Date: 24.07.16
 * Time: 19:21
 */
class XESCreator
{
    private $process;
    function __construct($process){
        $this->process = $process->getProcess();
    }

    public function createXES(){
        $dom = new DOMDocument("1.0", "UTF-8");
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $root = $dom->createElement("log");
            $root->setAttribute("xmlns", "http://code.deckfour.org/xes");
            $root->setAttribute("xes.version", "2.0");
            $root->setAttribute("xes.creator", "Daniel Hoeschele");
        $dom->appendChild($root);
        $extensionConcept = $dom->createElement("extension");
            $extensionConcept->setAttribute("name", "Concept");
            $extensionConcept->setAttribute("prefix", "concept");
            $extensionConcept->setAttribute("uri", "http://code.deckfour.org/xes/concept.xesext");
        $extensionTime = $dom->createElement("extension");
            $extensionTime->setAttribute("name", "Time");
            $extensionTime->setAttribute("prefix", "time");
            $extensionTime->setAttribute("uri", "http://code.deckfour.org/xes/time.xesext");
        $extensionOrg = $dom->createElement("extension");
            $extensionOrg->setAttribute("name", "Organizational");
            $extensionOrg->setAttribute("prefix", "org");
            $extensionOrg->setAttribute("uri", "http://code.deckfour.org/xes/org.xesext");
        $extensionEnergy = $dom->createElement("extension");
            $extensionEnergy->setAttribute("name", "Energy");
            $extensionEnergy->setAttribute("prefix", "energy");
            $extensionEnergy->setAttribute("uri", ".../energy.xeset");
        $extensionCost = $dom->createElement("extension");
            $extensionCost->setAttribute("name", "Cost");
            $extensionCost->setAttribute("prefix", "cost");
            $extensionCost->setAttribute("uri", "http://www.xes-standard.org/cost.xesext");
        $extensionLifecycle = $dom->createElement("extension");
            $extensionLifecycle->setAttribute("name", "Lifecycle");
            $extensionLifecycle->setAttribute("prefix", "lifecycle");
            $extensionLifecycle->setAttribute("uri", "http://www.xes-standard.org/lifecycle.xesext");
        $root->appendChild($extensionConcept);
        $root->appendChild($extensionTime);
        $root->appendChild($extensionOrg);
        $root->appendChild($extensionEnergy);
        $root->appendChild($extensionLifecycle);
        $root->appendChild($extensionCost);
        foreach ($this->process as $case) {
            $trace = $dom->createElement("trace");
            $root->appendChild($trace);
            foreach ($case as $event) {
                $eventTag = $dom->createElement("event");
                $trace->appendChild($eventTag);
                $stringName = $dom->createElement("string");
                    $stringName->setAttribute("key","concept:name");
                    $stringName->setAttribute("value",$event->getName());
                $stringResource = $dom->createElement("string");
                    $stringResource->setAttribute("key","org:resource");
                    $stringResource->setAttribute("value",$event->getResource());
                $stringGroup = $dom->createElement("string");
                    $stringGroup->setAttribute("key","org:group");
                    $stringGroup->setAttribute("value",$event->getResourceGroup());
                $date = $dom->createElement("date");
                    $date->setAttribute("key","time:timestamp");
                    $date->setAttribute("value",$event->getTimeStart()->format("c"));
                $stringLife = $dom->createElement("string");
                    $stringLife->setAttribute("key","lifecycle:transition");
                    $stringLife->setAttribute("value","start");
                $stringEnergy = $dom->createElement("float");
                    $stringEnergy->setAttribute("key", "energy:consumption");
                    $stringEnergy->setAttribute("value", $event->getEnergy()->getConsumption());
                $stringEnergyMeasurement = $dom->createElement("string");
                    $stringEnergyMeasurement->setAttribute("key", "energy:measurement");
                    $stringEnergyMeasurement->setAttribute("value", "W");
                $stringCostMeasurement = $dom->createElement("float");
                    $stringCostMeasurement->setAttribute("key", "cost:total");
                    $stringCostMeasurement->setAttribute("value", $event->getCosts());
                $stringCostCurrency = $dom->createElement("string");
                    $stringCostCurrency->setAttribute("key", "cost:currency");
                    $stringCostCurrency->setAttribute("value", "EUR");

                $eventTag->appendChild($stringName);
                $eventTag->appendChild($stringResource);
                $eventTag->appendChild($stringGroup);
                $eventTag->appendChild($date);
                $eventTag->appendChild($stringLife);
                $eventTag->appendChild($stringEnergy);
                $eventTag->appendChild($stringEnergyMeasurement);
                $eventTag->appendChild($stringCostMeasurement);
                $eventTag->appendChild($stringCostCurrency);


                $eventTag1 = $dom->createElement("event");
                $trace->appendChild($eventTag1);

                $stringName1 = $dom->createElement("string");
                    $stringName1->setAttribute("key","concept:name");
                    $stringName1->setAttribute("value",$event->getName());
                $stringResource1 = $dom->createElement("string");
                    $stringResource1->setAttribute("key","org:resource");
                    $stringResource1->setAttribute("value",$event->getResource());
                $stringGroup1 = $dom->createElement("string");
                    $stringGroup1->setAttribute("key","org:group");
                    $stringGroup1->setAttribute("value",$event->getResourceGroup());
                $date1 = $dom->createElement("date");
                    $date1->setAttribute("key","time:timestamp");
                    $date1->setAttribute("value",$event->getTimeEnd()->format("c"));
                $stringLife1 = $dom->createElement("string");
                    $stringLife1->setAttribute("key","lifecycle:transition");
                    $stringLife1->setAttribute("value",$event->getTransition());
                $stringEnergy1 = $dom->createElement("float");
                    $stringEnergy1->setAttribute("key", "energy:consumption");
                    $stringEnergy1->setAttribute("value", $event->getEnergy()->getConsumption());
                $stringEnergyMeasurement1 = $dom->createElement("string");
                    $stringEnergyMeasurement1->setAttribute("key", "energy:measurement");
                    $stringEnergyMeasurement1->setAttribute("value", "W");
                $stringCostMeasurement1 = $dom->createElement("float");
                    $stringCostMeasurement1->setAttribute("key", "cost:total");
                    $stringCostMeasurement1->setAttribute("value", $event->getCosts());
                $stringCostCurrency1 = $dom->createElement("string");
                    $stringCostCurrency1->setAttribute("key", "cost:currency");
                    $stringCostCurrency1->setAttribute("value", "EUR");


                $eventTag1->appendChild($stringName1);
                $eventTag1->appendChild($stringResource1);
                $eventTag1->appendChild($stringGroup1);
                $eventTag1->appendChild($date1);
                $eventTag1->appendChild($stringLife1);
                $eventTag1->appendChild($stringEnergy1);
                $eventTag1->appendChild($stringEnergyMeasurement1);
                $eventTag1->appendChild($stringCostMeasurement1);
                $eventTag1->appendChild($stringCostCurrency1);
            }
        }

        $dom->save("ProcessData.xes");
    }
}