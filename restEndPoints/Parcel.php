<?php

Parcel::setDb($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $parcel = Parcel::loadAll();

    echo json_encode($parcel);

    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //tworzę obiekt
    $parcel = new Parcel();
    //ustawiamy własności
    $parcel->setAddressId($_POST['address_id']);
    $parcel->setSizeId($_POST['size_id']);
    $parcel->setUserId($_POST['user_id']);
    //zapis do bazy
    $parcel->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);
    $parcel = Parcel::load($patchVars['id']);
    $parcel->setAddressId($patchVars['address_id']);
    $parcel->setSizeId($patchVars['size_id']);
    $parcel->setUserId($patchVars['user_id']);
    $parcel->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);
    $parcelToDelete = Parcel::load($deleteVars['id']);
    $parcelToDelete->delete();
}

