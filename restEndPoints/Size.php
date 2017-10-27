<?php

Size::setDb($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $pathIdPath = isset($pathId) ? $pathId : null;
    if (!$pathIdPath) {
        $sizes = Size::loadAll();
    } else {
        $sizes = Size::load($pathIdPath);
    }
    echo json_encode($sizes);

    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //tworzę obiekt
    $size = new Size($db->lastInsertId());
    //ustawiamy własności
    $size->setName($_POST['size']);
    $size->setPrice($_POST['price']);
    //zapis do bazy
    $size->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);

    $arraySize = Size::load($patchVars['id']);
    $size = new Size($patchVars['id']);

    $size->setName($patchVars['size']);
    $size->setPrice($patchVars['price']);

    $size->save();
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);

    $arraySizeToDelete = Size::load($deleteVars['id']);

    $sizeToDelete = new Size($deleteVars['id']);
    $sizeToDelete->delete();
}

