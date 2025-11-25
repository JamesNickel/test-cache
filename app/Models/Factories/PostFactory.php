<?php

namespace App\Models\Factories;

use App\Models\Entities\Post;
use Eghamat24\DatabaseRepository\Models\Factories\Factory;
use stdClass;

class PostFactory extends Factory
{
    public function makeEntityFromStdClass(stdClass $entity): Post
    {
        $post = new Post();

        $post->id = $entity->id;
		$post->title = $entity->title;
		$post->categoryId = $entity->category_id;
		$post->createdAt = $entity->created_at;
		$post->updatedAt = $entity->updated_at;
		
        return $post;
    }
}
