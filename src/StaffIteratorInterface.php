<?php

namespace Acme;

interface StaffIteratorInterface extends \Iterator
{
    public function current(): Person;
}
