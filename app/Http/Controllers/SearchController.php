<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use DB;
use Auth;


use Illuminate\Http\Request;

class SearchController extends Controller
{

	public function childskills() {

		$childskills = DB::select('select * from childskills order by skillname ASC;');
		$data = [];

		foreach ($childskills as $childskill) {

			$skillname =  $childskill->skillname;
			$last = substr($skillname, strlen($skillname) - 1);



			$data[] = [
				'id' => $childskill->id,
				'skillname' => $skillname
			];
		}

		return response()->json($data);
	}


	public function locations() {

		$locations = DB::select('select * from stations');
		$data = [];

		foreach ($locations as $location) {
			$data[] = [
				'id' => $location->id,
				'locationname' => $location->name
			];
		}

		return response()->json($data);
	}




	public function dashboard() {

		$id =  Auth::user()->id;
		$profile = DB::select('select * from profile where user_id = '. $id .' limit 1');

		$desiredskillsraw = $profile[0]->desired_skills;

		$desiredskills = $profile[0]->desired_skills;


		if($desiredskills == "") {
			return redirect()->route('adddesiredskills');
		}


		$desiredskills = substr($desiredskills, 0,-1);

		if (strpos($desiredskills, ',') !== false) {
        	$desiredskills_set = explode(',', $desiredskills);
        	$selecteddesired = array_rand($desiredskills_set, 1);
        	$selecteddesired = $desiredskills_set[$selecteddesired];
		} else {
			$selecteddesired = $desiredskills;
		}

		$selecteddesired = DB::select('select * from childskills where id = '.$selecteddesired.' limit 1');

		$skills_raw = $profile[0]->skills;

		$skills_raw = substr($skills_raw, 1,-2);
        $skills_raw = explode('},{', $skills_raw);

        $skills = [];

        $skillforsearch = "";

        foreach ($skills_raw as $skills_raw_item) {
        	$skills_raw_item = explode(',', $skills_raw_item);
        	$skillforsearch = $skills_raw_item[0].','.$skillforsearch;
        }



		$data = [
			'selecteddesired' => $selecteddesired[0]->skillname,
			'desiredskillsraw' => $desiredskillsraw,
			'skillforsearch' => $skillforsearch,
			'id' => $id
		];




		return view('dashboard',$data);
	}


	public function searchbyid(Request $request) {

		if ($request->input('limit')) {
    		$limit = $request->input('limit');
    	} else {
    		$limit = 6;
    	}

    	if ($request->input('offset')) {
    		$offset = $request->input('offset');
    	} else {
    		$offset = 0;
    	}


    	$status = "";

    	if ($request->input('mentor') == 1) {
    		$status = $status."mentor = 1 and ";
    	} else {
    		$status = $status;
    	}

    	if ($request->input('host') == 1) {
    		$status = $status."host = 1 and ";
    	} else {
    		$status = $status;
    	}

    	if ($request->input('mentee') == 1) {
    		$status = $status."mentee = 1 and ";
    	} else {
    		$status = $status;
    	}

		if ($request->input('shadow') == 1) {
    		$status = $status."shadow = 1 and ";
    	} else {
    		$status = $status;
    	}    

    	if ($request->input('volunteer') == 1) {
    		$status = $status."volunteer = 1 and ";
    	} else {
    		$status = $status;
    	}




    	if ($request->input('station')) {
    		$stationr = 'station_id = '.$request->input('station').' and ';
    	} else {
    		$stationr = "";
    	}



    	if ($request->input('availability')) {
    		if ($request->input('availability') == "unavailable") {
    			$avaialr = 'availability = 0 and ';
    		} else {
    			$avaialr = 'availability = 1 and ';
    		}
    	} else {
    		$avaialr = "";
    	}







		$id = $request->input('id');

		$desiredskills = substr($id, 0,-1);

		$desiredskills_set_1 = explode(',', $desiredskills);

		$desiredquery = "";

		foreach ($desiredskills_set_1 as $desiredskills_set_1_item) {
			$desiredquery = $desiredquery. '('.$status.' '.$stationr.' '.$avaialr.' skills like \'%{'.$desiredskills_set_1_item.',%\') or ';
		}

		$desiredquery = substr($desiredquery, 0,-3);

		$profiles = DB::select('select * from profile where '.$desiredquery.' limit '.$limit. ' offset '.$offset.'');

		$matches = [];

		foreach ($profiles as $profiles_item) {
			if ($profiles_item->organization_id == NULL){
				$organization = "";
			}else {
				$organization = DB::select('select * from organizations where id = '. $profiles_item->organization_id .' limit 1');
				$organization = $organization[0]->name;
			}

			if ($profiles_item->station_id == NULL){
				$station = "";
			}else {
				$station = DB::select('select * from stations where id = '. $profiles_item->station_id .' limit 1');
				$station = $station[0]->name;
			}

			$skills_raw = substr($profiles_item->skills, 1, -2);
			$skills_array = explode('},{', $skills_raw);
			$skills = [];

			foreach ($skills_array as $skills_array_item) {
				$skills_e = explode(',', $skills_array_item);
				$skills[] = $skills_e[0];
			}

			$skill_intersect = [];

			$skill_intersect = array_intersect($desiredskills_set_1,$skills);

			$skills_intersect_string = "";

			foreach ($skill_intersect as $skillintersect) {
				$childskills = DB::select('select * from childskills where id = '.$skillintersect.' limit 1' );
				$skills_intersect_string = $childskills[0]->skillname. ', '.$skills_intersect_string;
			}

			$skills_intersect_string = substr($skills_intersect_string, 0, -2);

			$user = DB::select('select * from users where id = '.$profiles_item->user_id.'');

	    	$status_string = "";

	    	if ($profiles_item->mentor == 1) {
	    		$status_string = $status_string."Mentor, ";
	    	} else {
	    		$status_string = $status_string;
	    	}

	    	if ($profiles_item->host == 1) {
	    		$status_string = $status_string."Host, ";
	    	} else {
	    		$status_string = $status_string;
	    	}

	    	if ($profiles_item->volunteer == 1) {
	    		$status_string = $status_string."Volunteer, ";
	    	} else {
	    		$status_string = $status_string;
	    	}

	    	if (strlen($status_string) == 0) {
	    		/*if ($profiles_item->mentee == 1) {
		    		$status_string = $status_string."Mentee, ";
		    	} else {
		    		$status_string = $status_string;
		    	}

		    	if ($profiles_item->shadow == 1) {
		    		$status_string = $status_string."Shadow, ";
		    	} else {
		    		$status_string = $status_string;
		    	}*/

		    	$status_string = $status_string."Skilled, ";
	    	}

	    	$status_string = substr($status_string, 0, -2);



			$matches[] = [
				'user_id'=>$profiles_item->user_id,
				'email'=>$user[0]->email,
				'firstname'=>$profiles_item->firstname,
				'lastname'=>$profiles_item->lastname,
				'host'=>$profiles_item->host,
				'mentor'=>$profiles_item->mentor,
				'mentee'=>$profiles_item->mentee,
				'shadow'=>$profiles_item->shadow,
				'volunteer'=>$profiles_item->volunteer,
				'organization'=>$organization,
				'station'=>$station,
				'skills'=>$skills_intersect_string,
				'photo'=>$profiles_item->photo,
				'status_string'=>$status_string,
			];
		}

		$data = $matches;

		return response()->json($data);


	}


	public function searchprojectsbyid(Request $request) {

		if ($request->input('limit')) {
    		$limit = $request->input('limit');
    	} else {
    		$limit = 6;
    	}

    	if ($request->input('offset')) {
    		$offset = $request->input('offset');
    	} else {
    		$offset = 0;
    	}

    	$stationr = "";
    	
    	if ($request->input('station')) {
    		$stationr= 'location = '.$request->input('station').' and ';
    	}

    	if ($request->input('stage')) {
    		$stationr = 'stage = '.$request->input('stage').' and ';
    	} 

    	if ($request->input('station') && $request->input('stage')) {
    		$stationr = 'location = '.$request->input('station').' and stage = '.$request->input('stage').' and ';
    	}


		$id = $request->input('id');

		$desiredskills = substr($id, 0,-1);

		$desiredskills_set_1 = explode(',', $desiredskills);

		$desiredquery = "";

		foreach ($desiredskills_set_1 as $desiredskills_set_1_item) {
			$desiredquery = $desiredquery. '('.$stationr.'skills like \'%'.$desiredskills_set_1_item.',%\') or ';
		}

		$desiredquery = substr($desiredquery, 0,-3);

		$projects = DB::select('select * from projects where '.$desiredquery.' limit ' .$limit. ' offset '.$offset.'');

		$matches = [];

		foreach ($projects as $projects_item) {

			if ($projects_item->location == 0){
				$station = "Remote";
			}else {
				$station = DB::select('select * from stations where id = '. $projects_item->location .' limit 1');
				$station = $station[0]->name;
			}


			switch ($projects_item->stage) {
			  case 1:
			    $stage='Not Yet Started';
			    break;
			  case 2:
			    $stage='Early Phase';
			    break;
			  case 3:
			    $stage='50% Through';
			    break;
			  case 4:
			    $stage='Finalizaion';
			    break;
			  default:
			    $stage='Done';
			}


			$skills_raw = substr($projects_item->skills, 0, -1);
			$skills_array = explode(',', $skills_raw);

			$skill_intersect = [];

			$skill_intersect = array_intersect($desiredskills_set_1,$skills_array);

			$skills_intersect_string = "";


			foreach ($skill_intersect as $skillintersect) {
				$childskills = DB::select('select * from childskills where id = '.$skillintersect.' limit 1' );
				$skills_intersect_string = $childskills[0]->skillname. ', '.$skills_intersect_string;

			}

			if ($skills_intersect_string != NULL) {

				$skills_intersect_string = substr($skills_intersect_string, 0, -2);
				
				$matches[] = [
					'id'=>$projects_item->id,
					'title'=>$projects_item->title,
					'station'=>$station,
					'skills'=>$skills_intersect_string,
					'stage'=>$stage
				];
			} else {
				
			}
			
		}

		$data = $matches;

		return response()->json($data);


	}

	public function randomprojects(Request $request) {
		if ($request->input('limit')) {
    		$limit = $request->input('limit');
    	} else {
    		$limit = 6;
    	}

    	$filter = "";

    	if ($request->input('station')) {
    		$filter = 'where location = '.$request->input('station').' ';
    	}

    	if ($request->input('stage')) {
    		$filter = 'where stage = '.$request->input('stage').' ';
    	} 

    	if ($request->input('station') && $request->input('stage')) {
    		$filter = 'where location = '.$request->input('station').' and stage = '.$request->input('stage').' ';
    	}





    	$projects = DB::select('select * from projects '.$filter.'order by rand() limit ' .$limit);

    	$projectlist = [];

    	foreach ($projects as $projects_item) {

			if ($projects_item->location == 0){
				$station = "Remote";
			}else {
				$station = DB::select('select * from stations where id = '. $projects_item->location .' limit 1');
				$station = $station[0]->name;
			}


			switch ($projects_item->stage) {
			  case 1:
			    $stage='Not Yet Started';
			    break;
			  case 2:
			    $stage='Early Phase';
			    break;
			  case 3:
			    $stage='50% Through';
			    break;
			  case 4:
			    $stage='Finalizaion';
			    break;
			  default:
			    $stage='Done';
			}


			$skills_raw = substr($projects_item->skills, 0, -1);
			$skills_array = explode(',', $skills_raw);

			$skills_string = "";


			foreach ($skills_array as $skillarray) {
				$childskills = DB::select('select * from childskills where id = '.$skillarray.' limit 1' );
				$skills_string = $childskills[0]->skillname. ', '.$skills_string;

			}

			$skills_string = substr($skills_string, 0, -2);

			$projectlist[] = [
				'id'=>$projects_item->id,
				'title'=>$projects_item->title,
				'station'=>$station,
				'skills'=>$skills_string,
				'stage'=>$stage
			];	
			
		}

		$data = $projectlist;

		return response()->json($data);



	}



	public function searchprofile() {
		$id =  Auth::user()->id;
		$profile = DB::select('select * from profile where user_id = '. $id .' limit 1');

		$desiredskillsraw = $profile[0]->desired_skills;

		$desiredskills = $profile[0]->desired_skills;

		if($desiredskills == "") {
			return redirect()->route('adddesiredskills');
		}

		$desiredskills = substr($desiredskills, 0,-1);

		

		$desiredskills_set_1 = explode(',', $desiredskills);

		$desiredquery = "";

		foreach ($desiredskills_set_1 as $desiredskills_set_1_item) {
			$desiredquery = $desiredquery. 'skills like \'%{'.$desiredskills_set_1_item.',%\' or ';
		}

		$desiredquery = substr($desiredquery, 0,-3);

		$limit = 20;

		$profiles = DB::select('select * from profile where '.$desiredquery.'');

		$matches = [];

		$locationid = [];
		$locations_array = [];


		foreach ($profiles as $profiles_item) {
			$matches[] = [
				'firstname'=>$profiles_item->firstname,
				'lastname'=>$profiles_item->lastname,
				'host'=>$profiles_item->host,
				'mentor'=>$profiles_item->mentor,
			];
			

			$location = $profiles_item->station_id;

			if ($location !== NULL) {
				$match_location = DB::select('select * from stations where id = '.$profiles_item->station_id.' limit 1');

				if (count($match_location) > 0) {
					if (!in_array($match_location[0]->id, $locationid)) {
					    $locations_array[] = [
							'id' => $match_location[0]->id,
							'locationname' => $match_location[0]->name
						];

						$locationid[] = $match_location[0]->id;
					} 
				}
			}

			


		}

		if (strpos($desiredskills, ',') !== false) {
        	$desiredskills_set = explode(',', $desiredskills);
        	$selecteddesired = array_rand($desiredskills_set, 1);
        	$selecteddesired = $desiredskills_set[$selecteddesired];
		} else {
			$selecteddesired = $desiredskills;
		}

		$selecteddesired = DB::select('select * from childskills where id = '.$selecteddesired.' limit 1');

		$skills_raw = $profile[0]->skills;

		$skills_raw = substr($skills_raw, 1,-2);
        $skills_raw = explode('},{', $skills_raw);

        $skills = [];


        $languages = DB::select('select * from languages');

        $languages_array = [];

		foreach ($languages as $language) {
			$languages_array[] = [
				'id' => $language->id,
				'languagename' => $language->name
			];
		}


		



		$data = [
			'selecteddesired' => $selecteddesired[0]->skillname,
			'id' => $id,
			'desiredquery' => $desiredquery,
			'matches' => $matches,
			'desiredskillsraw' => $desiredskillsraw,
			'locations_array'=>$locations_array,
			'languages_array'=>$languages_array
		];





		return view('searchprofile',$data);
	}

	public function searchproject() {
		$id =  Auth::user()->id;
		$profile = DB::select('select * from profile where user_id = '. $id .' limit 1');

		$desiredskills = $profile[0]->desired_skills;

		if($desiredskills == "") {
			return redirect()->route('adddesiredskills');
		}

		$desiredskills = substr($desiredskills, 0,-1);

		if (strpos($desiredskills, ',') !== false) {
        	$desiredskills_set = explode(',', $desiredskills);
        	$selecteddesired = array_rand($desiredskills_set, 1);
        	$selecteddesired = $desiredskills_set[$selecteddesired];
		} else {
			$selecteddesired = $desiredskills;
		}

		$selecteddesired = DB::select('select * from childskills where id = '.$selecteddesired.' limit 1');

		$skills_raw = $profile[0]->skills;

		$skills_raw = substr($skills_raw, 1,-2);
        $skills_raw = explode('},{', $skills_raw);

        $skillforsearch = "";

        foreach ($skills_raw as $skills_raw_item) {
        	$skills_raw_item = explode(',', $skills_raw_item);
        	$skillforsearch = $skills_raw_item[0].','.$skillforsearch;
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
			'selecteddesired' => $selecteddesired[0]->skillname,
			'id' => $id,
			'skillforsearch' => $skillforsearch,
			'locations_array'=>$locations_array
		];





		return view('searchproject',$data);
	}


	public function searchname(Request $request) {
		$term = $request->input('term');

		$name = DB::select('select * from users where name like \'%'.$term.'%\'');

		$people = [];
		
		foreach ($name as $name) {
			$people[] = [
				'name' => $name->name,
				'id' => $name->id
			];
		}

		$data = $people;

		return response()->json($data);

	}

	public function validatename(Request $request) {
		$term = $request->input('term');

		$name = DB::select('select * from users where name = \''.$term.'\'');

		$people = [];
		
		foreach ($name as $name) {
			$people[] = [
				'name' => $name->name,
				'id' => $name->id
			];
		}

		$data = $people;

		return response()->json($data);

	}


	public function searchskill(Request $request) {
		$term = $request->input('term');


		if ($request->input('limit')) {
    		$limit = $request->input('limit');
    	} else {
    		$limit = 20;
    	}

    	if ($request->input('mentor') == 1) {
    		$mentor = 'and mentor = ' .$request->input('mentor'). '';
    	} else {
    		$mentor = '';
    	}

    	if ($request->input('host') == 1) {
    		$host = 'and host = ' .$request->input('host'). '';
    	} else {
    		$host = '';
    	}


		$childskills = DB::select('select * from childskills where skillname like \'='.$term.'\'');

		$skills = [];

		foreach ($childskills as $childskill) {
			$skills[] = [
				'id' => $childskill->id,
				'skillname' => $childskill->skillname
			];

		}

		error_log(count($skills));

		if (count($skills) == 1) {
			error_log($skills[0]['id']);
			error_log($skills[0]['skillname']);

			// $profile = DB::select('select * from profile where skills like \'%{'.$skills[0]['id'].',%\' '.$mentor. ' ' .$host. ' limit '.$limit.' ')

			$profile = Profile::whereRaw('skills like \'%{'.$skills[0]['id'].',%\' '.$mentor. ' ' .$host)->get()->take($limit);
				
			$profiles = [];

			foreach ($profile as $profile) {
				$profiles[] = [
	    			'user_id' => $profile->user_id,
	                'firstname' => $profile->firstname,
	                'lastname' => $profile->lastname,
	                'shadow' => $profile->shadow,
	                'mentor' => $profile->mentor,
	                'host' => $profile->host,
	                'volunteer' => $profile->volunteer,
	                'organization_id' => $profile->organization_id,
	                'station_id' => $profile->station_id,
	                'photo' => $profile->photo,
					'email' => $profile->users->email,
	            ];
			}

			$data = $profiles;

		} else {
			$childskills = DB::select('select * from childskills where skillname like \'%'.$term.'%\'');

			$skills = [];

			foreach ($childskills as $childskill) {
				$skills[] = [
					'id' => $childskill->id,
					'skillname' => $childskill->skillname
				];

				error_log($childskill->skillname);
			}

			$data = $skills;
		}  

		return response()->json($data);

	}




    public function people(Request $request) {

    	$data = [];

    	if ($request->input('limit')) {
    		$limit = $request->input('limit');
    	} else {
    		$limit = 20;
    	}

    	if ($request->input('offset')) {
    		$offset = $request->input('offset');
    	} else {
    		$offset = 0;
    	}

    	$skill_id = $request->input('skill');

    	$childskill_user = DB::select('select * from childskill_user where childskill_id = '.$skill_id.' limit '.$limit.' offset '.$offset.'');

    	foreach ($childskill_user as $childskill_user) {
    		$profile_search = $childskill_user->user_id;
    		$profile = DB::select('select * from profile where user_id = '.$profile_search.'');

    		foreach ($profile as $profile) {
	    		$data[] = [
	    			'user_id' => $profile->user_id,
	                'firstname' => $profile->firstname,
	                'lastname' => $profile->lastname,
	                'shadow' => $profile->shadow,
	                'mentor' => $profile->mentor,
	                'host' => $profile->host,
	                'volunteer' => $profile->volunteer,
	                'organization_id' => $profile->organization_id,
	                'station_id' => $profile->station_id,
	                'photo' => $profile->photo
	            ];
	        }
    	}

    	return response()->json($data);

    }

    public function searchresults(Request $request) {


    	$term = $request->input('term');


		if ($request->input('limit')) {
    		$limit = $request->input('limit');
    	} else {
    		$limit = 20;
    	}


		$childskills = DB::select('select * from childskills where skillname like \''.$term.'\'');

		$skills = [];

		foreach ($childskills as $childskill) {
			$skills[] = [
				'id' => $childskill->id,
				'skillname' => $childskill->skillname
			];



		}

		error_log(count($skills));

		if (count($skills) == 1) {
			error_log($skills[0]['id']);
			error_log($skills[0]['skillname']);

			 $id = $skills[0]['id'];

			$project = DB::select('select * from projects where skills like \'%{'.$skills[0]['id'].',%\' limit '.$limit.' ');

			$projects = [];


			foreach ($project as $project) {
				$projects[] = [
	    			'title' => $project->title,
	    			'description' => $project->project_description,
	    			'id' => $project->id
	            ];

	           
			}

			$data = [
				'projects' => $projects,
				'term' => $term,
				'id' => $id
			];

			return view('searchresults',$data);

		} else {
			$childskills = DB::select('select * from childskills where skillname like \'%'.$term.'%\'');

			$skills = [];

			foreach ($childskills as $childskill) {
				$skills[] = [
					'id' => $childskill->id,
					'name' => $childskill->skillname
				];

				error_log($childskill->skillname);
			}

			$data = [
				'skills' => $skills
			];

			return view('searchalt',$data);
		}  



    	
    }
} 
