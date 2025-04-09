<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product2Request;
use App\Services\Product_masterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;


class Product_masterController extends Controller
{
    protected $productService;

    public function __construct(Product_masterService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        try {
            $products = $this->productService->getAll();
            return response()->json(['success' => true, 'data' => $products], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching products', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to retrieve products', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Product2Request $request)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('images', $imageName, 'public');
                $validatedData['image'] = $imageName; 
            }

            $product = $this->productService->create($validatedData);

            return response()->json(['success' => true, 'message' => 'Product created successfully', 'data' => $product], 201);
        } catch (\Exception $e) {
            Log::error('Error creating product', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to create product', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = $this->productService->getSingle($id);
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found'], 404);
            }
            return response()->json(['success' => true, 'data' => $product], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching product', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to retrieve product', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Product2Request $request, $id)
    {
        try {
            $product = $this->productService->getSingle($id);
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found'], 404);
            }
             return $product; 
          
         
            if ($request->hasFile('image')) {
                if ($product->image && File::exists(public_path('storage/images/' . $product->image))) {
                    File::delete(public_path('storage/images/' . $product->image));
                }
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('images', $imageName, 'public');
    
                $product->image = $imageName;
            }
            $product->update($request->except('image'));  
            return response()->json(['success' => true, 'message' => 'Product updated successfully', 'data' => $product], 200);
        } catch (\Exception $e) {
            Log::error('Error updating product', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to update product', 'error' => $e->getMessage()], 500);
        }
    }  
   
    public function destroy($id)
    {
        try {
            $product = $this->productService->getSingle($id);
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found'], 404);
            }

            if ($product->image && File::exists(public_path('storage/images/' . $product->image))) {
                File::delete(public_path('storage/images/' . $product->image));
            }

            $this->productService->delete($id);

            return response()->json(['success' => true, 'message' => 'Product deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting product', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to delete product', 'error' => $e->getMessage()], 500);
        }
    }
}
