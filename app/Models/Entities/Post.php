<?php

namespace App\Models\Entities;

use Eghamat24\DatabaseRepository\Models\Entity\Entity;

class Post extends Entity
{
    public int $id;

	public string $title;

	public int $categoryId;

	public null|string $createdAt = null;

	public null|string $updatedAt = null;
}
