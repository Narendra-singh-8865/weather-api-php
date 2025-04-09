<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ContactUsService;
use App\Http\Requests\ContactRequest;

class ContactUsController extends Controller
{
    protected $contactService;
    public function __construct(ContactUsService $contactService)
    {
        $this->contactService = $contactService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoris = $this->contactService->getAll();
        
        return response()->json($categoris);
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
    public function store(ContactRequest $request)
    {
        
        
        
        $category = $this->contactService->create($request->all());
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
        
        $category = $this->contactService->getSingle($id);
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
    public function update (ContactRequest $request, string $id)
    {
        $category = $this->contactService->update($id,$request->all());
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
        
        $deleted = $this->contactService->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json(['message' => 'Category deleted successfully']);
    }


}
