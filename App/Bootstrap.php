<?php

function migrate() {
    $files = scandir(__DIR__ . "/Migrations");

    unset($files[0]);
    unset($files[1]);

    foreach ($files as $key => $value) {
        $path = __DIR__ . "/Migrations/$value";

        echo `php $path`;
    }
}