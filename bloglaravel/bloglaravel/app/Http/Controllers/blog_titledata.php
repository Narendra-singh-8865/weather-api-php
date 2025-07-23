<?php

namespace App\Http\Controllers;

use App\Models\blog_title;
use Illuminate\Http\Request;

class blog_titledata extends Controller
{
    public function blog_api()
    {
        $blog_title_api = blog_title::all();
        return response()->json($blog_title_api);
    }
}
