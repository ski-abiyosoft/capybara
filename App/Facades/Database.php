<?php

namespace Facades;

use Services\Database as DB;

class Database
{
    private $db;
    private $table_name;
    private $query_string;

    public function __construct(string $table_name = '')
    {
        $this->db = new DB();
        $this->table_name = $table_name;
    }

    /**
     * Selecting table
     */
    public static function table(string $table_name)
    {
        $db = new self($table_name);

        return $db;
    }

    /**
     * Initialize select statement
     */
    public function select(string ...$columns)
    {   
        $select_stmt = "SELECT ";

        if (isset($columns[0])) {
            foreach ($columns as $column) {
                $select_stmt .= "{$column}, ";
            }
    
            $this->query_string = substr_replace($select_stmt, "", -2);
        }else {
            $this->query_string = $select_stmt . "*";
        }

        return $this;
    }

    /**
     * Adding where statement
     */
    public function where(...$statements)
    {
        if (!(strpos($this->query_string, 'FROM') !== false)) {
            $this->query_string .= " FROM {$this->table_name}";
        }

        if (strpos($this->query_string, 'WHERE') !== false) {
            $where_stmt = " AND ";
        }else {
            $where_stmt = " WHERE ";
        }

        if (is_array($statements[0])){
            foreach ($statements[0] as $statement_key => $statement_value) {
                if ($statement_key !== 0) {
                    $where_stmt .= "AND ";
                }

                if (isset($statement_value[2])) {
                    $where_stmt .= "{$statement_value[0]} {$statement_value[1]} {$statement_value[2]}";
                }else {
                    $where_stmt .= "{$statement_value[0]} = {$statement_value[1]}";
                }
            }
        }else {
            if (isset($statements[2])) {
                $where_stmt .= "{$statements[0]} {$statements[1]} {$statements[2]}";
            }else {
                $where_stmt .= "{$statements[0]} = {$statements[1]}";
            }
        }

        $this->query_string .= $where_stmt;

        return $this;
    }

    /**
     * Limiting query
     */
    public function limit(int $limit)
    {
        if (!(strpos($this->query_string, 'FROM') !== false)) {
            $this->query_string .= " FROM {$this->table_name}";
        }
        
        if ($this->db->db_type == 'sqlsrv') {
            $this->query_string = "SELECT TOP {$limit}" . substr_replace($this->query_string, "", 0, 6);
        }else {
            $this->query_string .= " LIMIT {$limit}";
        }

        return $this;
    }

    /**
     * Odering result
     */
    public function orderBy(string $column, string $type = 'ASC')
    {
        if (!(strpos($this->query_string, 'FROM') !== false)) {
            $this->query_string .= " FROM {$this->table_name}";
        }

        if (strpos($this->query_string, 'ORDER') !== false) {
            $order_stmt = ", ";
        }else {
            $order_stmt = " ORDER BY ";
        }

        $order_stmt .= "{$column} {$type}";

        $this->query_string .= $order_stmt;

        return $this;
    }

    /**
     * Getting result query
     */
    public function get(): array
    {
        $this->db->exec($this->query_string);

        return $this->db->get();
    }

    /**
     * Inserting into table
     */
    public function insert(array $data_set)
    {
        $columns = "";
        $values = "";

        foreach ($data_set as $key => $value) {
            $columns .= $key . ", ";
            
            if (is_numeric($value)) {
                $values .= $value . ", ";
            }else {
                $values .= "'{$value}'" . ", ";
            }
        }

        $columns = substr_replace($columns, "", -2);
        $values = substr_replace($values, "", -2);

        $insert_stmt = "INSERT INTO {$this->table_name} ( {$columns} ) VALUES ( {$values} )";

        $this->query_string = $insert_stmt;

        $this->db->exec($this->query_string);
    }

    /**
     * Debug query string
     */
    public function getQueryString()
    {
        return $this->query_string;
    }
}