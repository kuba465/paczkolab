<?php

class Size implements Action {

    /**
     *
     * @var DBmysql $db
     */
    public static $db;
    private $id = -1;
    private $name = '';
    private $price = 0;

    public function __construct($id) {
        $this->id = $id;
    }

    public function delete() {
        $size = new Size($this->getId());
        $sql = "DELETE FROM Size WHERE id=" . $size->getId();
        self::$db->query($sql);
        self::$db->execute();
    }

    public function save() {
        if ($this->id > 0) {
            //UPDATE
            $this->update();
        } else {
            //INSERT
            $sql = "INSERT INTO Size SET name=:name, price=:price";
            self::$db->query($sql);
            self::$db->bind('name', $this->getName());
            self::$db->bind('price', $this->getPrice());
            self::$db->execute();
        }
    }

    public function update() {
        $sql = "UPDATE Size SET name=:name, price=:price WHERE id=:id";
        self::$db->query($sql);
        self::$db->bind('id', $this->getId());
        self::$db->bind('name', $this->getName());
        self::$db->bind('price', $this->getPrice());
        self::$db->execute();
    }

    public static function load($id = null) {
        $sql = "SELECT * FROM Size WHERE id=:id";
        self::$db->query($sql);
        self::$db->bind('id', $id);
        $singleSize = self::$db->single();
        return [
            [
                'id' => $singleSize['id'],
                'size' => $singleSize['name'],
                'price' => $singleSize['price'],
            ]
        ];
    }

    public static function loadAll() {
        $sizesList = [];
        $sql = "SELECT * FROM Size";
        self::$db->query($sql);
        $allFromDb = self::$db->resultSet();
        foreach ($allFromDb as $size) {
            $sizesList[] = [
                'id' => $size['id'],
                'size' => $size['name'],
                'price' => $size['price'],
            ];
        }
        return $sizesList;
    }

    public static function setDb(\Database $db) {
        self::$db = $db;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setName($newName) {
        $this->name = $newName;
        return $this;
    }

    public function setPrice($newPrice) {
        $this->price = $newPrice;
        return $this;
    }

}
