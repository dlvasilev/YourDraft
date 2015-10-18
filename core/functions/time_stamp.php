<?php
function time_stamp($session_time) { 
    $time_difference = time() - $session_time ; 
    $seconds = $time_difference ; 
    $minutes = round($time_difference / 60 );
    $hours = round($time_difference / 3600 ); 
    $days = round($time_difference / 86400 ); 
    $weeks = round($time_difference / 604800 ); 
    $months = round($time_difference / 2419200 ); 
    $years = round($time_difference / 29030400 ); 
    if($seconds <= 60) {
        echo"преди $seconds секунди"; 
    }
    else if($minutes <=60) {
        if($minutes==1)  {
            echo"преди минута"; 
        } else {
            echo"преди $minutes минути"; 
        }
    } else if($hours <=24) {
        if($hours==1) {
            echo"преди един час";
        } else {
            echo"преди $hours часа";
        }
    } else if($days <=7) {
        if($days==1) {
            echo"преди един ден";
        } else {
            echo"преди $days дни";
        }
    } else if($weeks <=4) {
        if($weeks==1) {
            echo"преди седмица";
        } else {
            echo"преди $weeks седмици";
        }
    } else if($months <=12){
        if($months==1) {
            echo"преди месец";
        } else {
            echo"преди $months месеца";
        }   
    } else {
        if($years==1){
            echo"преди година";
        } else {
            echo"преди $years години";
        }
    }
} 
?>
