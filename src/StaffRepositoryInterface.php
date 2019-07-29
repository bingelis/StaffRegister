<?php

namespace Acme;

interface StaffRepositoryInterface
{
    /** @throws UserStorageException */
    public function save(Person $person);

    public function remove(Person $person);

    public function matchBy(array $properties, string $conjunction = 'AND');
}
