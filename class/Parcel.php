<?php

class Parcel implements Action {

    /**
     *
     * @var DBmysql $db
     */
    public static $db;
    private $id = -1;
    private $user_id = '';
    private $size_id = 0;
    private $address_id = '';

    public function delete() {
        $parcel = Parcel::load($this->getId());
        $sql = "DELETE FROM Size WHERE id=" . $parcel->getId();
        self::$db->query($sql);
        self::$db->execute();
    }

    public function save() {
        if ($this->id > 0) {
            //UPDATE
            $this->update();
        } else {
            //INSERT
            $sql = "INSERT INTO Parcel SET user_id=:user_id, size_id=:size_id, address_id=:address_id";
            self::$db->query($sql);
            self::$db->bind('user_id', $this->getUserId());
            self::$db->bind('size_id', $this->getSizeId());
            self::$db->bind('address_id', $this->getAddressId());
            self::$db->execute();
        }
    }

    public function update() {
        $sql = "UPDATE Parcel SET user_id=:user_id, size_id=:size_id, address_id=:address_id";
        self::$db->query($sql);
        self::$db->bind('user_id', $this->getUserId());
        self::$db->bind('size_id', $this->getSizeId());
        self::$db->bind('address_id', $this->getAddressId());
        self::$db->execute();
    }

    public static function load($id = null) {
        $sql = "SELECT * FROM `Parcel` JOIN Addresses ON Parcel.address_id = Addresses.id WHERE Parcel.address_id=:address_id";

        self::$db->query($sql);
        self::$db->bind('id', $id);
        $singleParcel = self::$db->single();

        $parcel = new Parcel();
        $parcel->setUserId($single['user_id']);
        $parcel->setSizeId($singleUser['size_id']);
        $parcel->setAddressId($singleUser['address']);

        $parcel->id = $singleParcel['id'];

        return $parcel;
    }

    public static function loadAll() {
        $parcelList = [];
        $sql = "SELECT * FROM Parcel";
        self::$db->query($sql);
        $allFromDb = self::$db->resultSet();
        foreach ($allFromDb as $parcel) {
            $parcelList[] = [
                'user_id' => $parcel['user_id'],
                'size_id' => $parcel['size_id'],
                'address' => $parcel['address_id'],
            ];
        }
        return $parcelList;
    }

    public static function setDb(\Database $db) {
        self::$db = $db;
    }

    public function getID() {
        return $this->id;
    }

    public function getUserID() {
        return $this->user_id;
    }

    public function getSizeId() {
        return $this->size_id;
    }

    public function getAddressId() {
        return $this->address_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
        return $this;
    }

    public function setSizeId($size_id) {
        $this->size_id = $size_id;
        return $this;
    }

    public function setAddressId($address_id) {
        $this->address_id = $address_id;
        return $this;
    }

}
