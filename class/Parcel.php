<?php

class Parcel implements Action {

    private $id;
    private $address_id;
    private $user_id;
    private $size_id;

    public function __construct($size = null, $price = -1) {
        $this->id = -1;
    }

//GET - zwracający wszystkie wpisy w bazie

    public function getId() {
        return $this->id;
    }

    public function getAddressId() {
        return $this->address_id;
    }

    public function setAddressId($add) {
        $this->address_id = $add;
        return $this;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user) {
        $this->user_id = $user;
        return $this;
    }

    public function getSizeId() {
        return $this->size_id;
    }

    public function setSizeId($size) {
        $this->size_id = $size;
        return $this;
    }

    public function load($id) {
        $safe_id = self::$conn->real_escape_string($id);
        $sql = "SELECT * FROM Parcel WHERE id = $safe_id";
        if ($result = self::$conn->query($sql)) {
            $row = $result->fetch_assoc();
            $this->id = $row['id'];

            return $row;
        } else {

            return false;
        }
    }

    public function save() {
        if ($this->id > 0) {
            //UPDATE
            $this->update();
        } else {
            //INSERT
            $sql = "INSERT INTO Parcel SET address_id=:address_id, user_id=:user_id,size_id:size_id";
            self::$db->query($sql);
            self::$db->bind('address_id', $this->getAddressId());
            self::$db->bind('user_id', $this->getUserId());
            self::$db->bind('size_id', $this->getSizeId());
            self::$db->execute();
        }
    }

    public function update() {
        $sql = "UPDATE Parcel SET address_id=:address_id, user_id=:user_id,size_id:size_id WHERE id=:id";
        self::$db->query($sql);
        self::$db->bind('address_id', $this->getAddressId());
        self::$db->bind('user_id', $this->getUserId());
        self::$db->bind('size_id', $this->getSizeId());
        self::$db->execute();
    }

    public function delete() {
        $parcel = Parcel::load($this->getId());
        $sql = "DELETE FROM Parcel WHERE id=" . $parcel->getId();
        self::$db->query($sql);
        self::$db->execute();
    }

    public static function loadAll() {
        $parcelList = [];
        $sql = "SELECT * FROM Parcel";
        self::$db->query($sql);
        $allFromDb = self::$db->resultSet();
        foreach ($allFromDb as $parcel) {
            $parcelList[] = [
                'address_id' => $parcel['address_id'],
                'user_id' => $parcel['user_id'],
                'size_id' => $parcel['size_id'],
            ];
        }
        return $parcelList;
    }

}
