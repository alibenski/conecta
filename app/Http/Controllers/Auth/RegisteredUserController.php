<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Auth;


use DB;
use DateTime;
use DateInterval;



use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;



use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {


        $email = $request->email;
        $domain = explode('@', $email);

        $checkdomain = DB::select('select * from domains where domain = \''.$domain[1].'\' limit 1');

        if (count($checkdomain) == 1) {


            $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed|min:8',
            ]);

            Auth::login($user = User::create([
                'name' => $request->firstname." ".$request->lastname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]));

            

            $profile = DB::table('profile')->insertGetId(
                [
                    'user_id' => $user->id,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                ]
            );

            event(new Registered($user));





            return redirect()->route('verification.notice');



        } else {
            return redirect()->route('register')->withErrors(['Please register using your UN affiliated email']);;
        }



    }



    public function verifyemail($id, $hash) {

        $user = DB::select('select * from users where id = '.$id.'');

        if (count($user) == 0) {
            return redirect()->route('login')->withErrors(['Invalid verification link.']);
        }

        $email_verified_at = $user[0]->email_verified_at;

        if ($email_verified_at == Null) {

            $verifications = DB::select('select * from email_verification where user_id = '.$user[0]->id.' and code = \''.$hash.'\'');

            if($verifications[0]->active == 0) {
                return redirect()->route('verification.notice')->withErrors(['This link has expired']);
            } else {

                $today = date('Y-m-d H:i:s');
                $expiration = $verifications[0]->expiration;

                if ($today > $expiration) {
                    return redirect()->route('verification.notice')->withErrors(['This link has expired']);
                } else {
                    DB::update('update users set email_verified_at=? where id=?',[date('Y-m-d H:i:s'), $id]);
                    DB::update('update email_verification set active=0 where user_id='.$user[0]->id.'');
                    redirect()->route('login')->withErrors(['You already have a verified account. Please login.']);
                }
            }
        } else {
            return redirect()->route('login')->withErrors(['You already have a verified account. Please login.']);
        }

        $data = [];

        return view('verified-user',$data);
    }


}
