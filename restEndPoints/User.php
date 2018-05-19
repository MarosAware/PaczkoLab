<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    parse_str(file_get_contents("php://input"), $patchVars);
    User::setDb($db);

    if (isset($patchVars['id'])) {
        $user = User::load($patchVars['id']);
        $response =
            [
                [
                    'name' => $user->getName(),
                    'surname' => $user->getSurname(),
                    'credits' => $user->getCredits(),
                    'addressId' => $user->getAddress()
                ]
            ];
    } else {
        $response = User::loadAll();
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    parse_str(file_get_contents("php://input"), $patchVars);
    User::setDb($db);
    $user = new User();
    $user->setName($patchVars['name']);
    $user->setSurname($patchVars['surname']);
    $user->setCredits($patchVars['credits']);
    $user->setAddress($patchVars['address_option']);

    $result = $user->save();

    if ($result) {
        $response['success'] = $result;
    } else {
        $response['error'] = 'Can\'t save to db.';
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    User::setDb($db);
    parse_str(file_get_contents("php://input"), $patchVars);
    $user = User::load($patchVars['id']);
    $user->setName($patchVars['name']);
    $user->setSurname($patchVars['surname']);
    $user->setCredits($patchVars['credits']);
    $user->setAddress($patchVars['address_option']);

    $result = $user->save();

    if ($result) {
        $response['success'] = $result;
    } else {
        $response['error'] = 'Can\'t save to db.';
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $patchVars);
    User::setDb($db);
    $result = User::delete($patchVars['id']);

    if ($result) {
        $response['success'] = $result;
    } else {
        $response['error'] = 'Can\'t delete.';
    }

} else {
    $response['error'] = 'Wrong request method';
}
