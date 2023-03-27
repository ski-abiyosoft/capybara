<?php

namespace Services;

use Facades\Database as DB;
use Facades\Schema;
use Interfaces\MigratorInterface;
use Throwable;

class Migrator implements MigratorInterface
{
    private $files;
    private $cursor;

    public function __construct()
    {
        $files = scandir(__DIR__ . "/../../Migrations", SCANDIR_SORT_ASCENDING);

        unset($files[0]);
        unset($files[1]);

        $this->files = array_values($files);
    }

    public function migrate(): void
    {
        $this->create_migration_table();
        $this->place_cursor();

        if (isset($this->files[$this->cursor])) {
            for  ($i = $this->cursor; $i < count($this->files); $i++) {
                $migration = include __DIR__ . "/../../Migrations/{$this->files[$i]}";
    
                try {
                    // Do migration process
                    $migration->up();
    
                    // Record migration file
                    $this->record($this->files[$i]);
    
                    echo "Done \n";
                }catch (Throwable $e) {
                    echo "Migration failed!";
                }
            }
        }else {
            echo "Nothing to migrate.";
        }
    }

    public function createFile(string $migration_name, bool $is_creation = true, string $table_name = null): void
    {
        $year = date("Y");
        $month = date("m");
        $date = date("d");
        $timestamp = strtotime("now");
        $table = $table_name ?? "table_name";

        $file = new File(__DIR__ . "/../../Migrations/{$year}{$month}{$date}{$timestamp}_{$migration_name}.php");
        
        if ($is_creation) {
            $file->write("<?php \n\nuse Facades\Schema;\n\nreturn new Class {\n    public function up()\n    {\n        Schema::new('{$table}', function (\$table) {\n            // code here\n        });\n    }\n};");
        }else {
            $file->write("<?php \n\nuse Facades\Schema;\n\nreturn new Class {\n    public function up()\n    {\n        Schema::modify('{$table}', function (\$table) {\n            // code here\n        });\n    }\n};");
        }

        $file->close();
    }

    private function create_migration_table()
    {
        // Creating migrations table
        echo Schema::new('migrations', function ($table) {
            $table->id();
            $table->string('filename');
        });
    }

    private function record(string $filename): void
    {
        DB::table('migrations')->insert(['filename' => $filename]);
    }

    private function place_cursor()
    {
        // Find the last migrated file
        $migration = DB::table('migrations')->select()
                        ->orderBy('id', 'DESC')
                        ->limit(1)->get();
        $last_migrated_file = isset($migration[0]['filename']) ? $migration[0]['filename'] : '';

        $index = array_search($last_migrated_file, $this->files);

        if ($index !== FALSE) {
            $this->cursor = $index+1;
        }else {
            $this->cursor = 0;
        }
    }
}