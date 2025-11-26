<?php

namespace App\Models\Repositories\Post;

use App\Models\Entities\Post;
use App\Models\Factories\PostFactory;
use Illuminate\Support\Collection;
use Eghamat24\DatabaseRepository\Models\Repositories\MySqlRepository;

class MySqlPostRepository extends MySqlRepository implements IPostRepository
{
    public function __construct()
    {
        $this->table = 'posts';
        $this->primaryKey = 'id';
        $this->softDelete = false;
        $this->factory = new PostFactory();

        parent::__construct();
    }

    public function getAll(): Collection
    {
        $posts = $this->newQuery()
            ->get();

        return $this->factory->makeCollectionOfEntities($posts);
    }

    public function getAllByIds(array $ids): Collection
    {
        $posts = $this->newQuery()
            ->whereIn('id', $ids)
            ->get();

        return $this->factory->makeCollectionOfEntities($posts);
    }

    public function getAllByCategoryId(int $categoryId): Collection
    {
        $posts = $this->newQuery()
            ->where('category_id', $categoryId)
            ->get();

        return $this->factory->makeCollectionOfEntities($posts);
    }

    public function getOneById(int $id): null|Post
    {
        $post = $this->newQuery()
            ->find($id);

        return $post ? $this->factory->makeEntityFromStdClass($post) : null;
    }

    public function getOneByTitle(string $title): null|Post
    {
        $post = $this->newQuery()
            ->where('title', $title)
            ->first();

        return $post ? $this->factory->makeEntityFromStdClass($post) : null;
    }

    public function create(Post $post): Post
    {
    	$post->createdAt = date('Y-m-d H:i:s');
		$post->updatedAt = date('Y-m-d H:i:s');

        $id = $this->newQuery()
            ->insertGetId([
                'title' => $post->title,
				'category_id' => $post->categoryId,
				'created_at' => $post->createdAt,
				'updated_at' => $post->updatedAt,
            ]);

        $post->id = $id;

        return $post;
    }

    public function update(Post $post): int
    {
    	$post->updatedAt = date('Y-m-d H:i:s');

        return $this->newQuery()
           ->where($this->primaryKey, $post->id)
            ->update([
                'title' => $post->title,
				'category_id' => $post->categoryId,
				'updated_at' => $post->updatedAt,
            ]);
    }
}
