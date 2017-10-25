<?php

User::setDb($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!is_null($pathId)) {
        $users = User::loadAll();
        $jsonUsers = [];
        foreach ($users as $user) {
            $jsonUsers[] = json_decode(json_encode($user), true);
        }
        $response = ['response' => $jsonUsers];
    } else {
        $users = User::load($pathId);
    }
    echo json_encode($users);

    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();

    $user->setName($_POST['name']);
    $user->setSurname($_POST['surname']);
    $user->setCredits($_POST['credits']);
    $user->setUserAddressId($_POST['address_id']);

    $user->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);

    $user = User::load($patchVars['id']);

    $user->setName($patchVars['name']);
    $user->setSurname($patchVars['surname']);
    $user->setCredits($patchVars['credits']);
    $user->setUserAddressId($patchVars['address_id']);

    $user->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);

    $userToDelete = User::load($deleteVars['id']);

    $userToDelete->delete();
}
