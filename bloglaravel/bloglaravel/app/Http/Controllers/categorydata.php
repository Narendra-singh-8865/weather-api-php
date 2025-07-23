<?php

namespace App\Http\Controllers;
use App\Models\category;
use Illuminate\Http\Request;
use Nette\Utils\Json;

class categorydata extends Controller
{
    function homeurl(){
         $homedata = category::all();
         return response()->json($homedata);
        }
}
