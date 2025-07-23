<?php

namespace App\Http\Controllers;
use App\Models\description;
use Illuminate\Http\Request;

class  descriptionapi extends Controller
{
    function apicallfunction(){
       $apivalue = description::all();
       return response()->json($apivalue);
    }
}
