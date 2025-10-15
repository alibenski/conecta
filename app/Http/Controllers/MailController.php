<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ConnectNotification;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function sendmail(Request $request)
    {
        $email = $request->email;
        $msg = $request->msg;
        $user_id = $request->user_id;
        $user_name = User::where('id',$user_id)->first()->profiles->firstname;

        $project_id ='';
        if ($request->project_id) {
            $project_id = Project::where('id',$request->project_id)->first()->id;
        }
        
        Mail::to($email)->send(new ConnectNotification($msg, $user_id, $user_name, $project_id));
        return response()->json(["message" => "Email sent successfully to: " . $email]);

    }
}
