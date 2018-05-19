<?php

//Load all class
require (__DIR__ . '/config.php');

$db = new DBmysql();

if ($db->getError()) {
    $response['DB_error'] = 'DB Connection error: ' . $db->getError();
}

######### Dynamic load php class file depend on request #########
$pathInfo = $_SERVER['PATH_INFO'];

$arrPath = explode('/', $pathInfo);
$requestClass = $arrPath[1];

$requestClass = preg_replace('/[^a-zA-Z0-9]/', '', $requestClass);
$className = ucfirst(strtolower($requestClass));

$classFile = __DIR__ . '/class/' . $className . '.php';
require_once $classFile;

######### End dynamic load #########

$pathId = !empty($arrPath[2]) ? $arrPath[2] : null;

if ($pathId) {
    $pathId = preg_replace('/[a-zA-Z\s_]/', '', $pathId);
}

if (!isset($response['DB_error'])) { //if no db error
    include_once __DIR__ . '/restEndPoints/' . $className . '.php';

} else {
    header("HTTP/1.0 500 Internal Server Error");
}

header('Content-Type: html');//return json header

if (isset($response['error'])) {
    header("HTTP/1.0 400 Bad Request");
}

echo json_encode($response);
