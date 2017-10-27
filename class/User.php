<?php

class User implements Action {

    public static $db;
    private $id = -1;
    private $name = '';
    private $surname = '';
    private $credits = 0;
    private $userAddressId;

    public function __construct($id) {
        $this->id = $id;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getSurname() {
        return $this->surname;
    }

    function getCredits() {
        return $this->credits;
    }

    function getUserAddressId() {
        return $this->userAddressId;
    }

    function setName($name) {
        if (!is_string($name) || strlen($name) < 0) {
            echo "Złe imię.";
            return false;
        }
        $this->name = $name;
    }

    function setSurname($surname) {
        if (!is_string($surname) || strlen($surname) < 0) {
            echo "Złe nazwisko.";
            return false;
        }
        $this->surname = $surname;
    }

    function setCredits($credits) {
        if (!is_numeric($credits) || $credits < 0) {
            echo "Zła liczba.";
            return false;
        }
        $this->credits = $credits;
    }

    function setUserAddressId($userAddressId) {
        if (!is_numeric($userAddressId) || $userAddressId < 0) {
            echo "Złe id.";
            return false;
        }
        $this->userAddressId = $userAddressId;
    }

    public function delete() {
        $user = new User($this->getId());
        $sql = "DELETE FROM Users WHERE id=" . $user->getId();
        self::$db->query($sql);
        self::$db->execute();
    }

    public function save() {
        if ($this->id > 0) {
            $this->update();
        } else {
            $sql = "INSERT INTO Users SET name=:name, surname=:surname, credits=:credits, user_address=:userAddressId";
            self::$db->query($sql);
            self::$db->bind('name', $this->getName());
            self::$db->bind('surname', $this->getSurname());
            self::$db->bind('credits', $this->getCredits());
            self::$db->bind('userAddressId', $this->getUserAddressId());
            self::$db->execute();
        }
    }

    public function update() {
        $sql = "UPDATE Users SET name=:name, surname=:surname, credits=:credits, user_address=:userAddressId WHERE id=:id";
        self::$db->query($sql);
        self::$db->bind('id', $this->getId());
        self::$db->bind('name', $this->getName());
        self::$db->bind('surname', $this->getSurname());
        self::$db->bind('credits', $this->getCredits());
        self::$db->bind('userAddressId', $this->getUserAddressId());
        self::$db->execute();
    }

    public static function load($id = null) {
        $sql = 'SELECT * FROM Users WHERE id=:id';
        self::$db->query($sql);
        self::$db->bind('id', $id);
        $singleUser = self::$db->single();

        return[
            [
                'id' => $singleUser['id'],
                'name' => $singleUser['name'],
                'surname' => $singleUser['surname'],
                'credits' => $singleUser['credits'],
                'address_id' => $singleUser['user_address'],
            ]
        ];
    }

    public static function loadAll() {
        $userList = [];
//        $sql = "SELECT * FROM Users
//                    JOIN Addresses ON Users.user_address = Addresses.id";
        $sql = 'SELECT * FROM Users'; //U JOIN (SELECT id as address_id, city, code, street, number from Addresses) as A on U.user_address = A.address_id';
        self::$db->query($sql);
        $allUsersFromDb = self::$db->resultSet();
        foreach ($allUsersFromDb as $user) {
            $userList[] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'surname' => $user['surname'],
                'credits' => $user['credits'],
                'address_id' => $user['user_address'],
            ];
        }
        return $userList;
    }

    public static function setDb(\Database $db) {
        self::$db = $db;
    }

}
