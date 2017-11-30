<?php

function totalCalculation($first_timestamp, $second_timestamp){
    return round(($second_timestamp - $first_timestamp) / 3600, 1);
}