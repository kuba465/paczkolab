<?php

Size::setDb($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sizes = Size::loadAll();

    echo json_encode($sizes);

    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //tworzę obiekt
    $size = new Size();
    //ustawiamy własności
    $size->setName($_POST['size']);
    $size->setPrice($_POST['price']);
    //zapis do bazy
    $size->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);
    $size = Size::load($patchVars['id']);
    $size->setName($patchVars['size']);
    $size->setPrice($patchVars['price']);
    $size->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);
    $sizeToDelete = Size::load($deleteVars['id']);
    $sizeToDelete->delete();
}

