<?php

require __DIR__ . '/vendor/autoload.php';

function view(string $name, array $data = [])
{
    extract($data);
    return require __DIR__ . '/src/views/' . $name .'.php';
}

if ($argc !== 3) {
    view('default', ['filename' => basename(__FILE__)]);
    exit(1);
}

function execute(string $command, string $argument)
{
    $config = require 'config.php';

    try {
        $repository = new \Acme\SqlStaffRepository(new \PDO(
            $config['database']['connection'] ?? '',
            $config['database']['username'] ?? null,
            $config['database']['password'] ?? null,
            $config['database']['options'] ?? null
        ), 'staff');
    } catch (\PDOException $e) {
        exit("Failed to connect database.\n");
    }

    $controller = new \Acme\StaffController($repository);

    switch ($command) {
        case 'register':
        case 'delete':
        case 'find':
            $controller->{$command}($argument);
            break;
        case 'import':
            $controller->import(new \Acme\CsvStaffIterator($argument));
            break;
        default:
            $controller->index(basename(__FILE__));
            break;
    }
}

execute($argv[1], $argv[2]);
