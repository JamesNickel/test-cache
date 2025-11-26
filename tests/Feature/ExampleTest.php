<?php

namespace Tests\Feature;

use App\Models\Entities\Post;
use App\Models\Repositories\Post\PostRepository;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\PostTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
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

    public function seedDatabase($postRepository) : void{

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


        $posts = $postRepository->getAll();

        assertNotEmpty($posts);
        assert(count($posts) == 2);
    }

    public function test_cache_get_all_by_ids(){

        $postRepository = new PostRepository();
        $this->seedDatabase($postRepository);
        $allPosts = $postRepository->getAll();
        $ids = [];
        foreach($allPosts as $post){
            $ids[] = $post->id;
        }

        $posts = $postRepository->getAllByIds($ids);

        assertNotEmpty($posts);
        assert(count($posts) == 2);
    }

    public function test_cache_get_all_by_category_id(){

        $postRepository = new PostRepository();
        $this->seedDatabase($postRepository);

        $posts = $postRepository->getAllByCategoryId(1);

        assertNotEmpty($posts);
        assert(count($posts) == 2);
    }

    public function test_cache_get_one_by_id(){

        $postRepository = new PostRepository();
        $this->seedDatabase($postRepository);
        $allPosts = $postRepository->getAll();

        $post = $postRepository->getOneById($allPosts[0]->id);

        assertNotEmpty($post);
    }

    public function test_cache_get_one_by_title(){

        $postRepository = new PostRepository();
        $this->seedDatabase($postRepository);
        $post = $postRepository->getOneByTitle('sample post 1');

        assertNotEmpty($post);
    }

    public function test_cache_check_if_entity_update_is_working(){

        $postRepository = new PostRepository();
        $this->seedDatabase($postRepository);

        $allPosts = $postRepository->getAll();
        assertNotEmpty($allPosts);

        $post0CategoryId = $allPosts[0]->categoryId;
        $post1CategoryId = $allPosts[1]->categoryId;

        $post1 = $postRepository->getOneById($allPosts[1]->id);
        assertNotEmpty($post1);
        $post1->categoryId++;
        $postRepository->update($post1);

        $allPosts = $postRepository->getAll();
        assertNotEmpty($allPosts);

        assert(count($allPosts) == 2);
        assert($allPosts[0]->categoryId == $post0CategoryId);
        assert($allPosts[1]->categoryId > $post1CategoryId);
        assert($allPosts[1]->categoryId == $post1CategoryId + 1);
    }
}
