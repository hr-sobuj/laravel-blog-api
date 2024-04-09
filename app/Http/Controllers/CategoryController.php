<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategoryResource::collection(Category::latest()->get());
        return (new SuccessResource([
            'message' => 'All Categories',
            'data' => $categories,
        ]))->response()->setStatusCode(200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories'
        ]);
        if ($data->fails()) {
            return (new ErrorResource($data->getMessageBag()))->response()->setStatusCode(422);
        }

        $formData = $data->validate();
        $formData['slug'] = Str::slug($formData['name']);
        Category::create($formData);

        return (new SuccessResource(['message' => 'Category successfully stored!']))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $formData['data']=new CategoryResource($category);
        return (new SuccessResource($formData))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name,' . $category->id,
        ]);

        if ($data->fails()) {
            return response()->json([
                'success'   => false,
                'message' => 'Error',
                'errors' => $data->errors()->first(),
            ]);
        }

        $formData = $data->validate();
        $formData['slug'] = Str::slug($formData['name']);
        $category->update($formData);


        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully',
            'data' => $category,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted!',
        ]);
    }
}
