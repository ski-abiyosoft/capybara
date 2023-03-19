# Capybara

> No dependency, just PHP!

## Overview
Database versioning could be boring, especially when you are a database administrator. We come to solve the problem. Managing database should be fun and chill like Capybara.

## How to Use it

### Creating Migration File

When you want to make a migration file you can run this command: 

> php capybara make:migration $file_name $table_name

$file_name: migration file name that you want to create. You can start with word 'create' to create table or 'modify' to modify a table. Example: 'create_table_test'.

$table_name: the table name that you want to create or modify. This is optional the Capybara will use the filename that you input as table name.

After run that command, you can check migration file in the Migrations folder. You can edit them if the auto generated table name is not same as you want.

## Migrating Database

Once you have made migration file, you can migrate it into your database by using this command:

> php capybara migrate

Capybara will make migrations table in your database as a list of migration files that have been migrated. Capybara will make cursor based on this table, so do not delete this table, or Capybara will migrate all files in the Migrations folder.

Hope you enjoy it, Bro.

Regards,

PT SKI DIY
