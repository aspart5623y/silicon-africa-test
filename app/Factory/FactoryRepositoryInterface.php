<?php

namespace App\Factory;

use Illuminate\Database\Eloquent\Model;

interface FactoryRepositoryInterface
{
    public function all(array $params = []);

    public function find(array $attributes) : Model  | null;

    public function create(array $data) : Model | null;

    public function update(array $attributes, array $values = []) : Model | null | bool;

    public function delete(array $attributes) : bool;
}
