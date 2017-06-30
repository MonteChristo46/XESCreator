<?php

/**
 * Created by PhpStorm.
 * User: danielhoschele
 * Date: 23.07.16
 * Time: 11:51
 */
class TimeGenerator
{
    public static function getTimeStamp($stringStart, $stringEnd){
       $min = strtotime($stringStart);
        $max = strtotime($stringEnd);

        $randomDate = mt_rand($min, $max);

        return date("c",$randomDate);
    }
    //Returns the minutes depending on the event type
    public static function calculateTimeForEvent($type){
        switch($type){
            case "small":
                return mt_rand(1,30);
            case "middle":
                return mt_rand(31, 60);
            case "big":
                return mt_rand  (60,120);
        }

    }
}