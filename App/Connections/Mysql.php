<?php

namespace Connections;

use Exception;
use Interfaces\ConnectionInterface;
use mysqli;

class Mysql implements ConnectionInterface
{
    private $connection;
    private $result;

    public function __construct(string $host, string $username, string $pwd, string $database)
    {
        $this->connection = mysqli_connect($host, $username, $pwd, $database);
    }

    public function make_query(string $query_string): bool
    {
        try {
            $this->result = mysqli_query($this->connection, $query_string);
            
            return true;
        }catch (Exception $e) {
            return false;
        }
    }

    public function get(): array
    {
        $result = [];
        try {
            if ($this->result) {
                while ($row = mysqli_fetch_object($this->result)){
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