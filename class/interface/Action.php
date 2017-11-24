<?php

interface Action
{
    const db = null;

    public function save();

    public function update();

//    TODO: Or why no static... ?
    public static function delete($id);

//    TODO: Why static...
    public static function load($id = null);
    
    public static function loadAll();

    public static function setDb(Database $db);
}
