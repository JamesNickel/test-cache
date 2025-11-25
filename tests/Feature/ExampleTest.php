<?php

namespace Tests\Feature;

use App\Models\Repositories\Post\PostRepository;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function PHPUnit\Framework\assertNotEmpty;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_a_successful_response()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
    }

    public function test_cache_get_one_by_id(){

        $postCache = new PostRepository();

        $post = $postCache->getOneById(1);
        $beforeUpdate = $post->categoryId;

        $post->categoryId++;
        $postCache->update($post);
        $post = $postCache->getOneById(1);
        $afterUpdate = $post->categoryId;

        assertNotEmpty($post);
        assert($beforeUpdate < $afterUpdate);
    }

    public function test_cache_get_all_by_ids(){

        $postCache = new PostRepository();
        $posts = $postCache->getAllByIds([1, 2]);

        assertNotEmpty($posts->count() > 0);
    }

    public function test_cache_get_one_by_category_id(){

        $postCache = new PostRepository();

        $post = $postCache->getOneById(1);

        assertNotEmpty($post);
    }

    public function test_cache_get_all_by_category_ids(){

        $postCache = new PostRepository();
        $posts = $postCache->getAllByIds([1, 2]);

        assertNotEmpty($posts->count() > 0);
    }
}
