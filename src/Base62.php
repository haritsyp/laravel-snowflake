<?php

namespace Haritsyp\Snowflake;

class Base62
{
    private const CHARS = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    public static function encode($num)
    {
        if ($num === 0) return '0';
        $result = '';
        while ($num > 0) {
            $remainder = $num % 62;
            $result = self::CHARS[$remainder] . $result;
            $num = intdiv($num, 62);
        }
        return $result;
    }

    public static function decode($str)
    {
        $num = 0;
        $len = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $c = $str[$i];
            if ('0' <= $c && $c <= '9') $val = ord($c) - ord('0');
            elseif ('A' <= $c && $c <= 'Z') $val = ord($c) - ord('A') + 10;
            elseif ('a' <= $c && $c <= 'z') $val = ord($c) - ord('a') + 36;
            else throw new \Exception("Invalid Base62 char: $c");
            $num = $num * 62 + $val;
        }
        return $num;
    }
}
