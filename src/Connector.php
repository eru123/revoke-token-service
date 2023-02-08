<?php

namespace App;

interface Connector
{
    public static function connect(array $config): \PDO;
    public static function validate(string $token, string $identifier = ""): bool;
    public static function revoke(string $token, string $identifier = ""): bool;
}