<?php

class User implements Action {

    private static $db;
    public $id = -1;
    public $name = '';
    public $surname = '';
    public $credits = 0;
    public $userAddressId = '';

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
        $user = User::load($this->getId());

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
        $sql = "SELECT * FROM Users 
                    JOIN Addresses ON Users.user_address = Addresses.id
                    WHERE Users.id=:id";
        self::$db->query($sql);
        self::$db->bind('id', $id);
        $singleUser = self::$db->single();

        $user = new User();
        $user->setName($singleUser['name']);
        $user->setSurname($singleUser['surname']);
        $user->setCredits($singleUser['credits']);
        $user->setUserAddressId($singleUser['user_address']);
        $user->id = $singleUser['id'];

        return $user;
    }

    public static function loadAll() {
        $userList = [];
        $sql = "SELECT * FROM Users 
                    JOIN Addresses ON Users.user_address = Addresses.id";
        self::$db->query($sql);
        $allUsersFromDb = self::$db->resultSet();
        foreach ($allUsersFromDb as $user) {
            $userList = [
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
