<?php

return [
    'database' => [
        'username' => 'root',
        'password' => '',
        'connection' => 'sqlite:database.sqlite',
        'options' => [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ]
    ]
];
