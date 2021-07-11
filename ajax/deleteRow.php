<?php
require_once '../functions.php';
$connection = connect_to_db();
$row_id = addslashes($_POST['row_id']);
$query = $connection->prepare('DELETE FROM ROWS WHERE id = ?');
if ($query->execute([$row_id]) === FALSE) {
    die(json_encode(['result' => 'error', 'msg' => 'Произошла ошибка, перезагрузите страницу']));
}
die(json_encode(['result' => 'success']));