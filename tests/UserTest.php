<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

require_once __DIR__.'/../config.php';

class UserTest extends TestCase
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
        User::setDb(self::$pdo);

        $usersCount = $this->getConnection()->getRowCount('User');

        $user = new User();
        $user->setName('Monika');
        $user->setSurname('surname');
        $user->setCredits(3);
        $user->setAddress(1);
        $user->save();

        $this->assertEquals(($usersCount + 1),
            $this->getConnection()->getRowCount('User'));
    }

    public function testUpdate()
    {
        User::setDb(self::$pdo);

        $user = User::load('2');
        $user->setName('Monika');
        $user->setSurname('surname');
        $user->setCredits(3);
        $user->setAddress(1);
        $user->update();

        $updatedUser = User::load('2');

        $this->assertEquals('Monika', $updatedUser->getName());
        $this->assertEquals('surname', $updatedUser->getSurname());
        $this->assertEquals(3, $updatedUser->getCredits());
        $this->assertEquals(1, $updatedUser->getAddress());
    }

    public function testDelete()
    {
        User::setDb(self::$pdo);

        $usersCount = $this->getConnection()->getRowCount('User');
        User::delete(2);

        $this->assertEquals(($usersCount - 1),
            $this->getConnection()->getRowCount('User'));
    }

    public function testLoad()
    {
        User::setDb(self::$pdo);
        $user = User::load(4);

        $this->assertEquals('Jan', $user->getName());
        $this->assertEquals('Kowalski', $user->getSurname());
        $this->assertEquals(1000, $user->getCredits());
        $this->assertEquals(4, $user->getAddress());
    }

    public function testLoadAll()
    {
        User::setDb(self::$pdo);
        $allUsers = User::loadAll();

        $this->assertEquals(4, count($allUsers));
    }

}
