<?php

namespace App\Core;

class Input
{
    public static function get(string $param, int $filter = FILTER_SANITIZE_STRING): mixed
    {
        return filter_input(INPUT_GET, $param, $filter);
    }
    public static function post(string $param, int $filter = FILTER_SANITIZE_STRING): mixed
    {
        return filter_input(INPUT_POST, $param, $filter);
    }
}
