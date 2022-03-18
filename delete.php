<?php
require_once 'inc/functions.php';
require_once 'inc/headers.php';

$input = json_decode(file_get_contents('php://input'));
$id = filter_var($input->id,FILTER_SANITIZE_SPECIAL_CHARS);



try {
$db = openDb();

$query = $db->prepare('delete from item where id=(:id)');
$query->bindValue(':id',$id,PDO::PARAM_INT);
$query->execute();

header('HTTP/1.1 200 OK');
$data = array('id' => $id);
print json_encode($data);
} catch (PDOException $pdoex) {
    header('HTTP/1.1 500 internal server error');
    $error = array('error' => $pdoex->getMessage());
    print json_encode($error);
}
