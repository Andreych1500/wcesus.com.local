<?php
class Mail{
    static $subject = '';
    static $from = '';
    static $to = '';
    static $hidden_copy = '';
    static $text = '';
    static $headers = '';

    static function Send(){
        self::$headers = '=?utf-8?b?'.base64_encode(self::$subject).'?='; //кодіровка
        self::$headers = "Content-type: text/html; charset=\"utf-8\"\r\n";

        self::$headers .= "From: ".self::$from."\r\n"; //з якого email було відправлено
        self::$headers .= "MIME-Version: 1.0\r\n"; //тип листа
        self::$headers .= "Date: ".date('D, d M Y h:s:s O')."\r\n"; //дата листа коли було відправлено
        self::$headers .= "Precedence: bulk\r\n"; //лист в одну сторону...відповіді непотребує...приклад:після реєстрації*
        if(!empty(self::$hidden_copy)){
            self::$headers .= "Bcc: ".self::$hidden_copy."\r\n"; // Скрита копія
        }

        return mail(self::$to, self::$subject, self::$text, self::$headers);
    }
}