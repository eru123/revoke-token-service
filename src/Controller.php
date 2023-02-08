<?php

namespace App;

class Controller
{
    const connectors = [
        'mysql' => Connector\MySQL::class,
    ];

    public static function init()
    {
        $connector = static::connectors[CONFIG['CONNECTOR']];
        new $connector(CONFIG);
    }

    public static function validatePipes()
    {
        return [
            [static::class, 'init'],
            [static::class, 'validate'],
        ];
    }

    public static function revokePipes()
    {
        return [
            [static::class, 'init'],
            [static::class, 'revoke'],
        ];
    }

    public static function validate(array $params)
    {
        $connector = static::connectors[CONFIG['CONNECTOR']];

        if (!isset($params['token'])) {
            throw new \Exception('Missing token parameter', 400);
        }

        return [
            'revoked' => $connector::validate($params['token'], @$params['identifier'] ?? '')
        ];
    }

    public static function revoke(array $params)
    {
        $connector = static::connectors[CONFIG['CONNECTOR']];

        if (!isset($params['token'])) {
            throw new \Exception('Missing token parameter', 400);
        }

        $connector::revoke($params['token'], @$params['identifier'] ?? '');

        return [
            'revoked' => true
        ];
    }
}