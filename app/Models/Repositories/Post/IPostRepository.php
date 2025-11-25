<?php

namespace App\Models\Repositories\Post;

use App\Models\Entities\Post;
use Illuminate\Support\Collection;

interface IPostRepository
{
    public function getOneById(int $id): null|Post;

    public function getAllByIds(array $ids): Collection;

    public function create(Post $post): Post;

    public function update(Post $post): int;

}