<?php

namespace App\Http\Controllers;

use DB;
use Auth;

use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index($id){

      $user_id =  Auth::user()->id;

    	$project = DB::select('select * from projects where id = '.$id.' limit 1');

    	foreach ($project as $project) {
           $title = $project->title;
           $project_description = $project->project_description;
           $remaining_tasks = $project->remaining_tasks;
           $tasks_done = $project->tasks_done;
           $stage = $project->stage;
           $people_needed = $project->people_needed;
           $is_on_premise = $project->is_on_premise;
           $location = $project->location;
           $skills_raw = $project->skills;
           $owner = $project->user_id;
        }

        if($location == 0){
          $location_name = '';
          $location_id = 0;
        } else {
          $station = DB::select('select * from stations where id = '.$location.' limit 1');
          foreach ($station as $station) {

             $location_name = $station->name;
            $location_id = $station->id;
          }
        }


        $profiles = DB::select('select * from projects_user where project_id = '.$id.' limit 99');

        $members = [];

        $members_raw_name = "";

        $user_member = false;

        foreach ($profiles as $profile) {

        	$profile_id = DB::select('select * from profile where user_id = '.$profile->user_id.' limit 1');
        	
        	foreach($profile_id as $profile_id) {
        		$members[] = [
        			 'first_name' => $profile_id->firstname,
        			 'last_name' => $profile_id->lastname,
        			 'photo' => $profile_id->photo,
        			 'role_description' => $profile->role_description,
        			 'user_id' => $profile_id->user_id,
               'owner' => $profile->owner,
        		];

            if ($user_id == $profile_id->user_id) {
              $user_member = true;
            }

            if ($profile->owner == 0) {
              $members_raw_name = $profile_id->firstname.' '.$profile_id->lastname.';'.$members_raw_name;
            }

           
        	}

        }

        $skills_raw_name = "";

        $skills_raw = substr($skills_raw, 0, -1);
        $skills_raw = explode(',', $skills_raw);

        $skills = [];

        foreach ($skills_raw as $skill_item) {
        	$skill_item = explode(',', $skill_item);
        	$skill = DB::select('select * from childskills where id = '.$skill_item[0].' limit 1');
    			
          foreach ($skill as $skill) {
    				$skill_name = $skill->skillname;

            $skills_raw_name = $skill_name.';'.$skills_raw_name;


    			}

        	$skills[] = [
        		'name' => $skill_name,
        		'id' => $skill_item[0],
        	];
        }


      $locations = DB::select('select * from stations');
      $locations_array = [];

      foreach ($locations as $location) {
        $locations_array[] = [
          'id' => $location->id,
          'locationname' => $location->name
        ];
      }


    	$data = [
        'project_id' => $id,
    		'title' => $title,
    		'project_description' => $project_description,
    		'members' => $members,
    		'people_needed' => $people_needed,
    		'remaining_tasks' => $remaining_tasks,
    		'tasks_done' => $tasks_done,
    		'skills' => $skills,
        'location_name' => $location_name,
        'location_id' => $location_id,
        'locations_array' => $locations_array,
        'stage' => $stage,
        'skills_raw_name' => $skills_raw_name,
        'members_raw_name' => $members_raw_name,
        'user_member' => $user_member
    	];

    	if($user_id == $owner) {
            return view('manageproject',$data);
        } else {
            return view('project',$data);
        }
    }




    public function updateproject(Request $request) {

      $project_id =  $request->input('project_id');
      $title =  $request->input('update_projectitle');
      $project_description = $request->input('update_projectdescription');
      $remaining_tasks = $request->input('update_tasksneeded');
      $tasks_done = $request->input('update_tasksdone');
      $stage = $request->input('update_currentstage');
      $people_needed = $request->input('update_numberofpeople');
      $members_raw = $request->input('update_membersarray');


      $skills_raw = $request->input('update_skillsarray');
    
      $skills_raw = substr($skills_raw, 0, -1);
      $skills_raw = explode(';', $skills_raw);

      $skills = '';

      foreach ($skills_raw as $skill_item) {
          $skill = DB::select('select * from childskills where skillname = \''.$skill_item.'\' limit 1');
          
          foreach ($skill as $skill) {
              $skill_id = $skill->id;
          }

          $skills = $skill_id. ',' .$skills;

      }


      $members_deleted = DB::delete('delete from projects_user where project_id = '.$project_id.' and owner = 0');


      $members_raw = substr($members_raw, 0, -1);
      $members_raw = explode(';', $members_raw);

      $members = '';

      foreach ($members_raw as $members_item) {
          $member = DB::select('select * from users where name = \''.$members_item.'\' limit 1');
          
          foreach ($member as $member) {
              $member_id = $member->id;
              $member = DB::table('projects_user')->insertGetId(
                  ['user_id' => $member_id,
                        'project_id' => $project_id,
                        'owner' => 0,
                        'role_description' => 'Member',
                  ]
              );
          }
      }



      DB::update('update projects set title=?, project_description=?, remaining_tasks=?, tasks_done=?, stage=?, skills=?, people_needed=? where id = '.$project_id.'',[$title, $project_description, $remaining_tasks, $tasks_done, $stage, $skills, $people_needed]);

      return redirect()->route('project',['id' => $project_id]);

    }





    public function updateprofile(Request $request) {

      return redirect()->route('myprofile');

    }


    public function createproject() {

        $data = [];

        return view('createproject',$data);

    }

    public function createprojectpost(Request $request) {
        $user_id =  Auth::user()->id;
        $contact =  Auth::user()->email;
        $title = $request->input('projectitle');
        $project_description = $request->input('projectdescription');
        $remaining_tasks = $request->input('tasksneeded');
        $tasks_done = $request->input('tasksdone');
        $stage = $request->input('currentstage');
        $people_needed = $request->input('numberofpeople');
        $location = $request->input('location');
        $skills_raw = $request->input('skillsarray');
        $members_raw = $request->input('membersarray');


        $skills_raw = substr($skills_raw, 0, -1);
        $skills_raw = explode(';', $skills_raw);

        $skills = '';

        foreach ($skills_raw as $skill_item) {
            $skill = DB::select('select * from childskills where skillname = \''.$skill_item.'\' limit 1');
            
            foreach ($skill as $skill) {
                $skill_id = $skill->id;
            }

            $skills = $skill_id. ',' .$skills;

        }

        if ($location == "Remote") {
          $location_id = 0;
          $is_on_premise = 0;
        } else {
           $location = DB::select('select * from stations where name = \''.$location.'\' limit 1');
            
          foreach ($location as $location) {
              $location_id = $location->id;
              $is_on_premise = 1;
          }
        }




        $id = DB::table('projects')->insertGetId(
            ['user_id' => $user_id,
                  'title' => $title,
                  'project_description' => $project_description,
                  'remaining_tasks' => $remaining_tasks,
                  'tasks_done' => $tasks_done,
                  'stage' => $stage,
                  'people_needed' => $people_needed,
                  'location' => $location_id,
                  'is_on_premise' => $is_on_premise,
                  'contact' => $contact,
                  'skills' => $skills
            ]
        );


        $ownerid = DB::table('projects_user')->insertGetId(
            ['user_id' => $user_id,
                  'project_id' => $id,
                  'owner' => 1,
                  'role_description' => 'Project Owner',
            ]
        );

        $members_raw = substr($members_raw, 0, -1);
        $members_raw = explode(';', $members_raw);

        $members = '';

        foreach ($members_raw as $members_item) {
            $member = DB::select('select * from users where name = \''.$members_item.'\' limit 1');
            
            foreach ($member as $member) {
                $member_id = $member->id;
                $member = DB::table('projects_user')->insertGetId(
                    ['user_id' => $member_id,
                          'project_id' => $id,
                          'owner' => 0,
                          'role_description' => 'Member',
                    ]
                );
            }
        }


        return redirect()->route('project',['id' => $id]);


    }
}
