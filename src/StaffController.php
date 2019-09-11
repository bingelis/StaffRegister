<?php

namespace Acme;

class StaffController
{
    protected $repository;

    public function __construct(StaffRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function register(string $data)
    {
        $values = explode(';', $data);
        $person = new Person(...$values);
        try {
            if ($this->repository->save($person)) {
                return view('registered', $person->properties());
            }
            return view('error', ['error' => 'Personal data was not saved.']);
        }
        catch (UserStorageException $e) {
            return view('error', ['error' => $e->getMessage()]);
        }
    }

    public function delete(string $email)
    {
        if ($this->repository->remove(Person::create(['email' => $email]))) {
            return view('deleted', ['email' => $email]);
        }

        return view('not_found', ['email' => $email]);
    }

    public function find(string $term)
    {
        $properties = Person::create()->properties();
        $properties = array_fill_keys(array_keys($properties), $term);

        $staff = $this->repository->matchBy($properties, 'OR');
        return view('results', ['staff' => $staff]);
    }

    public function import(StaffIteratorInterface $staff)
    {
        try {
            foreach ($staff as $person) {
                $this->repository->save($person);
            }
            return view('imported', []);
        }
        catch (UserStorageException $e) {
            return view('error', ['error' => $e->getMessage()]);
        }
    }

    public function index(string $filename)
    {
        return view('default', ['filename' => $filename]);
    }
}
