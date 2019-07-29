<?php

namespace Acme;

class SqlStaffRepository implements StaffRepositoryInterface
{
    protected $table;
    protected $connection;

    public function __construct(\PDO $connection, string $table)
    {
        $this->connection = $connection;
        $this->table = $table;
    }

    public function save(Person $person): bool
    {
        if (!filter_var($person->email, FILTER_VALIDATE_EMAIL)) {
            throw new UserStorageException(sprintf('Email value "%s" is considered not valid.', $person->email));
        }

        if (!!$this->matchBy(['email' => $person->email])) {
            throw new UserStorageException(sprintf('Email value "%s" is not unque.', $person->email));
        }

        $properties = $person->properties();

        $sql = sprintf('INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            implode(', ', array_keys($properties)),
            ':' . implode(', :', array_keys($properties))
        );

        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($properties);

            return !!$stmt->rowCount();
        } catch (\PDOException $e) {
            throw new UserStorageException(sprintf('Failed to save person "%s"', $person->email));
        }
    }

    public function remove(Person $person): bool
    {
        $sql = sprintf('DELETE FROM %s WHERE email = :email', $this->table);

        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['email' => $person->email]);

        return !!$stmt->rowCount();
    }

    public function matchBy(array $properties, string $conjunction = 'AND'): array
    {
        $conditions = array_map(function ($property) {
            return " {$property} = :{$property} ";
        }, array_keys($properties));

        $sql = sprintf('SELECT * FROM %s WHERE %s',
            $this->table,
            implode($conjunction, $conditions)
        );

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($properties);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, Person::class);
    }
}
