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

    public function save() {
        // TODO: Implement update() method.
    }
    public function update() {
     // TODO: Implement update() method.
    }
    public static function delete($id) {
        self::$db->query('DELETE FROM size WHERE id=:id');
        self::$db->bind('id',$id);
        return self::$db->execute();
    }
    public static function load($id = null) {
        self::$db->query("SELECT * FROM size WHERE id=:id");
        self::$db->bind('id',$id);
        return self::$db->single();
//     TODO:   I can't use this in static
//        foreach ($arr as $property => $value) {
//            $this->{$property} = $value;
//        }
    }
    public static function loadAll() {
        self::$db->query("SELECT * FROM size");
        return self::$db->resultSet();
    }
    public static function setDb(Database $db) {
        self::$db = $db;
    }

}