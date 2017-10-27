<?php

Parcel::setDb($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $pathIdPath = isset($pathId) ? $pathId : null;
    if (!$pathIdPath) {
        $parcels = Parcel::loadAll();
    } else {
        $parcels = Parcel::load($pathIdPath);
    }
    echo json_encode($parcels);

    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //tworzę obiekt
    $parcel = new Parcel($db->lastInsertId());
    //ustawiamy własności
    $parcel->setUserId($_POST['user_id']);
    $parcel->setSizeId($_POST['size_id']);
    $parcel->setAddressId($_POST['address_id']);
    //zapis do bazy
    $parcel->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);

    $arrayParcel = Parcel::load($patchVars['id']);
    $parcel = new Parcel($patchVars['id']);

    $parcel->setUserId($patchVars['user_id']);
    $parcel->setSizeId($patchVars['size_id']);
    $parcel->setAddressId($patchVars['address_id']);

    $parcel->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);

    $arrayParcelToDelete = Parcel::load($deleteVars['id']);

    $parcelToDelete = new Parcel($deleteVars['id']);
    $parcelToDelete->delete();
}
