<?php

include __DIR__ . "/vendor/autoload.php";

use Facades\Importer;
use Services\Migrator;
use Services\TestCase;

class App 
{
    public static function migrate() 
    {
        $migrator = new Migrator();
        $migrator->migrate();
    }
    
    public static function test() 
    {
        $test = new TestCase();
        $test->run();
    }
    
    public static function make_migration(string $migration_name, bool $is_creation = true, string $table_name = null)
    {
        $migrator = new Migrator();
        $migrator->createFile($migration_name, $is_creation, $table_name);
    }

    public static function import(string $filename = null, string $table_name = null)
    {
        if ($filename !== 'all') {
            Importer::import($filename, $table_name);
        }else {
            Importer::importAll();
        }
    }
};