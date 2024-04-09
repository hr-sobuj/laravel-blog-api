<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Resources\SuccessResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isNull;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function store(PostStoreRequest $request)
    {
        $post=$request->validated();
        $post['slug']=Str::slug($post['title']);

        if(array_key_exists('photo',$post) && !is_null($post['photo'])){
            $post['photo']=Storage::putFile('', $post['photo']);
        }



        Post::create($post);

        return (new SuccessResource([
            'message'=>'Post Created successfully!',
        ]))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
