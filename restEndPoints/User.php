<?php

User::setDb($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $pathIdPath = isset($pathId) ? $pathId : null;
    if (!$pathIdPath) {
        $users = User::loadAll();
    } else {
        $users = User::load($pathIdPath);
    }
    echo json_encode($users);

    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User($db->lastInsertId());

    $user->setName($_POST['name']);
    $user->setSurname($_POST['surname']);
    $user->setCredits($_POST['credits']);
    $user->setUserAddressId($_POST['address_id']);

    $user->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);

    $arrayUser = User::load($patchVars['id']);
    $user = new User($patchVars['id']);
    $user->setName($patchVars['name']);
    $user->setSurname($patchVars['surname']);
    $user->setCredits($patchVars['credits']);
    $user->setUserAddressId($patchVars['address_id']);

    $user->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);

    $arrayUserToDelete = User::load($deleteVars['id']);

    $userToDelete = new User($deleteVars['id']);
    $userToDelete->delete();
}
