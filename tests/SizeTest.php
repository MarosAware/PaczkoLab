<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

require_once __DIR__.'/../config.php';

class SizeTest extends TestCase
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
        Size::setDb(self::$pdo);

        $sizeCount = $this->getConnection()->getRowCount('Size');

        $size = new Size();
        $size->setSize('XS');
        $size->setPrice(12.30);
        $size->save();

        $this->assertEquals(($sizeCount + 1),
            $this->getConnection()->getRowCount('Size'));
    }

    public function testUpdate()
    {
        Size::setDb(self::$pdo);

        $size = Size::load('2');
        $size->setPrice(14.40);
        $size->setSize('XXL');
        $size->update();

        $updatedSize = Size::load('2');

        $this->assertEquals(14.40, $updatedSize->getPrice());
        $this->assertEquals('XXL', $updatedSize->getSize());
    }

    public function testDelete()
    {
        Size::setDb(self::$pdo);

        $sizeCount = $this->getConnection()->getRowCount('Size');
        Size::delete(2);

        $this->assertEquals(($sizeCount - 1),
            $this->getConnection()->getRowCount('Size'));
    }

    public function testLoad()
    {
        Size::setDb(self::$pdo);
        $size = Size::load(1);

        $this->assertEquals('M', $size->getSize());
        $this->assertEquals(10.00, $size->getPrice());

    }

    public function testLoadAll()
    {
        Size::setDb(self::$pdo);
        $allSize = Size::loadAll();

        $this->assertEquals(3, count($allSize));
    }

}