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

/**
 * membuat id dengan awalan 0 sebanyak minimal $digit
 */
if (!function_exists('job_type_code_map')) {
    function job_type_code_map(string $job_type_code)
    {
        switch ($job_type_code){
            case "DRSP":
                $code = "DRSP"; break;
            case "MHSA":
            case "COAS":
            case "NURS":
                $code = "MHSA"; break;
            default:
                $code = 'DRGN';
        }

        return $code;
    }
}

if (!function_exists('exclude_user_ids')) {
    function exclude_user_ids()
    {
        return [42,182,790,791,792];
    }
}
