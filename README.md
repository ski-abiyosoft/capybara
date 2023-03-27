# Capybara

> No dependency, just PHP!

## Overview
Database versioning could be boring, especially when you are a database administrator. We come to solve the problem. Managing database should be fun and chill like Capybara.

## How to Use it

### Installing App

Once you have download this package, we assume that you have installed PHP CLI and Composer in your computer. You can run `composer install`, then you can use this program as you go.

### Creating Migration File

When you want to make a migration file you can run this command: 

> `php capybara make:migration $file_name $table_name`

$file_name: migration file name that you want to create. You can start with word 'create' to create table or 'modify' to modify a table. Example: 'create_table_test'.

$table_name: the table name that you want to create or modify. This is optional the Capybara will use the filename that you input as table name.

After run that command, you can check migration file in the Migrations folder. You can edit them if the auto generated table name is not same as you want.

### Creating Column

When you want to adding column to your table, use table helper to create specified column. You can read the available function in the next session.

Example:

```
Schema::new('users', function ($table) {
    $table->id();
    $table->string('username');
    $table->date('date_of_birth');
})
```

### Migrating Database

Once you have made migration file, you can migrate it into your database by using this command:

> `php capybara migrate`

Capybara will make migrations table in your database as a list of migration files that have been migrated. Capybara will make cursor based on this table, so do not delete this table, or Capybara will migrate all files in the Migrations folder.

#### Available Function

Capybara has many built ini method for creating table column such as varchar, integer, date, etc. We provide some usefull method listed in the table below:

|Command|Explaination|
|-------|------------|
|`$table->id()`| Creating `id` column with auto increment and used as primary key. |
|`$table->string($name, $length)`| Creating `VARCHAR` column with given `$name` and `$length`. |
|`$table->tinyText($name)`| Creating `TINY TEXT` column with given `$name`. |
|`$table->text($name)`| Creating `TEXT` column with given `$name`. |
|`$table->mediumText($name)`| Creating `MEDIUM TEXT` column with given `$name`. |
|`$table->longText($name)`| Creating `LONG TEXT` column with given `$name`. |
|`$table->integer($name)`| Creating `INT` column with given `$name`. |
|`$table->decimal($name, $length, $precision)`| Creating `DECIMAL` column with given `$name`, `$length`, and `$pecision`. |
|`$table->date($name)`| Creating `DATE` column with given `$name`. |
|`$table->datetime($name)`| Creating `DATETIME` column with given `$name`. |

### Inserting data

Sometimes you may not perform a creating or modifying table, but inserting into existing table. This might be happen when your application store a static table as a master table. Static table often used on application setting parameters and there is no GUI to add it into the table.

Thankfully, Capybara can do this operation by using `Database` facade. You can use `Database` facade inside your migration file.

For inserting data into your table you run `Database::table($table_name)->insert($data_set)`. The `$table_name` is the targeted table that you want to insert, while the `$dataset` is associative array with `$key` as table's column while the `$value` is value that you want to insert. Example:

`Database::table('sample_table')->insert(['name' => 'John Doe', 'city' => 'London']);` 

This syntax will insert into sample table with value 'John Doe' on 'name' column and value 'London' on 'city' column.

### Importing data

Capybara also can be used to import data from `.CSV` type file into you table. You can run `php capybara import $filename $table_name` to start an import operation. The `$filename` parameter is the filename inside `CSV` folder, while the `$table_name` is the targeted table in your database. You may not pass the `$table_name` parameter if your filename and targeted table are same. 

Capybara also support bulk import. You can run `php capybara import all` to start migrating all files inside `CSV` folder. When performing bulk import, you must set your `.csv` file name same as your targeted table, or the operation will fail.

Hope you enjoy it, Bro.

Regards,

PT SKI DIY
