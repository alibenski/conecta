<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class DesiredtoProfile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'desired:movetoprofile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $profile = DB::select('select * from profile');

        foreach ($profile as $profile) {
            
            $desiredskill_user = DB::select('select * from desiredskill_user where user_id='.$profile->user_id.'');

            $skillset = '';

            foreach ($desiredskill_user as $desiredskill_user) {
                $skillset .= $desiredskill_user->childskill_id.',';
            }

            DB::update('update profile set desired_skills=? where user_id=?',[$skillset,$profile->user_id]);


            error_log($profile->user_id. ' '.$profile->firstname. ' '.$profile->lastname.' desires '.$skillset);

        }
    }
}
