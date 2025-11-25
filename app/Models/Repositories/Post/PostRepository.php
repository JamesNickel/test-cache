<?php

namespace App\Models\Repositories\Post;

use App\Models\Entities\Post;
use Illuminate\Support\Collection;

class PostRepository implements IPostRepository
{
    private IPostRepository $repository;
	private RedisPostRepository $redisRepository;

	public function __construct()
    {
        $this->repository = new MySqlPostRepository();
		$this->redisRepository = new RedisPostRepository();
    }

    public function getOneById(int $id): null|Post
    {
        $cacheKey = $this->redisRepository->makeKey([
            'function_name' => 'getOneById',
            'id' => $id,
        ]);

        $entity = $this->redisRepository->get($cacheKey);

        if ($entity === null) {
            $entity = $this->repository->getOneById($id);
            $this->redisRepository->put($cacheKey, $entity);
        }

        return $entity;
    }

    public function getAllByIds(array $ids): Collection
    {
        $cacheKey = $this->redisRepository->makeKey([
            'function_name' => 'getAllByIds',
            'id' => $ids,
        ]);

        $entities = $this->redisRepository->get($cacheKey);

        if ($entities === null) {
            $entities = $this->repository->getAllByIds($ids);
            $this->redisRepository->put($cacheKey, $entities);
        }

        return $entities;
    }

    public function create(Post $post): Post
    {
        $this->redisRepository->clear();

        return $this->repository->create($post);
    }

    public function update(Post $post): int
    {
        $this->redisRepository->clear();

        return $this->repository->update($post);
    }
}
