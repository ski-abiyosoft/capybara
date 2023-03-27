<?php 

use Facades\Schema;

return new Class {
    public function up()
    {
        Schema::new('sample_table', function ($table) {
            // code here
            $table->id();
            $table->string('name', 30);
            $table->date('tanggal_lahir');
        });
    }
};