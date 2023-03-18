<?php

namespace Database\Implementations;

use Error;
use Exception;
use mysqli;

include __DIR__ . "/../Interfaces/ConnectionInterface.php";

class Mysql implements \Database\Interfaces\ConnectionInterface
{
    private $connection;

    public function __construct(string $host, string $username, string $pwd, string $database)
    {
        $this->connection = mysqli_connect($host, $username, $pwd, $database);
    }

    public function make_query(string $query_string): void
    {
        try {
            mysqli_query($this->connection, $query_string);
            echo "Query has been executed succesfully!";
        }catch (Exception $e) {
            echo mysqli_error($this->connection);
        }
    }

    public function test()
    {
        if (!$this->connection) {
            echo "Not connected, error: " . mysqli_connect_error();
        }else {
            echo "Connected.";
        }
    }
}