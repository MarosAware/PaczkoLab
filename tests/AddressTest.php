<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

require_once __DIR__.'/../config.php';



class AddressTest extends TestCase
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
        Address::setDb(self::$pdo);

        $addressCount = $this->getConnection()->getRowCount('Address');

        $address = new Address();
        $address->setCity('Warsaw');
        $address->setCode('00-001');
        $address->setStreet('Noniewicza');
        $address->setFlat('66');
        $address->save();

        $this->assertEquals(($addressCount + 1),
            $this->getConnection()->getRowCount('Address'));
    }

    public function testUpdate()
    {
        Address::setDb(self::$pdo);

        $address = Address::load('2');
        $address->setCity('Gdynia');
        $address->setCode('00-001');
        $address->setStreet('Nowa');
        $address->setFlat('34');
        $address->update();

        $updatedAddress = Address::load('2');

        $this->assertEquals('Gdynia', $updatedAddress->getCity());
        $this->assertEquals('00-001', $updatedAddress->getCode());
        $this->assertEquals('Nowa', $updatedAddress->getStreet());
        $this->assertEquals('34', $updatedAddress->getFlat());
    }

    public function testDelete()
    {
        Address::setDb(self::$pdo);

        $addressCount = $this->getConnection()->getRowCount('Address');
        Address::delete(2);

        $this->assertEquals(($addressCount - 1),
            $this->getConnection()->getRowCount('Address'));
    }

    public function testLoad()
    {
        Address::setDb(self::$pdo);
        $address = Address::load(2);

        $this->assertEquals('Warszawa', $address->getCity());
        $this->assertEquals('16-230', $address->getCode());
        $this->assertEquals('Kowalskiego 9', $address->getStreet());
        $this->assertEquals('10', $address->getFlat());

    }

    public function testLoadAll()
    {
        Address::setDb(self::$pdo);
        $allAddress = Address::loadAll();

        $this->assertEquals(6, count($allAddress));
    }

}