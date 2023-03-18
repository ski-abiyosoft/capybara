<?php

namespace Database;

use Database\Implementations\Mysql;
use stdClass;

include __DIR__ . "/Implementations/Mysql.php";

class Database 
{
    private $connection;

    public function __construct()
    {
        $settings = json_decode(file_get_contents(__DIR__ . "/../../settings.json"));
        
        switch ($settings->driver) {
            case 'mysql':
                $this->connection = new Mysql(
                    $settings->host, 
                    $settings->username, 
                    $settings->password, 
                    $settings->database);
                break;
            default:
                $this->connection = new Mysql(
                    $settings->host, 
                    $settings->username, 
                    $settings->password, 
                    $settings->database);
                break;
        }
    }

    public function test()
    {
        $this->connection->test();
    }

    /**
     * Executing query string
     * 
     * @param string $query_string
     */
    public function exec(string $query_string): void
    {
        $this->connection->make_query($query_string);
    }
}