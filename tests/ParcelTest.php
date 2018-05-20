<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

require_once __DIR__.'/../config.php';

class ParcelTest extends TestCase
{
    use TestCaseTrait;

    static $db;
    static $pdo;

    /**
     * Returns the test database connection.
     *
     * @return \PHPUnit\DbUnit\Database\Connection
     */
    protected function getConnection()
    {
        self::$pdo = new DBmysql();
        self:: $db	= new PDO($GLOBALS['DB_DSN'],
            $GLOBALS['DB_USER'],
            $GLOBALS['DB_PASS']);

        return $this->createDefaultDBConnection(self::$db, $GLOBALS['DB_NAME']);
    }

    /**
     * Returns the test dataset.
     *
     * @return \PHPUnit\DbUnit\DataSet\IDataSet
     */
    protected function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__.'/../dump.xml');
    }

    public function testSave()
    {
        Parcel::setDb(self::$pdo);

        $parcelCount = $this->getConnection()->getRowCount('Parcel');

        $parcel = new Parcel();
        $parcel->setName(1);
        $parcel->setAddress(2);
        $parcel->setSize(3);
        $parcel->save();

        $this->assertEquals(($parcelCount + 1),
            $this->getConnection()->getRowCount('Parcel'));
    }

    public function testUpdate()
    {
        Parcel::setDb(self::$pdo);

        $parcel = Parcel::load(2);
        $parcel->setName(1);
        $parcel->setAddress(1);
        $parcel->setSize(1);
        $parcel->update();

        $updatedParcel = Parcel::load(2);

        $this->assertEquals(1, $updatedParcel->getName());
        $this->assertEquals(1, $updatedParcel->getAddress());
        $this->assertEquals(1, $updatedParcel->getSize());
    }

    public function testDelete()
    {
        Parcel::setDb(self::$pdo);

        $parcelCount = $this->getConnection()->getRowCount('Parcel');
        Parcel::delete(2);

        $this->assertEquals(($parcelCount - 1),
            $this->getConnection()->getRowCount('Parcel'));
    }

    public function testLoad()
    {
        Parcel::setDb(self::$pdo);
        $parcel = Parcel::load(1);

        $this->assertEquals(3, $parcel->getName());
        $this->assertEquals(2, $parcel->getSize());
        $this->assertEquals(3, $parcel->getAddress());
        $this->assertEquals(1, $parcel->getId());

    }

    public function testLoadAll()
    {
        Parcel::setDb(self::$pdo);
        $allParcel = Parcel::loadAll();

        $this->assertEquals(3, count($allParcel));
    }

}