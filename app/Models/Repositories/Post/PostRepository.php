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

    public function getAll(): Collection
    {
        $cacheKey = $this->redisRepository->makeKey([
            'function_name' => 'getAll',
            'id' => [],
        ]);
        $entities = $this->redisRepository->get($cacheKey);

        if ($entities === null) {
            $entities = $this->repository->getAll();
            $this->redisRepository->put($cacheKey, $entities);
        }
        return $entities;
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

    public function getAllByCategoryId(int $categoryId): Collection
    {
        $cacheKey = $this->redisRepository->makeKey([
            'function_name' => 'getAllByCategoryId',
            'id' => $categoryId,
        ]);

        $entities = $this->redisRepository->get($cacheKey);

        if ($entities === null) {
            $entities = $this->repository->getAllByCategoryId($categoryId);
            $this->redisRepository->put($cacheKey, $entities);
        }

        return $entities;
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

    public function getOneByTitle(string $title): null|Post
    {
        $cacheKey = $this->redisRepository->makeKey([
            'function_name' => 'getOneByTitle',
            'id' => $title,
        ]);

        $entity = $this->redisRepository->get($cacheKey);

        if ($entity === null) {
            $entity = $this->repository->getOneByTitle($title);
            $this->redisRepository->put($cacheKey, $entity);
        }

        return $entity;
    }

    public function create(Post $post): Post
    {
        $post = $this->repository->create($post);

        $this->cacheEntityByAllColumnNames($post);

        return $post;
    }

    public function update(Post $post): int
    {
        $oldPost = $this->getOneById($post->id);
        $this->removeEntityFromCacheByAllColumnNames($oldPost, $post);
        $this->cacheEntityByAllColumnNames($post);

        return $this->repository->update($post);
    }

    private function removeEntityFromCacheByAllColumnNames(Post $oldEntity, Post $entity){

        if($oldEntity->title != $entity->title){

            $cacheKey = $this->redisRepository->makeKey([
                'function_name' => 'title',
                'id' => $oldEntity->title,
            ]);
            $this->redisRepository->clear($cacheKey);
        }
        if($oldEntity->categoryId != $entity->categoryId){

            $cacheKey = $this->redisRepository->makeKey([
                'function_name' => 'category_id',
                'id' => $oldEntity->categoryId,
            ]);
            $this->redisRepository->clear($cacheKey);
        }

    }

    private function cacheEntityByAllColumnNames(Post $entity){

        $cacheKey = $this->redisRepository->makeKey([
            'function_name' => 'id',
            'id' => $entity->id,
        ]);
        $this->redisRepository->put($cacheKey, $entity);

        $cacheKey = $this->redisRepository->makeKey([
            'function_name' => 'title',
            'id' => $entity->title,
        ]);
        $this->redisRepository->put($cacheKey, $entity);

        $cacheKey = $this->redisRepository->makeKey([
            'function_name' => 'category_id',
            'id' => $entity->categoryId,
        ]);
        $this->redisRepository->put($cacheKey, $entity);
    }

}
