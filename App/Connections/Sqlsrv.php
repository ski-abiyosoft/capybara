<?php

namespace Connections;

use Exception;
use Interfaces\ConnectionInterface;
use stdClass;

class Sqlsrv implements ConnectionInterface
{
    private $connection;
    private $result;

    public function __construct(string $host, string $user, string $pwd, string $db)
    {
        $connection_info = [
            "Database" => $db,
            "UID" => $user,
            "PWD" => $pwd
        ];

        $this->connection = sqlsrv_connect($host, $connection_info);
    }

    /**
     * Make a query
     */
    public function make_query(string $query_string): bool
    {
        try {
            $this->result = sqlsrv_query($this->connection, $query_string);
            
            return true;
        }catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get query result
     */
    public function get(): array
    {
        $result = [];

        try {
            if ($this->result) {
                while ($row = sqlsrv_fetch_object($this->result)) {
                    array_push($result, $row);
                }
    
                return $result;
            }
            
            return [];
        }catch (Exception $e) {
            return $result;
        }
    }

    public function test()
    {
        if (!$this->connection) {
            echo "Not connected, error!";
        }else {
            echo "Connected.";
        }
    }
}