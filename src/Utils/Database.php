<?php

namespace App\Utils;

use PDO;

class Database
{
    private const HOST = \DB_HOST;
    private const DB_NAME = \DB_NAME;
    private const USER = \DB_USER;
    private const PASS = \DB_PASS;
    private const CHARSET = \DB_CHARSET;

    private static ?PDO $pdoInstance = null;

    private function __construct()
    {
    }

    public static function getConnection(): PDO
    {
        if (self::$pdoInstance === null) {
            $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::DB_NAME . ';charset=' . self::CHARSET;

            self::$pdoInstance = new PDO($dsn, self::USER, self::PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        }

        return self::$pdoInstance;
    }
}
