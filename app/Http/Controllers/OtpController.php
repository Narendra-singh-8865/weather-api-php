<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Validator;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(["Error" => "OTP Not Sent. " . $validator->errors()]);
        }
        $otp = rand(1111, 9999);
        
     session(['otp' => $otp, 'otp_sent_at' => now()]);
        Mail::to($request->email)->send(new OtpMail($otp));
        return response()->json(['message' => 'OTP sent successfully!']);
    }
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric',
        ]);
        if ($validator->fails()) {
          return response()->json(["Error" => "OTP Not Sent" . $validator->errors()]);
        }
        if ($request->otp == $_SESSION['otp']) {
         return response()->json(['message' => 'OTP verified successfully!']);
        } else {
            return response()->json(['message' => 'Invalid OTP!'], 400);
        }
    }
}

