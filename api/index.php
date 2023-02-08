<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller;

if (file_exists(__DIR__ . '/../.env')) {
    \Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();
}

define('CONFIG', [
    'CONNECTOR' => @$_ENV['DB_CONNECTOR'] ?? 'mysql',
    'MYSQL_HOST' => $_ENV['PLANETSCALE_DB_HOST'],
    'MYSQL_DATABASE' => $_ENV['PLANETSCALE_DB'],
    'MYSQL_USERNAME' => $_ENV['PLANETSCALE_DB_USERNAME'],
    'MYSQL_PASSWORD' => $_ENV['PLANETSCALE_DB_PASSWORD'],
    'MYSQL_CHARSET' => @$_ENV['MYSQL_CHARSET'],
    'MYSQL_OPTIONS' => [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::MYSQL_ATTR_SSL_CA => $_ENV['PLANETSCALE_SSL_CERT_PATH'] // __DIR__ . '/../certs/cacert.pem'
    ],
]);

$router = new \eru123\Router\Router();
$router->base('/api');
$router->get('/validate/{identifier}/{token}', ...Controller::validatePipes());
$router->get('/validate/{token}', ...Controller::validatePipes());
$router->get('/revoke/{identifier}/{token}', ...Controller::revokePipes());
$router->get('/revoke/{token}', ...Controller::revokePipes());
$router->run();