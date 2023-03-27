<?php

use Facades\Database;
use Facades\Importer;

return new Class {
    public function test(){
        Importer::import('test', 'sample_table');
    }
};