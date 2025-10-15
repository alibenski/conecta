<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use DB;
class SkillsToProfile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skills:movetoprofile';
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

            $childskill_user = DB::select('select * from childskill_user where user_id='.$profile->user_id.'');

            $skillset = '';

            foreach ($childskill_user as $childskill_user) {
                $skillset .= '{'.$childskill_user->childskill_id.', 0},';

            }

            DB::update('update profile set skills=? where user_id=?',[$skillset,$profile->user_id]);

            error_log($profile->user_id. ' '.$profile->firstname. ' '.$profile->lastname.' has skills '.$skillset);
            error_log(str_replace(',', '},{', $profile->skills));


        }
    }
}