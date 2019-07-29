<?php

namespace Acme;

class Person
{
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $primary_phone;
    protected $secondary_phone;
    protected $description;

    public function __construct(...$args)
    {
        $properties = array_keys($this->properties());
        foreach ($args as $key => $value) {
            if (isset($properties[$key])) {
                $this->{$properties[$key]} = $value;
            }
        }
    }

    public static function create(array $properties = []) {
        $instance = new static;

        foreach ($properties as $name => $value) {
            if (property_exists(__CLASS__, $name)) {
                $instance->{$name} = $value;
            }
        }

        return $instance;
    }

    public function __get($name): ?string
    {
        if (!property_exists(__CLASS__, $name)) {
            throw new \DomainException(sprintf('Property %s do not exists on %s class.', $name, __CLASS__));
        }

        return $this->{$name};
    }

    public function __set($name, string $value = NULL): void
    {
        if (!property_exists(__CLASS__, $name)) {
            throw new \DomainException(sprintf('Property %s do not exists on %s class.', $name, __CLASS__));
        }

        $this->{$name} = $value;
    }

    public function properties(): array {
        return get_object_vars($this);
    }

}
