<?php

Address::setDb($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $pathIdPath = isset($pathId) ? $pathId : null;
    if (!$pathIdPath) {
        $addresses = Address::loadAll();
    } else {
        $addresses = Address::load($pathIdPath);
    }
    echo json_encode($addresses);

    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = new Address($db->lastInsertId());
    
    $address->setCity($_POST['city']);
    $address->setCode($_POST['code']);
    $address->setStreet($_POST['street']);
    $address->setNumber($_POST['flat']);
    
    $address->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);
    
    $arrayAddress = Address::load($patchVars['id']);
    $address = new Address($patchVars['id']);
    
    $address->setCity($patchVars['city']);
    $address->setCode($patchVars['code']);
    $address->setStreet($patchVars['street']);
    $address->setNumber($patchVars['flat']);
    
    $address->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);
   
    $arrayAddressToDelete = Address::load($deleteVars['id']);
    
    $addressToDelete = new Address($deleteVars['id']);
    $addressToDelete->delete();
}
