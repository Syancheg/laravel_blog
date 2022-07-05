<?php


namespace App\Helpers;


class DateHelper
{

    public static $monthString = [
        'Янв',
        'Фев',
        'Мар',
        'Апр',
        'Май',
        'Июн',
        'Июл',
        'Авт',
        'Сен',
        'Окт',
        'Ноя',
        'Дек',
    ];

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

    public static function formatDateToPoblicPost($date) {
        if(!is_null($date)) {
            $date = substr($date, 0, strpos($date, ' '));
            $date = explode('-', $date);
            $date = [
                'day' => $date[2],
                'month' => DateHelper::$monthString[(int)$date[1] - 1]
            ];
        }
        return $date;
    }

}
