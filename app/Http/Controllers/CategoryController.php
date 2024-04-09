<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SuccessResource;
use App\Models\Category;
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
    public function store(CategoryStoreRequest $request)
    {
        $formData = $request->validated();
        $formData['slug'] = Str::slug($formData['name']);
        Category::create($formData);

        return (new SuccessResource(['message' => 'Category successfully stored!']))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $formData['data'] = new CategoryResource($category);
        return (new SuccessResource($formData))->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $formData = $request->validated();
        $formData['slug'] = Str::slug($formData['name']);
        $category->update($formData);

        return (new SuccessResource([
            'message' => 'Category updated successfully!',
            'data' => $category,
        ]))->response()->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        return (new SuccessResource([
            'message' => 'Deleted!',
        ]))->response()->setStatusCode(201);
    }
}
