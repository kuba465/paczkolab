<?php

class Address implements Action {

    /**
     *
     * @var DBmysql $db
     */
    public static $db;
    private $id = -1;
    private $city = '';
    private $code = '';
    private $street = '';
    private $number = '';

    function getId() {
        return $this->id;
    }

    function getCity() {
        return $this->city;
    }

    function getCode() {
        return $this->code;
    }

    function getStreet() {
        return $this->street;
    }

    function getNumber() {
        return $this->number;
    }

    function setCity($city) {
        if (!is_string($city) || strlen($city) < 0) {
            echo "Złe miasto.";
            return false;
        }
        $this->city = $city;
    }

    function setCode($code) {
        if (!is_string($code) || strlen($code) < 0) {
            echo "Zły kod pocztowy.";
            return false;
        }
        $this->code = $code;
    }

    function setStreet($street) {
        if (!is_string($street) || strlen($street) < 0) {
            echo "Zła ulica.";
            return false;
        }
        $this->street = $street;
    }

    function setNumber($number) {
        if (!is_string($number) || strlen($number) < 0) {
            echo "Zły numer.";
            return false;
        }
        $this->number = $number;
    }

    public function delete() {
        $address = Address::load($this->getId());
        $sql = "DELETE FROM Addresses WHERE id=" . $address->getId();
        self::$db->query($sql);
        self::$db->execute();
    }

    public function save() {
        if ($this->id > 0) {
            $this->update();
        } else {
            $sql = "INSERT INTO Addresses SET city=:city, code=:code, street=:street, number=:number";
            self::$db->query($sql);
            self::$db->bind('city', $this->getCity());
            self::$db->bind('code', $this->getCode());
            self::$db->bind('street', $this->getStreet());
            self::$db->bind('number', $this->getNumber());
            self::$db->execute();
        }
    }

    public function update() {
        $sql = "UPDATE Addresses SET city=:city, code=:code, street=:street, number=:number WHERE id=:id";
        self::$db->query($sql);
        self::$db->bind('id', $this->getId());
        self::$db->bind('city', $this->getCity());
        self::$db->bind('code', $this->getCode());
        self::$db->bind('street', $this->getStreet());
        self::$db->bind('number', $this->getNumber());
        self::$db->execute();
    }

    public static function load($id = null) {
        $sql = "SELECT * FROM Addresses WHERE id=:id";
        self::$db->query($sql);
        self::$db->bind('id', $id);
        $singleAddress = self::$db->single();

        $address = new Address();
        $address->setCity($singleAddress['city']);
        $address->setCode($singleAddress['code']);
        $address->setStreet($singleAddress['street']);
        $address->setNumber($singleAddress['number']);
        $address->id = $singleAddress['id'];

        return $address;
    }

    public static function loadAll() {
        $addressesList = [];
        $sql = "SELECT * FROM Addresses";
        self::$db->query($sql);
        $allAddressesFromDb = self::$db->resultSet();

        foreach ($allAddressesFromDb as $address) {
            $addressesList[] = [
                'id' => $address['id'],
                'city' => $address['city'],
                'code' => $address['code'],
                'street' => $address['street'],
                'flat' => $address['number'],
            ];
        }
        return $addressesList;
    }

    public static function setDb(\Database $db) {
        self::$db = $db;
    }

}
