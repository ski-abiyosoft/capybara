<?php

include __DIR__ . "/vendor/autoload.php";

use Services\Migrator;
use Services\TestCase;

function migrate() {
    $migrator = new Migrator();
    $migrator->migrate();
}

function test() {
    $test = new TestCase();
    $test->run();
}

function make_migration(string $migration_name, bool $is_creation = true, string $table_name = null)
{
    $migrator = new Migrator();
    $migrator->createFile($migration_name, $is_creation, $table_name);
}