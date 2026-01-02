<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PasswordController extends Controller
{
    
    public function forgetPassword(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([ 
                'status' => 'error',
                'message' => 'User not found'
            
            ], Response::HTTP_NOT_FOUND);
                    }
            
           
            //generate random token
            $token = Str::random(60);
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $email],
                ['token' => Hash::make($token),
                'created_at' => Carbon::now()
                ]
            );
            //send email to user with the token
            $emailData = [
                'token' => $token,
                'user' => $user,
            ];
            Mail::send('emails.password_reset', $emailData , function ($message) use ($user) {
                $message->to($user->email, $user->name);
                $message->subject('Password Reset Request');
            });
            return response()->json([
                'status' => 'success',
                'message' => 'User found and Password reset link sent to your email address'
            
            ], Response::HTTP_OK);

       
    }  //function end
    function resetPassword(Request $request)
    {
        //code to reset password using the token
    }
}