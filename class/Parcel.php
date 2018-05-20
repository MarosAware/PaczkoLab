<?php

class Parcel implements Action
{
    private $id;
    private $name;
    private $size;
    private $address;

    private static $db;

    public function __construct()
    {
        $this->id = -1;
    }

    public function save()
    {
        if ($this->id === -1) {
            self::$db->query('INSERT INTO Parcel (`name`, `size`, `address`) VALUE (:name, :size, :address)');
            self::$db->bind('name', $this->name, PDO::PARAM_INT);
            self::$db->bind('size', $this->size, PDO::PARAM_INT);
            self::$db->bind('address', $this->address, PDO::PARAM_INT);
            $result = self::$db->execute();

            if ($result !== false) {
                $this->id = self::$db->lastInsertId();
                return true;
            }
        }
        return false;
    }

    public function update()
    {
        if ($this->id !== -1) {
            self::$db->query('UPDATE Parcel SET `name`=:name, `size`=:size, address=:address WHERE id=:id');
            self::$db->bind('name', $this->name, PDO::PARAM_INT);
            self::$db->bind('size', $this->size, PDO::PARAM_INT);
            self::$db->bind('address', $this->address, PDO::PARAM_INT);
            self::$db->bind('id', $this->id, PDO::PARAM_INT);
            return self::$db->execute();
        }
    }

    public static function delete($id)
    {
        if ($id) {
            self::$db->query('DELETE FROM Parcel WHERE id=:id');
            self::$db->bind('id', $id, PDO::PARAM_INT);
            return self::$db->execute();
        }
    }

    public static function load($id)
    {
        if ($id) {
            self::$db->query('SELECT * FROM Parcel WHERE id=:id');
            self::$db->bind('id', $id, PDO::PARAM_INT);
            $obj = self::$db->single();

            $parcel = new Parcel();
            $parcel->name = $obj->name;
            $parcel->size = $obj->size;
            $parcel->address = $obj->address;
            $parcel->id = $obj->id;
            return $parcel;
        }
        return false;
    }

    public static function loadAll()
    {
        self::$db->query('SELECT * FROM Parcel');
        return self::$db->resultSet();
    }

    public static function setDb(Database $db)
    {
        self::$db = $db;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }
}