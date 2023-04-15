<?php

/**
 * membuat id dengan awalan 0 sebanyak minimal $digit
 */
if (!function_exists('prefix_zero')) {
    function prefix_zero(int $int, $digit = 6)
    {
        $ln = strlen($int);

        $repeat = $ln < $digit ? str_repeat(0, ($digit - $ln)) : '';
        return $repeat . $int;
    }
}
