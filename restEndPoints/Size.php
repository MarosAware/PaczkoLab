<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    Size::setDb($db);

    if (isset($pathId)) {
        $size = Size::load($pathId);
        $response =
            [
                [
                    'size' => $size->getSize(),
                    'price' => $size->getPrice(),
                ]
            ];
    } else {
        $response = Size::loadAll();
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    parse_str(file_get_contents("php://input"), $patchVars);
    Size::setDb($db);
    $size = new Size();
    $size->setSize($patchVars['size']);
    $size->setPrice($patchVars['price']);

    $result = $size->save();

    if ($result) {
        $response['success'] = $result;
    } else {
        $response['error'] = 'Can\'t save to db.';
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    Size::setDb($db);
    parse_str(file_get_contents("php://input"), $patchVars);
    $size = Size::load($patchVars['id']);
    $size->setSize($patchVars['size']);
    $size->setPrice($patchVars['price']);
    $result = $size->update();

    if ($result) {
        $response['success'] = $result;
    } else {
        $response['error'] = 'Can\'t save to db.';
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $patchVars);
    Size::setDb($db);
    $result = Size::delete($patchVars['id']);

    if ($result) {
        $response['success'] = $result;
    } else {
        $response['error'] = 'Can\'t delete.';
    }

} else {
    $response['error'] = 'Wrong request method';
}
