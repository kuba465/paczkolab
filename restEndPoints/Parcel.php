<?php

Parcel::setDb($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $parcels = Parcel::loadAll();
    echo json_encode($parcels);
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //tworzę obiekt
    $parcel = new Parcel();
    //ustawiamy własności
    $parcel->setUserId($_POST['user_id']);
    $parcel->setSizeId($_POST['size_id']);
    $parcel->setAddressId($_POST['address_id']);
    //zapis do bazy
    $parcel->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);
    $parcel = Parcel::load($patchVars['id']);
    $parcel->setUserId($patchVars['user_id']);
    $parcel->setSizeId($patchVars['size_id']);
    $parcel->setAddressId($patchVars['address_id']);
    $parcel->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);
    $parcelToDelete = Parcel::load($deleteVars['id']);
    $parcelToDelete->delete();
}
