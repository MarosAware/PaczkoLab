<?php

class User implements Action
{
    private $id;
    private $name;
    private $surname;
    private $creditAmount;
    private $addressId;

    private static $db;

    public function __construct()
    {
        $this->id = -1;
    }

    public function save()
    {
        if ($this->id == -1){
            self::$db->query('INSERT INTO `user` (`name`, `surname`, `creditAmount`, `addressId`) VALUE (:name, :surname, :creditAmount, :addressId)');
            self::$db->bind('name',$this->name,  PDO::PARAM_STR);
            self::$db->bind('surname',$this->surname, PDO::PARAM_STR);
            self::$db->bind('creditAmount',$this->creditAmount, PDO::PARAM_INT);
            self::$db->bind('addressId',$this->addressId, PDO::PARAM_INT);
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
            self::$db->query('UPDATE `user` SET `name`=:name, `surname`=:surname, `creditAmount`=:creditAmount, `addressId`=:addressId  WHERE `id`=:id');
            self::$db->bind('name',$this->name, PDO::PARAM_STR);
            self::$db->bind('surname',$this->surname, PDO::PARAM_STR);
            self::$db->bind('creditAmount',$this->creditAmount, PDO::PARAM_INT);
            self::$db->bind('adddressId',$this->addressId, PDO::PARAM_INT);
            self::$db->bind('id',$this->id, PDO::PARAM_INT);
            $result = self::$db->execute();

            if($result !== false){
                return true;
            }
        }
    }

    public static function delete($id)
    {
        if($id){
            self::$db->query('DELETE FROM user WHERE id=:id');
            self::$db->bind('id',$id);
            return self::$db->execute();
        }
    }

    public static function load($id = null)
    {
        if($id){
            self::$db->query("SELECT * FROM `user` WHERE id=:id");
            self::$db->bind('id',$id);
            $row =  self::$db->single();

            $user = new User();
            $user->name = $row->name;
            $user->surname = $row->surname;
            $user->creditAmount = $row->creditAmount;
            $user->addressId = $row->addressId;

            return $user;
        }

        return false;
    }

    public static function loadAll()
    {
        self::$db->query("SELECT * FROM `user`");
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
    public function getCreditAmount()
    {
        return $this->creditAmount;
    }

    /**
     * @param mixed $creditAmount
     */
    public function setCreditAmount($creditAmount)
    {
        $this->creditAmount = $creditAmount;
    }

    /**
     * @return mixed
     */
    public function getAddressId()
    {
        return $this->addressId;
    }

    /**
     * @param mixed $addressId
     */
    public function setAddressId($addressId)
    {
        $this->addressId = $addressId;
    }
}