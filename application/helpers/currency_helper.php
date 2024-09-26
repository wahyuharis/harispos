<?php

function intval2($str)
{
    $int = str_replace(',', '', $str);
    $int = intval($int);
    return $int;
}

function is_float2($float)
{
    $float = floatval($float) . "";
    $pos = strpos($float, '.');
    if ($pos > 0) {
        return true;
    } else {
        return false;
    }
}

function floatval2($str)
{
    $int = str_replace(',', '', $str);
    $int = floatval($int);
    return $int;
}

function format_currency($intval){
    $return='';

    $return=number_format($intval,2);

    return $return;
}