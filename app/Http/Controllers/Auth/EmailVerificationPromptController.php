<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;


use DB;
use DateTime;
use DateInterval;


class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {


        $user = auth()->user();

        $user_id = $user->id;
        $code=md5(rand());
        $expiration_date = date('Y-m-d H:i:s');
        $expiration_date = new DateTime($expiration_date);
        $expiration_date->add(new DateInterval('P2D')); // P1D means a period of 1 day
        $expiration_date = $expiration_date->format('Y-m-d H:i:s');

        Mail::to($user->email)->send(new EmailVerification($user_id, $code));

        DB::update('update email_verification set active=0 where user_id='.$user_id.'');

        $verification_code = DB::table('email_verification')->insertGetId(
            [
                'user_id' => $user_id,
                'code' => $code,
                'expiration' => $expiration_date,
                'active' => 1
            ]
        );



        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(RouteServiceProvider::HOME)
                    : view('auth.verify-email');




    }
}
