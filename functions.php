<?php
    if (!function_exists('settings')) {
        function settings() {
            return  json_decode(file_get_contents(__DIR__ .'/.settings'), true);
        }
    }

    if (!function_exists('setting')) {
        function setting($param) {
            return settings()[$param];
        }

    }

    if (! function_exists('connect_to_db')) {
        function connect_to_db()
        {
            $setts = settings();
            return isset($GLOBALS['connection']) ? $GLOBALS['connection'] : $GLOBALS['connection'] = new PDO('mysql:host=' . $setts['dserver'] . ';dbname=' . $setts['dbase'], $setts['duser'], $setts['dpass']);
        }
    }

    if (!function_exists('get_tables')) {
        function get_tables() {
            $connection = connect_to_db();
            return $connection->query('SELECT * FROM TABLES', PDO::FETCH_ASSOC);
        }
    }


    if (!function_exists('get_columns_by_table_id')) {
        function get_columns_by_table_id($table_id) {
            $connection = connect_to_db();
            return $connection->query("SELECT * FROM COLUMNS WHERE table_id = '$table_id' ORDER BY 'number';")->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    if (!function_exists('get_rows_by_table_id')) {
        function get_rows_by_table_id($table_id) {
            $connection = connect_to_db();
            return $connection->query("SELECT * FROM ROWS WHERE table_id = '$table_id';")->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    if (!function_exists('get_table_by_id')) {
        function get_table_by_id($table_id) {
            $connection = connect_to_db();
            return $connection->query("SELECT * FROM TABLES WHERE id = '$table_id';")->fetch(PDO::FETCH_ASSOC);
        }
    }

    if (!function_exists('get_cells')) {
        function get_cells($table_id) {
            $connection = connect_to_db();
            $arrayCells = [];
            $result =  $connection->query("SELECT c.column_id,c.row_id,c.value FROM CELLS as c JOIN COLUMNS as co on co.id = c.column_id WHERE co.table_id =  '$table_id'");
            if ($result === FALSE) {
                throw new Exception('Произошла ошибка, при получении ячеек таблицы');
            }
            $result = $result->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $r) {
                $arrayCells[$r['column_id']][$r['row_id']] = $r;
            }
            return $arrayCells;
        }
    }

    if (!function_exists('generate_color')) {
        function generate_color() {
            return substr(md5(date('Y-m-d H:s:i')), 0, 6);
        }
    }
