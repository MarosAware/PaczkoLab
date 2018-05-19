<?php

class User implements Action
{
    private $id;
    private $name;
    private $surname;
    private $credits;
    private $address;

    private static $db;

    public function __construct()
    {
        $this->id = -1;
    }

    public function save()
    {
        if ($this->id == -1){
            self::$db->query('INSERT INTO `User` (`name`, `surname`, `credits`, `address`) VALUE (:name, :surname, :credits, :address)');
            self::$db->bind('name',$this->name,  PDO::PARAM_STR);
            self::$db->bind('surname',$this->surname, PDO::PARAM_STR);
            self::$db->bind('credits',$this->credits, PDO::PARAM_INT);
            self::$db->bind('address',$this->address, PDO::PARAM_INT);
            $result = self::$db->execute();

            if($result !== false){
                $this->id = self::$db->lastInsertId();
                return true;
            }
        }
    }

    public function update()
    {
        if($this->id !== -1) {
            self::$db->query('UPDATE `User` SET `name`=:name, `surname`=:surname, `credits`=:credits, `address`=:address  WHERE `id`=:id');
            self::$db->bind('name',$this->name, PDO::PARAM_STR);
            self::$db->bind('surname',$this->surname, PDO::PARAM_STR);
            self::$db->bind('credits',$this->credits, PDO::PARAM_INT);
            self::$db->bind('address',$this->address, PDO::PARAM_INT);
            self::$db->bind('id',$this->id, PDO::PARAM_INT);
            return self::$db->execute();
        }

    }

    public static function delete($id)
    {
        if($id){
            self::$db->query('DELETE FROM `User` WHERE id=:id');
            self::$db->bind('id',$id);
            return self::$db->execute();
        }
    }

    public static function load($id = null)
    {
        if($id){
            self::$db->query("SELECT * FROM `User` WHERE id=:id");
            self::$db->bind('id',$id);
            $row =  self::$db->single();

            $user = new User();
            $user->name = $row->name;
            $user->surname = $row->surname;
            $user->credits = $row->credits;
            $user->address = $row->address;
            $user->id = $row->id;

            return $user;
        }

        return false;
    }

    public static function loadAll()
    {
        self::$db->query("SELECT * FROM `User`");
        return self::$db->resultSet();

    }

    public static function setDb(Database $db)
    {
        self::$db = $db;
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
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * @param mixed $credits
     */
    public function setCredits($credits)
    {
        $this->credits = $credits;
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