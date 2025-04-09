<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAll()
    {
        return Product::orderBy('updated_at', 'desc')->get();
    }

    public function getAllActive()
    {
        return Product::where('status', '1')->get();
    }

    public function getSingle($id)
    {
        return Product::where('id', $id)->first();
    }

    public function getByQrCode($qrCode)
    {
        return Product::where('qr_code', $qrCode)->first();
    }

    public function create(array $data)
    {
        $data['status'] = $data['status'] === 'active' ? '1' : '0';
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $product = Product::where('id', $id)->first();
        if ($product) {
            if (isset($data['status'])) {
                $data['status'] = $data['status'] === 'active' ? '1' : '0';
            }
            $product->update($data);
            return $product;
        }
        return null;
    }

    public function delete($id)
    {
        $product = Product::where('id', $id)->first();
            if ($product) {
            $product->delete();
            return true;
        }
        return false;
    }
}
