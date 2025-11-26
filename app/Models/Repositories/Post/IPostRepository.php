<?php

namespace App\Models\Repositories\Post;

use App\Models\Entities\Post;
use Illuminate\Support\Collection;

interface IPostRepository
{

    public function getAll(): Collection;

    public function getAllByIds(array $ids): Collection;

    public function getAllByCategoryId(int $categoryId): Collection;

    public function getOneById(int $id): null|Post;

    public function getOneByTitle(string $title): null|Post;

    public function create(Post $post): Post;

    public function update(Post $post): int;


}
