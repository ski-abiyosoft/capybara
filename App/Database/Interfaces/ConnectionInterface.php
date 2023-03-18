<?php

namespace Database\Interfaces;

interface ConnectionInterface
{
    public function make_query(string $query_string): void;
}