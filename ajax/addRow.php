<?php
require_once '../functions.php';
$connection = connect_to_db();
$table_id = addslashes($_POST['table_id']);
$columns = get_columns_by_table_id($table_id);
$query = $connection->prepare('INSERT INTO ROWS(table_id) VALUES(?)');
if ($query->execute([$table_id]) === FALSE) {
    die(json_encode(['result' => 'error', 'msg' => 'Произошла ошибка, перезагрузите страницу']));
}
$row_id = $connection->lastInsertId();
ob_start();
include '../views/row.php';
$row = ob_get_clean();
die(json_encode(['result' => 'success', 'row' => $row]));