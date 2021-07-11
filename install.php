<?php

require_once 'functions.php';
error_reporting(E_ALL);
$columnNames = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];

$connection = connect_to_db();
$sqlQuery = file_get_contents(__DIR__ . '/sql/create_table.sql');
try {
    $connection->exec($sqlQuery);
    echo "Таблицы коррекно созданы<br>";
}
catch(Exception $exception) {
    echo "Произошлаа ошибка при создании таблиц: " . $exception->getMessage();
    die();
}
$tables = ['test_table_1', 'test_table_2'];
foreach ($tables as $table):
    $query = $connection->prepare("INSERT INTO tables (title) VALUES(?)");
    if ($query->execute([$table]) === FALSE) {
        echo "Произошлаа ошибка при добавлении элемента в таблицу TABLES ($table): " . var_export($connection->errorInfo(), true);
        die();
    }
    echo "В таблицу TABLES добавлено новый элемент: $table<br>";
    $table_id = $connection->lastInsertId();
    $columnsCount = rand(2, 9);
    $sqlQuery = "INSERT INTO columns (title, number, table_id)  VALUES";
    $elemArray = [];
    for($index = 0; $index < $columnsCount; $index++) {
        $sqlQuery .= "(?,?,?)";
        $elemArray = array_merge($elemArray, [$columnNames[$index], $index + 1, $table_id]);
        if ($index != $columnsCount -1)
            $sqlQuery .= ',';
    }
    $query = $connection->prepare($sqlQuery);
    if($query->execute($elemArray) === FALSE) {
        echo "Произошлаа ошибка при заполнении таблицы columns для $table: " . var_export($connection->errorInfo(), true);
        die();
    }
    echo "Таблица COLUMNS корректно заполнена для таблицы $table<br>";
    $rowsCount = rand(2, 9);
    $sqlQuery = "INSERT INTO rows (table_id) VALUES";
    $elemArray = [];
    for($index = 0; $index < $rowsCount; $index++) {
        $sqlQuery .="(?)";
        $elemArray[] = $table_id;
        if ($index != $rowsCount -1)
            $sqlQuery .= ',';
    }
    $query = $connection->prepare($sqlQuery);
    if($query->execute($elemArray) === FALSE) {
        echo "Произошлаа ошибка при заполнении таблицы rows для $table: " . var_export($connection->errorInfo(), true);
        die();
    }
    echo "Таблица ROWS корректно заполнена для $table<br>";
endforeach;

