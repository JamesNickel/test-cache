<?php

namespace App\Models\Resources;

use App\Models\Entities\Post;
use Eghamat24\DatabaseRepository\Models\Entity\Entity;
use Eghamat24\DatabaseRepository\Models\Resources\Resource;

class PostResource extends Resource
{
    public function toArray($post): array
    {
        return [
            'id' => $post->id,
			'title' => $post->title,
			'category_id' => $post->categoryId,
			'created_at' => $post->createdAt,
			'updated_at' => $post->updatedAt,
			
        ];
    }

    public function toArrayWithForeignKeys($post): array
    {
        return $this->toArray($post) + [
            
        ];
    }
}
