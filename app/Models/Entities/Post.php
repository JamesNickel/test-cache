<?php

namespace App\Models\Entities;

use Eghamat24\DatabaseRepository\Models\Entity\Entity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Entity
{
    use HasFactory;

    public int $id;

	public string $title;

	public int $categoryId;

	public null|string $createdAt = null;

	public null|string $updatedAt = null;
}
