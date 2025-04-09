<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productService->getAll();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = $this->productService->create($request->all());
        if (!$product) {
            return response()->json(['message' => 'Failed: Product not inserted'], 404);
        }
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productService->getSingle($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = $this->productService->update($id, $request->all());
        if (!$product) {
            return response()->json(['message' => 'Failed: Product not updated'], 404);
        }
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = $this->productService->delete($id);
        if (!$deleted) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json(['message' => 'Product deleted successfully']);
    }

    /**
     * Get product by QR code.
     */
    public function getByQrCode(string $qrCode)
    {
        $product = $this->productService->getByQrCode($qrCode);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product);
    }
}
