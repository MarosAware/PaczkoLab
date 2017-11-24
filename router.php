<?php

//Load all class
require (__DIR__ . '/config.php');

$m = $_SERVER["REQUEST_METHOD"];
$a = preg_replace('/^\/router.php/','',$_SERVER["REQUEST_URI"]);
$res = [];
$db = new DBmysql();

if($m === "GET" && $a === "/size/") {
    Size::setDb($db);
    $res = Size::loadAll();
} elseif ($m === "DELETE" && $a === "/size/") {
    parse_str(file_get_contents("php://input"), $params);
    Size::setDb($db);
    $success = Size::delete($params["id"]);
    $res["success"] = $success;
} else {
    header('Content-Type: application/json+error');
    header('X-PHP-Response-Code: 404', true, 404);
    echo "{error:\"NOT IMPLEMENTED\"}";
    die;
}

header('Content-Type: application/json');
echo json_encode($res);