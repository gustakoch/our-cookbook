<?php

namespace Resources\Classes;

class Logs {
    public static function setTimezone() {
        // date_default_timezone_set('America/Sao_Paulo');
        date_default_timezone_set('America/Recife'); // SEM HORÁRIO DE VERÃO
    }

    public static function getUserIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public static function register($user = null, $log_type, $message) {
        self::setTimezone();

        $hour = date('H:i:s');
        $date = date('d-m-Y');
        $ip = self::getUserIpAddr();

        $save_message = "[$hour][" . mb_strtoupper($log_type) . "][$ip][$user] > $message \r\n";
        $file = "logs/" . mb_strtolower($log_type) . "-" . $date . ".log";
        $handle = fopen("$file", "a+b");

        fwrite($handle, $save_message);
        fclose($handle);
    }
}
