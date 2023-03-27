<?php

namespace Services;

use Connections\Mysql;
use Connections\Sqlsrv;
use Interfaces\DatabaseInterface;

class Database implements DatabaseInterface
{
    private $connection;
    public $db_type;

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
                
                $this->db_type = 'mysql';
                break;
            case 'sqlsrv':
                $this->connection = new Sqlsrv(
                    $settings->host, 
                    $settings->username, 
                    $settings->password, 
                    $settings->database);

                $this->db_type = 'sqlsrv';
                break;
            default:
                $this->connection = new Mysql(
                    $settings->host, 
                    $settings->username, 
                    $settings->password, 
                    $settings->database);

                $this->db_type = 'mysql';
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
    public function exec(string $query_string): bool
    {
        return $this->connection->make_query($query_string);
    }

    /**
     * Get query result as array
     */
    public function get(): array
    {
        return $this->connection->get();
    }
}