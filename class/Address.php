<?php

class Address implements Action
{

    private $id;
    private $city;
    private $code;
    private $street;
    private $flat;

    private static $db;

    public function __construct()
    {
        $this->id = -1;
    }

    public function save()
    {
        if($this->id = -1){
            self::$db->query('INSERT INTO `Address` ( `city`, `code`, `street`, `flat` ) VALUES ( :city, :code, :street, :flat)');
            self::$db->bind('city', $this->city, PDO::PARAM_STR);
            self::$db->bind('code', $this->code, PDO::PARAM_STR);
            self::$db->bind('street', $this->street, PDO::PARAM_STR);
            self::$db->bind('flat', $this->flat, PDO::PARAM_INT);
            $result = self::$db->execute();

            if($result !== false){
                $this->id = self::$db->lastInsertId();
                return true;
            }
        }

        return false;
    }

    public function update()
    {
        if($this->id !== -1){
            self::$db->query('UPDATE `Address` SET `city`=:city, `code`=:code, `street`=:street, `flat`=:flat');
            self::$db->bind('city', $this->city, PDO:: PARAM_STR);
            self::$db->bind('code', $this->code, PDO::PARAM_STR);
            self::$db->bind('street', $this->street, PDO::PARAM_STR);
            self::$db->bind('flat', $this->flat, PDO::PARAM_INT);
            return self::$db->execute();
        }
    }

    public static function delete($id)
    {
        if($id){
            self::$db->query('DELETE FROM `Address` WHERE id=:id');
            self::$db->bind('id', $id, PDO::PARAM_INT);
            return self::$db->execute();
        }
    }

    public static function load($id)
    {
        if($id){
            self::$db->query("SELECT * FROM `Address` WHERE id=:id");
            self::$db->bind('id',$id, PDO::PARAM_INT);
            $row =  self::$db->single();

            $address = new Address();
            $address->city = $row->city;
            $address->code = $row->code;
            $address->street = $row->street;
            $address->flat = $row->flat;
            $address->id = $row->id;

            return $address;
        }

        return false;
    }

    public static function loadAll()
    {
        self::$db->query("SELECT * FROM `Address`");
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
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getFlat()
    {
        return $this->flat;
    }

    /**
     * @param mixed $flat
     */
    public function setFlat($flat)
    {
        $this->flat = $flat;
    }
}