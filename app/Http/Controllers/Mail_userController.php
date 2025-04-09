<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\user_mail;
use Illuminate\Support\Facades\Validator;

class Mail_userController extends Controller
{
    function sendEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to' => 'required|email',
            'cc' => 'email',  
            'bcc' => 'email',
            'msg' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        
        $to = $request->input('to');
        $msg = $request->input('msg');
        $cc = $request->input('cc');
        $bcc = $request->input('bcc');
        $subject = $request->input('subject');
        
        try {
            $mail = Mail::to($to);
            
            if ($cc) {
                $ccEmails = explode(',', $cc);
                $mail->cc($ccEmails);
            }
            
            if ($bcc) {
                $bccEmails = explode(',', $bcc);
                $mail->bcc($bccEmails);
            }
            
            $mail->send(new user_mail($msg, $subject));

            return response()->json(['success' => 'Email sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email']);
        }
    }
}
