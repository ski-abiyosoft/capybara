<?php

namespace App\Facades;

include __DIR__ . '/../Database/Database.php';
include __DIR__ . '/../Helpers/Table.php';

/**
 * +===============================
 * + Database
 * +===============================
 * Here we load database class an can be use later
 */

class Schema
{
    private $query_string;

    public static function test()
    {
        $database = new \Database\Database();

        $database->test();
    }

    private static function exec(string $query_string)
    {
        $database = new \Database\Database();

        $database->exec($query_string);
    }

    public static function new(string $table_name, callable $callback)
    {
        $table = \App\Helpers\Table::create_table($table_name);

        $callback($table);

        // return $table->get_query_string();

        self::exec($table->get_query_string());
    }

    public static function modify(string $table_name, callable $callback)
    {
        $table = \App\Helpers\Table::modify_table($table_name);

        $callback($table);

        // return $table->get_query_string();

        self::exec($table->get_query_string());
    }
}