<?php

use App\Facades\Schema;

include __DIR__ . "/../Facades/Schema.php";


Schema::new("tbl_siswa", function ($table) {
    $table->id();
    $table->string('name', 255);
    $table->text('address', 255);
});