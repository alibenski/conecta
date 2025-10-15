<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;



class SkillstoProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skills:fromproject';

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
        
        $project = DB::select('select * from projects');

        foreach ($project as $project) {
            
            $childskill_project = DB::select('select * from childskill_project where project_id='.$project->id.'');

            $skillset = '';

            foreach ($childskill_project as $childskill_project) {
                $skillset .= $childskill_project->childskill_id.',';

            }

            DB::update('update projects set skills=? where id=?',[$skillset,$project->id]);

            error_log($project->title. ' needs '.$skillset);

        }
    }
}
