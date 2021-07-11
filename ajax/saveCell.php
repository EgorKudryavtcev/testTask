<?php
require_once '../functions.php';
$column_id = addslashes($_POST['column_id']);
$row_id = addslashes($_POST['row_id']);
$value = trim(addslashes($_POST['value']));
$connection = connect_to_db();
$result = $connection->query("SELECT id FROM CELLS WHERE column_id = '$column_id' AND row_id = '$row_id'")->fetch();
if ($result) {
    $query = $connection->prepare("UPDATE CELLS SET column_id = ?,  row_id = ?, value = ? WHERE id = ?");
    $result = $query->execute([$column_id, $row_id, $value, $result['id']]);
}
else {
    $query = $connection->prepare('INSERT INTO CELLS (column_id, row_id, value) VALUE (?,?,?)');
    $result = $query->execute([$column_id, $row_id, $value]);
}
if ($result !== FALSE) {
    die(json_encode(['result' => 'success']));
}
die(json_encode(['result' => 'error', 'msg' => 'Произошла ошибка перезагрузите страницу']));