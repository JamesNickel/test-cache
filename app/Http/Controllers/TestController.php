<?php

namespace App\Http\Controllers;

use App\Models\Entities\Post;
use App\Models\Repositories\Post\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function getAll()
    {
        //$dataBeforeUpdate = DB::table('posts')->get();
        //DB::table('posts')
        //    ->where(['id'=> 1])
        //    ->increment('category_id');
        //$dataAfterUpdate = DB::table('posts')->get();

        $postCache = new PostRepository();

        $post = $postCache->getOneById(1);
        $beforeUpdate = $post->categoryId;

        $post->categoryId++;
        $postCache->update($post);
        $post = $postCache->getOneById(1);
        $afterUpdate = $post->categoryId;

        return response()->json([
            'beforeUpdate' => $beforeUpdate,
            'afterUpdate' => $afterUpdate,
        ]);
    }
}
