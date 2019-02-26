<?php

namespace App\Twig;

class AppExtension extends \Twig\Extension\AbstractExtension implements \Twig\Extension\GlobalsInterface
{
    public static $data;

    public static function setGlobals($value = 99999999999)
    {
        self::$data = $value;
    }

    public function getGlobals()
    {
        return [
            'this' => self::$data,
        ];
    }

}