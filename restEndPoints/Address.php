<?php

Address::setDb($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $addresses = Address::loadAll();
    echo json_encode($addresses);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = new Address();
    $address->setCity($_POST['city']);
    $address->setCode($_POST['code']);
    $address->setStreet($_POST['street']);
    $address->setNumber($_POST['flat']);
    $address->save();
}
if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);
    $address = Address::load($patchVars['id']);
    $address->setCity($patchVars['city']);
    $address->setCode($patchVars['code']);
    $address->setStreet($patchVars['street']);
    $address->setNumber($patchVars['flat']);
    $address->save();
}
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);
    $addressToDelete = Address::load($deleteVars['id']);
    $addressToDelete->delete();
}
