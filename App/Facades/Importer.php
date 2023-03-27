<?php

namespace Facades;

use Services\File;

class Importer
{
    /**
     * Start import operation 
     */
    public static function import(string $filename, string $table_name): void
    {
        $file = new File();
        $file->open(__DIR__ . "/../../CSV/{$filename}.csv");

        $columns = fgetcsv($file->getStream());

        while ($row = fgetcsv($file->getStream())) {
            $data_set = [];

            foreach ($columns as $key => $value) {
                $data_set[$value] = $row[$key];
            }

            Database::table($table_name)->insert($data_set);
        }

        echo 'Data has been imported succesfully';
    }

    /**
     * Perform bulk import
     */
    public static function importAll()
    {
        $files = scandir(__DIR__ . "/../../CSV", SCANDIR_SORT_ASCENDING);

        unset($files[0]);
        unset($files[1]);

        $list = array_values($files);

        for ($i = 0; $i < count($list); $i++) {
            $exploded = explode('.', $list[$i]);

            $file = new File();
            $file->open(__DIR__ . "/../../CSV/{$exploded[0]}.csv");

            $columns = fgetcsv($file->getStream());

            while ($row = fgetcsv($file->getStream())) {
                $data_set = [];

                foreach ($columns as $key => $value) {
                    $data_set[$value] = $row[$key];
                }

                Database::table($exploded[0])->insert($data_set);
            }
        }

        echo 'All data have been imported succesfully';
    }
}