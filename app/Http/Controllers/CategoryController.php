<?php

namespace App\Http\Controllers;

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
        return response()->json([
            'categories' => Category::all(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=Validator::make($request->all(),[
            'name'=>'required|string|unique:categories'
        ]);
        if($data->fails()){
            return response()->json([
                'success'   => false,
                'message'=> 'Error',
                'errors'=> $data->errors()->first(),
            ]);
        }

        $formData=$data->validate();
        $formData['slug']=Str::slug($formData['name']);
        $category=Category::create($formData);

        return response()->json([
            'success'=> true,
            'message'=> 'Category created successfully',
            'data'=>$category,
        ]);
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
