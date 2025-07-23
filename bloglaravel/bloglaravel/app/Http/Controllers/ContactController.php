<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class ContactController extends Controller
{
    /*
    public function send(Request $request)
    {
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:133',
            'email' => 'required|email|max:133',
            'subject' => 'required|string|max:133',
        'message' => 'required|string|max:255',
    ]);
    \Log::info('Contact message:', $validated);
    return response()->json(['message' => 'Message sent successfully!']);
} catch (\Exception $e) {
    \Log::error('Error in contact form:', ['error' => $e->getMessage()]);
    return response()->json([
       'data' => 'Something went wrong.',
       'errordata' => $e->getMessage()
    ]);
}
return response()->json([
    'success' => true,
    'message' => 'Mail sent successfully!'
]);

}
*/
public function send(Request $request)
{
    

    return response()->json([
        'message' => 'Message sent successfully!',
    ]);
}

}
