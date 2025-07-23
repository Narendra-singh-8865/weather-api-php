<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Controller
{
    public function sendMail(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        // Example debug (remove in production)
        // return response()->json($data);

        // Optional: send email
        /*
        Mail::raw("Name: {$data['name']}\nEmail: {$data['email']}\n\n{$data['message']}", function ($message) use ($data) {
            $message->to('your@email.com') // Or any receiving address
                    ->subject($data['subject']);
        });
        */
    if($data['name'] || $data['email'] || $data['message']){
        return response()->json(['error' => 'Error This Data']);
    }
        return response()->json(['message' => 'Mail sent successfully!']);
    }
}
