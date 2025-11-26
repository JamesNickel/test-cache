<?php

namespace Tests\Feature;

use App\Models\Entities\Post;
use App\Models\Repositories\Post\PostRepository;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\PostTableSeeder;
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

    public function seedDatabase($postRepository){

        $post = new Post();
        $post->title = 'sample post 1';
        $post->categoryId = 1;
        $postRepository->create($post);

        $post = new Post();
        $post->title = 'sample post 2';
        $post->categoryId = 1;
        $postRepository->create($post);
    }

    public function test_cache_get_all(){

        //$this->seed(PostTableSeeder::class);
        $postRepository = new PostRepository();
        $this->seedDatabase($postRepository);


        $post = $postRepository->getAll();

        assertNotEmpty($post);
    }

    public function test_cache_get_all_by_ids(){

        $postRepository = new PostRepository();
        $this->seedDatabase($postRepository);
        $posts = $postRepository->getAllByIds([1, 2]);

        assertNotEmpty($posts);
    }

    public function test_cache_get_all_by_category_id(){

        $postRepository = new PostRepository();
        $this->seedDatabase($postRepository);

        $posts = $postRepository->getAllByCategoryId(1);

        assertNotEmpty($posts);
    }

    public function test_cache_get_one_by_id(){

        $postRepository = new PostRepository();
        $this->seedDatabase($postRepository);
        $posts = $postRepository->getOneById(1);

        assertNotEmpty($posts);
    }

    public function test_cache_get_one_by_title(){

        $postRepository = new PostRepository();
        $this->seedDatabase($postRepository);
        $post = $postRepository->getOneByTitle('sample post 1');

        assertNotEmpty($post);
    }
}
