<?php

namespace BigPopcorn\Access\Utils;

use \PDO;

class MySqlConnection {
  private static $conn = null;

  private const HOST = 'localhost';
  private const PORT = '3306';
  private const USER = 'popcorn_blast_researcher';
  private const PASS = 'mysql';
  private const DATABASE = 'popcorn_bucket';

  public static function getConnection(): PDO {
    if (!self::$conn) {
      try {
        $dsn = "mysql:host=" . self::HOST . ";port=" . self::PORT . ";dbname=" . self::DATABASE;
        self::$conn = new PDO($dsn, self::USER, self::PASS);
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
    }
    return self::$conn;
  }
}
