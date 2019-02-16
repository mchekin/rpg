<?php

if (! function_exists('ini_size_to_kilo_bytes')) {

    function ini_size_to_kilo_bytes(string $value): float
    {
        $value = trim($value);
        $unitSymbol = strtoupper(substr($value, -1));

        $value = (float) $value;

        switch ($unitSymbol) {
            case 'B':
                return $value / 1024;
            case 'M':
                return $value * 1024;
            case 'G':
                return $value * 1048576;
            default:
                return $value;
        }
    }
}

if (! function_exists('ini_size_to_bytes')) {

    function ini_size_to_bytes(string $value): float
    {
        $value = trim($value);
        $unitSymbol = strtoupper(substr($value, -1));

        $value = (float) $value;

        switch ($unitSymbol) {
            case 'K':
                return $value * 1024;
            case 'M':
                return $value * 1048576;
            case 'G':
                return $value * 1073741824;
            default:
                return $value;
        }
    }
}

if (! function_exists('bytes_to_kilobytes')) {

    function bytes_to_kilobytes(float $bytes): float
    {
        return $bytes / 1024;
    }
}