<?php

class Sanitizer
{

    static public function sanitizeString($string)
    {
        $string = trim($string);
        $string = filter_var($string, FILTER_SANITIZE_STRING);
        return $string;
    }

    static public function sanitizeInt($int)
    {
        $int = filter_var($int, FILTER_SANITIZE_NUMBER_INT);

        return $int;
    }

    static public function sanitizeEmail($email)
    {
        $email = trim($email);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return $email;
    }
}
