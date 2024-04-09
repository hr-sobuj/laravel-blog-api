<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Resources\SuccessResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = Post::with('category')->latest('id')->paginate(intval($request->query('paginate', 10)));
        return response()->json([
            'success' => true,
            'message' => 'All posts',
            'data' => $posts,
        ]);
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
    public function show(Post $post)
    {
        return response()->json([
            'success' => true,
            'message' => 'Post details.',
            'data' => Collection::make($post)->put('category', $post->category),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Post $post)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer',
            'title' => 'required|string|max:180|unique:posts,title,' . $post->id,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error occured',
                'errors' => $validator->getMessageBag(),
            ], 422);
        }

        $data = $validator->validated();

        $data['slug'] = Str::slug($data['title']);

        if (array_key_exists('photo', $data) && !is_null($data['photo'])) {
            Storage::delete($post->photo);
            $data['photo'] = Storage::putFile('', $data['photo']);
        }

        $post->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully!',
            'data' => [],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Storage::delete($post->photo);
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully!',
            'data' => [],
        ]);
    }
}
