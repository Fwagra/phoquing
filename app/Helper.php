<?php


/**
 * Return the difference between two times in decimal hours
 * E.g. 1h30 will return 1.5
 * @param $first_timestamp
 * @param $second_timestamp
 * @return float
 */
function totalCalculation($first_timestamp, $second_timestamp){
    return round(($second_timestamp - $first_timestamp) / 3600, 1);
}