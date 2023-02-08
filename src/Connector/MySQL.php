<?php

namespace App\Connector;

use App\Connector;

class MySQL implements Connector
{
    private static $pdo = NULL;

    public function __construct(array $config)
    {
        $host = @$config['MYSQL_HOST'] ?? 'localhost';
        $database = @$config['MYSQL_DATABASE'];
        $username = @$config['MYSQL_USERNAME'] ?? 'root';
        $password = @$config['MYSQL_PASSWORD'] ?? NULL;
        $charset = @$config['MYSQL_CHARSET'] ?? 'utf8mb4';
        $options = @$config['MYSQL_OPTIONS'] ?? [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];

        $dsn = "mysql:host=$host;dbname=$database;charset=$charset";
        static::$pdo = new \PDO($dsn, $username, $password, $options);
    }

    public static function connect(array $config): \PDO
    {
        if (static::$pdo === NULL) {
            static::$pdo = new static($config);
        }
        return static::$pdo;
    }

    public static function validate(string $token, string $identifier = ""): bool
    {
        $pdo = static::connect(CONFIG);
        $stmt = $pdo->prepare("SELECT COUNT(token) FROM `revoked_tokens_service` WHERE `token` = :token AND `identifier` = :identifier");
        $stmt->execute(['token' => $token, 'identifier' => $identifier]);
        return $stmt->fetchColumn() > 0;
    }

    public static function revoke(string $token, string $identifier = ""): bool
    {
        $pdo = static::connect(CONFIG);
        $stmt = $pdo->prepare("INSERT INTO `revoked_tokens_service` (`token`, `identifier`) VALUES (:token, :identifier)");
        $stmt->execute(['token' => $token, 'identifier' => $identifier]);
        return $stmt->rowCount() > 0;
    }
}