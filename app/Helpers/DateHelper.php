<?php


namespace App\Helpers;


class DateHelper
{

    public static function formatDateTimeToDate($date) {
        if(!is_null($date)) {
            $date = substr($date, 0, strpos($date, ' '));
            $date = explode('-', $date);
            $date = array_reverse($date);
            $date = implode('.', $date);
        }
        return $date;
    }

    public static function formatDateToDate($date){
        if(!is_null($date)) {
            $date = explode('-', $date);
            $date = array_reverse($date);
            $date = implode('.', $date);
        }
        return $date;
    }

}
