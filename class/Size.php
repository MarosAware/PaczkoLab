<?php

class Size implements Action
{
    private $id;
    private $size;
    private $price;

    /**
     * @var Database
     */
    private static $db;


    public function __construct()
    {
        $this->id = -1;
    }

    public function save()
    {
        if ($this->id == -1){
            self::$db->query('INSERT INTO `size` (`size`, price) VALUE (:size, :price)');
            self::$db->bind('size',$this->size,  PDO::PARAM_STR);
            self::$db->bind('price',$this->price,PDO::PARAM_INT);
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
            self::$db->query('UPDATE `size` SET `size`=:size, price=:price WHERE id=:id');
            self::$db->bind('size',$this->size);
            self::$db->bind('price',$this->price);
            self::$db->bind('id',$this->id);
            $result = self::$db->execute();

            if($result !== false){
                return true;
            }
        }

    }

    public static function delete($id)
    {
        if($id){
            self::$db->query('DELETE FROM size WHERE id=:id');
            self::$db->bind('id',$id);
            return self::$db->execute();
        }
    }

    public static function load($id)
    {
        if($id){
            self::$db->query("SELECT * FROM `size` WHERE id=:id");
            self::$db->bind('id',$id);
            $row =  self::$db->single();

            $size = new Size();
            $size->size = $row->size;
            $size->price = $row->price;
            $size->id = $row->id;

            return $size;
        }

        return false;
    }

    public static function loadAll()
    {
        self::$db->query("SELECT * FROM `size`");
        $allObj =  self::$db->resultSet();

        $loadedAllObj = [];

        foreach($allObj as $obj) {
            $size = new Size();
            $size->size = $obj->size;
            $size->price = $obj->price;
            $size->id = $obj->id;

            $loadedAllObj [] = $size;
        }

        return $loadedAllObj;

    }

    public static function setDb(Database $db)
    {
        self::$db = $db;
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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

}
