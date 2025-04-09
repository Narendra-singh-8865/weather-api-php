<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Requests\CategoryRequest;

class TaxController extends Controller
{

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->getAll();
        
        return response()->json($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        
        
        
        $category = $this->categoryService->create($request->all());
        if (!$category) {
            return response()->json(['message' => 'Failed: Category not inserted'], 404);
        }
        return response()->json($category);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $category = $this->categoryService->getSingle($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 401);
        }
        return response()->json($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = $this->categoryService->update($id,$request->all());
        if (!$category) {
            return response()->json(['message' => 'Failed: Category not updated'], 401);
        }

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $deleted = $this->categoryService->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
