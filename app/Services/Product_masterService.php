<?php

namespace App\Services;
use Illuminate\Support\Facades\Hash;
use App\Models\product_master;

class Product_masterService
{
    public function contect(array $data)
    {

    }

    public function getAll()
    {
        return product_master::orderBy('updated_at', 'desc')->get();
    }

    public function getAllActive(){

        return product_master::where('status','1')->get();
    }

    public function getSingle($id)
    {
        return product_master::where('id', $id)->first();
    }

    public function create(array $data)
    {   
        
        return product_master::create($data);
    }

    public function update($id, array $data)
    {
        $ContactUs = product_master::where('id', $id)->first();
        if ($ContactUs) {
            $ContactUs->update($data);
            return $ContactUs;
        }
        return null;
    }

    public function delete($id)
    {
        $ContactUs = product_master::where('id', $id)->first();
        if ($ContactUs) {
            $ContactUs->delete();
            return true;
        }
        return false;
    }
}
