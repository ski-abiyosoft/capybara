<?php 

namespace Helpers;

class Table
{
    private $query_string;
    private $db_type;

    public function __construct(string $table_name, bool $is_creation, string $db_type)
    {
        $this->db_type = $db_type;

        if ($is_creation) {
            $this->query_string = "CREATE TABLE $table_name (";
        }else {
            $this->query_string = "ALTER TABLE $table_name ADD (";
        }
    }

    /**
     * Initialize table creation
     * 
     * @param string $table_name
     */
    public static function create_table(string $table_name, string $db_type = "mysql")
    {
        return new self($table_name, true, $db_type);
    }

    /**
     * Initialize table modifiying
     * 
     * @param string $table_name
     */
    public static function modify_table(string $table_name, string $db_type = "mysql")
    {
        return new self($table_name, false, $db_type);
    }

    /**
     * Creating id column and treated as primary key
     */
    public function id()
    {
        if ($this->db_type == 'mysql') {
            $this->query_string .= " id BIGINT NOT NULL AUTO_INCREMENT, PRIMARY KEY (id),";
        }else {
            $this->query_string .= " id BIGINT NOT NULL IDENTITY(1,1) PRIMARY KEY,";
        }
    }

    /**
     * Creating identity column (SQL Server only)
     */
    public function identity()
    {
        $this->query_string .= " id BIGINT NOT NULL IDENTITY(1,1),";
    }

    /**
     * Creating varchar column
     * 
     * @param string $column_name
     * @param int $length
     */
    public function string(string $column_name, int $length = 255)
    {
        $this->query_string .= " $column_name varchar($length),";
    }

    /**
     * Creating tiny text column
     * 
     * @param string $column_name
     */
    public function tinyText(string $column_name)
    {
        $this->query_string .= " $column_name TINYTEXT,";
    }

    /**
     * Creating tiny text column
     * 
     * @param string $column_name
     */
    public function text(string $column_name)
    {
        $this->query_string .= " $column_name TEXT,";
    }

    /**
     * Creating tiny text column
     * 
     * @param string $column_name
     */
    public function mediumText(string $column_name)
    {
        $this->query_string .= " $column_name MEDIUMTEXT,";
    }

    /**
     * Creating tiny text column
     * 
     * @param string $column_name
     */
    public function longText(string $column_name)
    {
        $this->query_string .= " $column_name LONGTEXT,";
    }

    /**
     * Creating integer column
     * 
     * @param string $column_name
     */
    public function integer(string $column_name)
    {
        $this->query_string .= " $column_name INT,";
    }

    /**
     * Creating float column
     * 
     * @param string $column_name
     */
    public function decimal(string $column_name, int $digit = 14, int $precision = 2)
    {
        $this->query_string .= " $column_name decimal($digit,$precision),";
    }

    /**
     * Creating date column
     * 
     * @param string $column_name
     */
    public function date(string $column_name)
    {
        $this->query_string .= " $column_name date,";
    }

    /**
     * Creating datetime column
     * 
     * @param string $column_name
     */
    public function datetime(string $column_name)
    {
        $this->query_string .= " $column_name datetime,";
    }

    /**
     * Return query string 
     */
    public function get_query_string()
    {
        $this->query_string = substr_replace($this->query_string, "", -1);

        $this->query_string .= " )";

        return $this->query_string;
    }
}