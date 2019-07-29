<?php

namespace Acme;

class CsvStaffIterator extends \SplFileObject implements StaffIteratorInterface
{
    public static $header = ['firstname', 'lastname', 'email', 'phonenumber1', 'phonenumber2', 'comment'];

    public function __construct($file_name, $open_mode = 'r', $use_include_path = false, $context = null)
    {
        parent::__construct($file_name, $open_mode, $use_include_path, $context);
        $this->setFlags(\SplFileObject::READ_CSV | \SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY | \SplFileObject::DROP_NEW_LINE);
        $this->setCsvControl(';');
    }

    public function current(): Person
    {
        if ($this->key() == 0 && array_intersect(static::$header, parent::current())) {
            $this->next();
        }
        return new Person(...parent::current());
    }
}
