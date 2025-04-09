<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAll()
    {
        return Category::orderBy('updated_at', 'desc')->get();
    }

    public function getAllActive(){

        return Category::where('status','1')->get();
    }

    public function getSingle($id)
    {
        return Category::where('id', $id)->first();
    }

    public function create(array $data)
    {   
        return Category::create($data);
    }

    public function update($id, array $data)
    {
        $category = Category::where('id', $id)->first();
        if ($category) {
            $category->update($data);
            return $category;
        }
        return null;
    }

    public function delete($id)
    {
        $category = Category::where('id', $id)->first();
        if ($category) {
            $category->delete();
            return true;
        }
        return false;
    }
}
