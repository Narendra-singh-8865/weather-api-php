<?php

namespace App\Services;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\ContactUs;

class ContactUsService
{
    public function contect(array $data)
    {

    }

    public function getAll()
    {
        return ContactUs::orderBy('updated_at', 'desc')->get();
    }

    public function getAllActive(){

        return ContactUs::where('status','1')->get();
    }

    public function getSingle($id)
    {
        return ContactUs::where('id', $id)->first();
    }

    public function create(array $data)
    {   
        
        return ContactUs::create($data);
    }

    public function update($id, array $data)
    {
        $ContactUs = ContactUs::where('id', $id)->first();
        if ($ContactUs) {
            $ContactUs->update($data);
            return $ContactUs;
        }
        return null;
    }

    public function delete($id)
    {
        $ContactUs = ContactUs::where('id', $id)->first();
        if ($ContactUs) {
            $ContactUs->delete();
            return true;
        }
        return false;
    }
}
