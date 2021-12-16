<?php

namespace App\Core;

use Exception;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\DB;

class Database
{
    function __construct()
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => DBDRIVER,
            'host' => DBHOST,
            'database' => DBNAME,
            'username' => DBUSER,
            'password' => DBPASS,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        $capsule->connection()->getPdo();
        Capsule::raw("SET time_zone='" . TIME_ZONE . "'");
    }
    public static function migration($function)
    {
        $migrations = glob('app/database/migration/*.php', GLOB_NOESCAPE);
        foreach ($migrations as $migration) {
            preg_match("/(\w+).php/", $migration, $class);
            $class = array_slice(explode('_', $class[1]), 1);
            $class = call_user_func_array(function ($value, $value2, $value3) {
                return ucfirst($value) . ucfirst($value2) . ucfirst($value3);
            }, $class);
            require_once $migration;
            (new $class)->$function();
        }
    }
    public static function dropTables()
    {
        Capsule::schema()->dropAllTables();
    }

    public static function seeders()
    {
        $seeders = glob('app/database/seeders/*.php', GLOB_NOESCAPE);
        foreach ($seeders as $seeders) {
            preg_match("/(\w+).php/", $seeders, $seeders);
            $seeders = "App\\Database\\Seeders\\" . $seeders[1];
            (new $seeders)->run();
        }
    }
}
