<?php

namespace App\Models\Entities;

use Eghamat24\DatabaseRepository\Models\Entity\Entity;

class Cache extends Entity
{
    public string $key;

	public string $value;

	public int $expiration;
}
