<?php
require_once '../functions.php';
$connection = connect_to_db();
$row_id = addslashes($_POST['row_id']);
$color = '#' . (isset($_POST['color']) && !empty($_POST['color']) ? addslashes($_POST['color']) : generate_color());
$query = $connection->prepare('UPDATE rows SET color = ? WHERE id = ?');
if ($query->execute([$color, $row_id]) === FALSE) {
    die(json_encode(['result' => 'error', 'msg' => 'Произошла ошибка, перезагрузите страницу']));
}
die(json_encode(['result' => 'success', 'color' => $color]));