<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Storage;


use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ProfileController extends Controller
{
    public function index($user_id){
    	$my_id =  Auth::user()->id;
		$profile = DB::select('select * from profile where user_id = '.$user_id.' limit 1');

		$first_name = $profile[0]->firstname;
		$last_name = $profile[0]->lastname;
		$organization_id = $profile[0]->organization_id;
		$station_id = $profile[0]->station_id;
		$photo = $profile[0]->photo;
		$skills_raw = $profile[0]->skills;
		$desired_skills_raw = $profile[0]->desired_skills;
		$bio = $profile[0]->bio;
		$availability = $profile[0]->availability;
		$availability_text = $profile[0]->availability_text;


		$mentor = $profile[0]->mentor;
		$host = $profile[0]->host;
		$mentee = $profile[0]->mentee;
		$shadow = $profile[0]->shadow;
		$volunteer = $profile[0]->volunteer;


		$languages = DB::select('select * from language_user where user_id = '.$user_id.'');

		

		if(empty($languages)) {
        	$lang = [];
        } else {

        	$lang = [];

			foreach ($languages as $language) {

				$language_name = DB::select('select * from languages where id = '.$language->language_id.'');

				switch ($language->writing) {
				  case 1:
				    $writing='Basic (UN Level I)';
				    break;
				  case 2:
				    $writing='Intermediate (UN Level II)';
				    break;
				  case 3:
				    $writing='Advanced (UN Level III)';
				    break;
				  case 4:
				    $writing='Expert (UN Level IV)';
				    break;
				  default:
				    $writing='Undefined';
				}

				switch ($language->reading) {
				  case 1:
				    $reading='Basic (UN Level I)';
				    break;
				  case 2:
				    $reading='Intermediate (UN Level II)';
				    break;
				  case 3:
				    $reading='Advanced (UN Level III)';
				    break;
				  case 4:
				    $reading='Expert (UN Level IV)';
				    break;
				  default:
				    $reading='Undefined';
				}

				switch ($language->speaking) {
				  case 1:
				    $speaking='Basic (UN Level I)';
				    break;
				  case 2:
				    $speaking='Intermediate (UN Level II)';
				    break;
				  case 3:
				    $speaking='Advanced (UN Level III)';
				    break;
				  case 4:
				    $speaking='Expert (UN Level IV)';
				    break;
				  default:
				    $speaking='Undefined';
				}

				switch ($language->understanding) {
				  case 1:
				    $understanding='Basic (UN Level I)';
				    break;
				  case 2:
				    $understanding='Intermediate (UN Level II)';
				    break;
				  case 3:
				    $understanding='Advanced (UN Level III)';
				    break;
				  case 4:
				    $understanding='Expert (UN Level IV)';
				    break;
				  default:
				    $understanding='Undefined';
				}




				$lang[] = [
	        		'name' => $language_name[0]->name,
	        		'writing' => $writing,
	        		'reading' => $reading,
	        		'speaking' => $speaking,
	        		'understanding' => $understanding,
	        		'native' => $language->native,
	        	];
			}
		}



        
        if($profile[0]->organization_id == "") {
        	$organization_name = "";
        } else {
        	$organization = DB::select('select * from organizations where id = '.$organization_id.' limit 1');

	        foreach ($organization as $organization) {
	        	$organization_name = $organization->name;
	        }
	    }

		if($station_id == ""){
			$station_name = "";
		} else {
			$station = DB::select('select * from stations where id = '.$station_id.' limit 1');
			foreach ($station as $station) {
				$station_name = $station->name;
			}
		}

        $email_address = DB::select('select * from users where id = '.$user_id.' limit 1');

        foreach ($email_address as $email_address) {
        	$email_address = htmlspecialchars($email_address->email);
        }

        

        if(empty($skills_raw)) {
        	$skills = [];
        } else {
        	$skills_raw = substr($skills_raw, 1,-2);
	        $skills_raw = explode('},{', $skills_raw);

	        $skills = [];

        	foreach ($skills_raw as $skill_item) {
	        	$skill_item = explode(',', $skill_item);
	        	$skill = DB::select('select * from childskills where id = '.$skill_item[0].' limit 1');
				foreach ($skill as $skill) {
					$skill_name = $skill->skillname;
				}


				switch ($skill_item[1]) {
				  case 1:
				    $skill_level='Beginner';
				    break;
				  case 2:
				    $skill_level='Intermediate';
				    break;
				  case 3:
				    $skill_level='Advanced';
				    break;
				  case 4:
				    $skill_level='Expert';
				    break;
				  default:
				    $skill_level='Undefined';
				}


	        	$skills[] = [
	        		'name' => $skill_name,
	        		'id' => $skill_item[0],
	        		'level' => $skill_level
	        	];
	        }
        }

        


        

        if(empty($desired_skills_raw)) {
        	$desired_skills = [];
        } else {

        	$desired_skills_raw = substr($desired_skills_raw, 0,-1);
	        $desired_skills_raw = explode(',', $desired_skills_raw);

	        $desired_skills = [];
        
	        foreach ($desired_skills_raw as $desired_skill_item) {
	        	$skill = DB::select('select * from childskills where id = '.$desired_skill_item.' limit 1');
	        	foreach ($skill as $skill) {
					$skill_name = $skill->skillname;
				}

				$desired_skills[] = [
	        		'name' => $skill_name,
	        		'id' => $desired_skill_item,
	        	];


	        }
	    }


	    $locations = DB::select('select * from stations');
		$locations_array = [];

		foreach ($locations as $location) {
			$locations_array[] = [
				'id' => $location->id,
				'locationname' => $location->name
			];
		}

		$organizations = DB::select('select * from organizations');
		$organizations_array = [];

		foreach ($organizations as $organizations_item) {
			$organizations_array[] = [
				'id' => $organizations_item->id,
				'organizationname' => $organizations_item->name
			];
		}

       



		$data = ['user_id'=>$user_id, 'first_name'=>$first_name, 'last_name'=>$last_name, 'bio'=>$bio, 'availability'=>$availability, 'availability_text'=>$availability_text, 'organization_name'=>$organization_name, 'organization_id'=>$organization_id, 'station_name'=>$station_name, 'station_id'=>$station_id, 'email_address'=>$email_address, 'skills'=>$skills, 'desired_skills'=>$desired_skills, 'photo'=>$photo, 'locations_array'=>$locations_array, 'organizations_array'=>$organizations_array, 'mentor'=>$mentor, 'host'=>$host, 'mentee'=>$mentee, 'shadow'=>$shadow, 'volunteer'=>$volunteer,'languages'=>$lang];

		if($my_id == $user_id) {
			return view('myprofile',$data);
		} else {
			return view('profile',$data);
		}

		
	}



	public function myprofile(){
    	$user_id =  Auth::user()->id;
		$profile = DB::select('select * from profile where user_id = '.$user_id.' limit 1');

			$first_name = $profile[0]->firstname;
			$last_name = $profile[0]->lastname;
			$organization_id = $profile[0]->organization_id;
			$station_id = $profile[0]->station_id;
			$photo = $profile[0]->photo;
			$skills_raw = $profile[0]->skills;
			$desired_skills_raw = $profile[0]->desired_skills;
			$bio = $profile[0]->bio;
			$availability = $profile[0]->availability;
			$availability_text = $profile[0]->availability_text;

			$mentor = $profile[0]->mentor;
			$host = $profile[0]->host;
			$mentee = $profile[0]->mentee;
			$shadow = $profile[0]->shadow;
			$volunteer = $profile[0]->volunteer;


        
        if($profile[0]->organization_id == "") {
        	$organization_name = "";
        } else {
        	$organization = DB::select('select * from organizations where id = '.$organization_id.' limit 1');

	        foreach ($organization as $organization) {
	        	$organization_name = $organization->name;
	        }
	    }


	   $languages = DB::select('select * from language_user where user_id = '.$user_id.'');

		

		if(empty($languages)) {
        	$lang = [];
        } else {

        	$lang = [];

			foreach ($languages as $language) {

				$language_name = DB::select('select * from languages where id = '.$language->language_id.'');

				switch ($language->writing) {
				  case 1:
				    $writing='Basic (UN Level I)';
				    break;
				  case 2:
				    $writing='Intermediate (UN Level II)';
				    break;
				  case 3:
				    $writing='Advanced (UN Level III)';
				    break;
				  case 4:
				    $writing='Expert (UN Level IV)';
				    break;
				  default:
				    $writing='Undefined';
				}

				switch ($language->reading) {
				  case 1:
				    $reading='Basic (UN Level I)';
				    break;
				  case 2:
				    $reading='Intermediate (UN Level II)';
				    break;
				  case 3:
				    $reading='Advanced (UN Level III)';
				    break;
				  case 4:
				    $reading='Expert (UN Level IV)';
				    break;
				  default:
				    $reading='Undefined';
				}

				switch ($language->speaking) {
				  case 1:
				    $speaking='Basic (UN Level I)';
				    break;
				  case 2:
				    $speaking='Intermediate (UN Level II)';
				    break;
				  case 3:
				    $speaking='Advanced (UN Level III)';
				    break;
				  case 4:
				    $speaking='Expert (UN Level IV)';
				    break;
				  default:
				    $speaking='Undefined';
				}

				switch ($language->understanding) {
				  case 1:
				    $understanding='Basic (UN Level I)';
				    break;
				  case 2:
				    $understanding='Intermediate (UN Level II)';
				    break;
				  case 3:
				    $understanding='Advanced (UN Level III)';
				    break;
				  case 4:
				    $understanding='Expert (UN Level IV)';
				    break;
				  default:
				    $understanding='Undefined';
				}




				$lang[] = [
	        		'name' => $language_name[0]->name,
	        		'writing' => $writing,
	        		'reading' => $reading,
	        		'speaking' => $speaking,
	        		'understanding' => $understanding,
	        		'native' => $language->native,
	        	];
			}
		}




		if($station_id == ""){
			$station_name = "";
		} else {
			$station = DB::select('select * from stations where id = '.$station_id.' limit 1');
			foreach ($station as $station) {
				$station_name = $station->name;
			}
		}

        $email_address = DB::select('select * from users where id = '.$user_id.' limit 1');

        foreach ($email_address as $email_address) {
        	$email_address = htmlspecialchars($email_address->email);
        }

        

        if(empty($skills_raw)) {
        	$skills = [];
        } else {
        	$skills_raw = substr($skills_raw, 1,-2);
	        $skills_raw = explode('},{', $skills_raw);

	        $skills = [];

        	foreach ($skills_raw as $skill_item) {
	        	$skill_item = explode(',', $skill_item);
	        	$skill = DB::select('select * from childskills where id = '.$skill_item[0].' limit 1');
				foreach ($skill as $skill) {
					$skill_name = $skill->skillname;
				}


				switch ($skill_item[1]) {
				  case 1:
				    $skill_level='Beginner';
				    break;
				  case 2:
				    $skill_level='Intermediate';
				    break;
				  case 3:
				    $skill_level='Advanced';
				    break;
				  case 4:
				    $skill_level='Expert';
				    break;
				  default:
				    $skill_level='Undefined';
				}


	        	$skills[] = [
	        		'name' => $skill_name,
	        		'id' => $skill_item[0],
	        		'level' => $skill_level
	        	];
	        }
        }

        


        

        if(empty($desired_skills_raw)) {
        	$desired_skills = [];
        } else {

        	$desired_skills_raw = substr($desired_skills_raw, 0,-1);
	        $desired_skills_raw = explode(',', $desired_skills_raw);

	        $desired_skills = [];
        
	        foreach ($desired_skills_raw as $desired_skill_item) {
	        	$skill = DB::select('select * from childskills where id = '.$desired_skill_item.' limit 1');
	        	foreach ($skill as $skill) {
					$skill_name = $skill->skillname;
				}

				$desired_skills[] = [
	        		'name' => $skill_name,
	        		'id' => $desired_skill_item,
	        	];


	        }
	    }


	    $locations = DB::select('select * from stations');
		$locations_array = [];

		foreach ($locations as $location) {
			$locations_array[] = [
				'id' => $location->id,
				'locationname' => $location->name
			];
		}

		$organizations = DB::select('select * from organizations');
		$organizations_array = [];

		foreach ($organizations as $organizations_item) {
			$organizations_array[] = [
				'id' => $organizations_item->id,
				'organizationname' => $organizations_item->name
			];
		}

       



		$data = ['user_id'=>$user_id, 'first_name'=>$first_name, 'last_name'=>$last_name, 'bio'=>$bio, 'availability'=>$availability, 'organization_name'=>$organization_name, 'organization_id'=>$organization_id, 'station_name'=>$station_name, 'availability_text'=>$availability_text, 'station_id'=>$station_id, 'email_address'=>$email_address, 'skills'=>$skills, 'desired_skills'=>$desired_skills, 'photo'=>$photo, 'locations_array'=>$locations_array, 'organizations_array'=>$organizations_array, 'mentor'=>$mentor, 'host'=>$host, 'mentee'=>$mentee, 'shadow'=>$shadow, 'volunteer'=>$volunteer, 'languages'=>$lang];

		return view('myprofile',$data);

		
	}




	public function updateprofile(Request $request) {

		$user_id =  Auth::user()->id;
		$email = Auth::user()->email;

		$update_firstname = $request->input('update_firstname');
		$update_lastname = $request->input('update_lastname');
		$update_email = $request->input('update_email');
		$update_station = $request->input('update_station');
		$update_organization = $request->input('update_organization');
		$update_bio = $request->input('update_bio');
		$update_availability = $request->input('update_availability');
		$update_availability_text = $request->input('update_availability_text');

		$update_mentor = $request->input('update_mentor');
		if(!empty($update_mentor)) {
			$mentor = 1;
		} else {
			$mentor = 0;
		}

		$update_host = $request->input('update_host');
		if(!empty($update_host)) {
			$host = 1;
		} else {
			$host = 0;
		}

		$update_mentee = $request->input('update_mentee');
		if(!empty($update_mentee)) {
			$mentee = 1;
		} else {
			$mentee = 0;
		}

		$update_shadow = $request->input('update_shadow');
		if(!empty($update_shadow)) {
			$shadow = 1;
		} else {
			$shadow = 0;
		}

		$update_volunteer = $request->input('update_volunteer');
		if(!empty($update_volunteer)) {
			$volunteer = 1;
		} else {
			$volunteer = 0;
		}



		$name = $update_firstname. ' ' .$update_lastname;

		DB::update('update profile set firstname=?, lastname=?, mentor=?, availability=?, availability_text=?, host=?, mentee=?, shadow=?, volunteer=?, bio=?, station_id=?, organization_id=?  where user_id=?',[$update_firstname, $update_lastname, $mentor, $update_availability, $update_availability_text, $host, $mentee, $shadow, $volunteer, $update_bio, $update_station, $update_organization, $user_id]);



		DB::update('update users set name=?, email=? where id=?',[$name, $update_email, $user_id]);

		if ($email != $update_email) {
			DB::update('update users set email_verified_at=null where id='.$user_id.'');
			return redirect()->route('verification.notice');
		}
		
		return redirect()->route('myprofile');

	}


	public function getskill_id(Request $request) {
		$term = $request->input('term');

		// $skills = DB::select('select * from childskills where skillname like \''.$term.'\'');
		$skills = DB::table('childskills')->where('skillname', 'LIKE', "%{$term}%")->get();

		if (count($skills) == 1) {
			$skill_id = $skills[0]->id;

			$data = [
				'skill_id'=>$skill_id,
				'skill_name'=>$term
			];
		} else {
			$data = ['error'=>'wrong query'];
		}

		return response()->json($data);

	}


	public function deletedesiredskill(Request $request) {
		$user_id = $request->input('user_id');
		$skill = $request->input('skill_id');



		$data = ['user'=>$user_id, 'skill'=>$skill];

		return response()->json($data);

	}




	public function adddesiredskills() {

		$user_id =  Auth::user()->id;

		$profile = DB::select('select * from profile where user_id = '.$user_id.' limit 1');

		$desired_skills_raw = $profile[0]->desired_skills;

		$desired_skills_raw_name = "";

		if(empty($desired_skills_raw)) {
        	$desired_skills = [];
        } else {

        	$desired_skills_raw = substr($desired_skills_raw, 0,-1);
	        $desired_skills_raw = explode(',', $desired_skills_raw);

	        $desired_skills = [];
        
	        foreach ($desired_skills_raw as $desired_skill_item) {
	        	// $skill = DB::select('select * from childskills where id = '.$desired_skill_item.' limit 1');
				$skill = DB::table('childskills')->where('id', $desired_skill_item)->get()->take(1);
	        	foreach ($skill as $skill) {
					$skill_name = $skill->skillname;
				}

				$desired_skills_raw_name = $skill_name.';'.$desired_skills_raw_name;


				$desired_skills[] = [
	        		'name' => $skill_name,
	        		'id' => $desired_skill_item,
	        	];


	        }
	    }





		$parentskills = DB::select('select * from parentskills');

		$parentskill_list = [];

		foreach($parentskills as $parentskill) {
			$childskills_id = DB::select('select * from childskill_parentskill where parentskill_id = '.$parentskill->id.'');

			$childskill = [];

			foreach($childskills_id as $childskill_id) {

				$childskill_data = DB::select('select * from childskills where id = '.$childskill_id->id.'');

				foreach($childskill_data as $childskill_data) {
					$childskill[] = [
		    			'skillname' => $childskill_data->skillname,
		    			'id' => $childskill_data->id,
		    		];
		    	}
			}



    		$parentskill_list[] = [
    			 'skillname' => $parentskill->skillname,
    			 'id' => $parentskill->id,
    			 'childskills' => $childskill
    		];
    	}


    	$data = ['parentskills'=>$parentskill_list,'desired_skills'=>$desired_skills,'desired_skills_raw_name'=>$desired_skills_raw_name];

		return view('adddesiredskills',$data);
	}





	public function adddesiredskillspost(Request $request) {

		$user_id =  Auth::user()->id;

		$skills_raw = $request->input('skillsarray');
		
		$skills_raw = substr($skills_raw, 0, -1);
        $skills_raw = explode(';', $skills_raw);

        $skills = '';

        foreach ($skills_raw as $skill_item) {
            // $skill = DB::select('select * from childskills where skillname = \''.$skill_item.'\' limit 1');
            $skill = DB::table('childskills')->where('skillname', $skill_item)->get()->take(1);
            foreach ($skill as $skill) {
                $skill_id = $skill->id;
            }

            $skills = $skill_id. ',' .$skills;

        }

        DB::update('update profile set desired_skills=? where user_id=?',[$skills,$user_id]);




		return redirect()->route('myprofile');
	}



	public function addskills() {

		$user_id =  Auth::user()->id;

		$profile = DB::select('select * from profile where user_id = '.$user_id.' limit 1');

		$skills_raw = $profile[0]->skills;

		$skills_raw_name = "";

		if(empty($skills_raw)) {
        	$skills = [];
        } else {
        	$skills_raw = substr($skills_raw, 1,-2);
	        $skills_raw = explode('},{', $skills_raw);

	        $skills = [];

        	foreach ($skills_raw as $skill_item) {
	        	$skill_item = explode(',', $skill_item);
	        	// $skill = DB::select('select * from childskills where id = '.$skill_item[0].' limit 1');
				$skill = DB::table('childskills')->where('id', $skill_item[0])->get()->take(1);
				foreach ($skill as $skill) {
					$skill_name = $skill->skillname;
				}


				switch ($skill_item[1]) {
				  case 1:
				    $skill_level='Beginner';
				    break;
				  case 2:
				    $skill_level='Intermediate';
				    break;
				  case 3:
				    $skill_level='Advanced';
				    break;
				  case 4:
				    $skill_level='Expert';
				    break;
				  default:
				    $skill_level='Undefined';
				}

				$skills_raw_name = $skill_name.'%'.$skill_level.';'.$skills_raw_name;


	        	$skills[] = [
	        		'name' => $skill_name,
	        		'id' => $skill_item[0],
	        		'level' => $skill_level
	        	];
	        }
        }


		$parentskills = DB::select('select * from parentskills');

		$parentskill_list = [];

		foreach($parentskills as $parentskill) {
			$childskills_id = DB::select('select * from childskill_parentskill where parentskill_id = '.$parentskill->id.'');

			$childskill = [];

			foreach($childskills_id as $childskill_id) {

				$childskill_data = DB::select('select * from childskills where id = '.$childskill_id->id.'');

				foreach($childskill_data as $childskill_data) {
					$childskill[] = [
		    			'skillname' => $childskill_data->skillname,
		    			'id' => $childskill_data->id,
		    		];
		    	}
			}



    		$parentskill_list[] = [
    			 'skillname' => $parentskill->skillname,
    			 'id' => $parentskill->id,
    			 'childskills' => $childskill
    		];
    	}


    	$data = ['parentskills'=>$parentskill_list,'skills'=>$skills,'skills_raw_name'=>$skills_raw_name];

		return view('addskills',$data);
	}





	public function addskillspost(Request $request) {

		$user_id =  Auth::user()->id;

		$skills_raw = $request->input('skillsarray');
		
		$skills_raw = substr($skills_raw, 0, -1);
        $skills_raw = explode(';', $skills_raw);

        $skills = '';

        foreach ($skills_raw as $skill_item) {

        	$skill_name_lvl = [];


        	$skill_name_lvl = explode('%', $skill_item);


            // $skill = DB::select('select * from childskills where skillname = \''.$skill_name_lvl[0].'\' limit 1');
			$skill = DB::table('childskills')->where('skillname', $skill_name_lvl[0])->get()->take(1);
            
            foreach ($skill as $skill) {
                $skill_id = $skill->id;

                switch ($skill_name_lvl[1]) {
				  case 'Beginner':
				    $skill_level=1;
				    break;
				  case 'Intermediate':
				    $skill_level=2;
				    break;
				  case 'Advanced':
				    $skill_level=3;
				    break;
				  case 'Expert':
				    $skill_level=4;
				    break;
				  default:
				    $skill_level=0;
				}

            }

            $skills = '{'.$skill_id. ',' .$skill_level. '},' .$skills;

        }

        DB::update('update profile set skills=? where user_id=?',[$skills,$user_id]);




		return redirect()->route('myprofile');
	}


	public function updatelanguage() {

		$user_id =  Auth::user()->id;

		$languages_raw = DB::select('select * from languages');

		$languages = [];

		foreach ($languages_raw as $language) {

			$lang_user = DB::select('select * from language_user where language_id = '.$language->id.' and user_id = '.$user_id.' ');

			if(empty($lang_user)) {
	        	$lang_active = 0;
	        	$lang_writing =0;
	        	$lang_reading = 0;
	        	$lang_speaking = 0;
	        	$lang_understanding = 0;
	        	$lang_native = 0;
	        } else {
	        	$lang_active = 1;
	        	$lang_writing = $lang_user[0]->writing;
	        	$lang_reading = $lang_user[0]->reading;
	        	$lang_speaking = $lang_user[0]->speaking;
	        	$lang_understanding =  $lang_user[0]->understanding;
	        	$lang_native =  $lang_user[0]->native;
	        }

			$languages[] = [
				'name' => $language->name,
				'id' => $language->id,
				'active' => $lang_active,
				'writing' => $lang_writing,
				'reading' => $lang_reading,
				'speaking' => $lang_speaking,
				'understanding' => $lang_understanding,
				'native' => $lang_native
			];
		}

		$data = ['languages'=>$languages];

		return view('updatelanguage',$data);
	}




	public function updatelanguagepost(Request $request) {

		$user_id =  Auth::user()->id;

		$arabic = DB::select('select * from language_user where user_id = '.$user_id.' and language_id = 1');
		$update_arabic = $request->input('update-Arabic');

		if(empty($arabic)) {
        	

			if(!empty($update_arabic)) {

				$arabic_writing = $request->input('update-Arabic-writing');
				$arabic_reading = $request->input('update-Arabic-reading');
				$arabic_speaking = $request->input('update-Arabic-speaking');
				$arabic_understanding = $request->input('update-Arabic-understanding');
				$arabic_native = $request->input('native-Arabic');

				if(!empty($arabic_native)) {
					$arabic_native = 1;
				} else {
					$arabic_native = 0;
				}

				$id = DB::table('language_user')->insertGetId(
		            [
		            	'user_id' => $user_id,
		                'language_id' => 1,
		                'writing' => $arabic_writing,
		                'reading' => $arabic_reading,
		                'speaking' => $arabic_speaking,
		                'understanding' => $arabic_understanding,
		                'native' => $arabic_native
		            ]
		        );

		        $arabic_s = 1;

			} else {
				$arabic_s = 0;
			}

        } else {
        	
        	if(!empty($update_arabic)) {

        		$arabic_writing = $request->input('update-Arabic-writing');
				$arabic_reading = $request->input('update-Arabic-reading');
				$arabic_speaking = $request->input('update-Arabic-speaking');
				$arabic_understanding = $request->input('update-Arabic-understanding');
				$arabic_native = $request->input('native-Arabic');

				if(!empty($arabic_native)) {
					$arabic_native = 1;
				} else {
					$arabic_native = 0;
				}


        		DB::update('update language_user set writing=?, reading=?, speaking=?, understanding=?, native=? where user_id = '.$user_id.' and language_id = 1',[$arabic_writing, $arabic_reading, $arabic_speaking, $arabic_understanding, $arabic_native]);

        	} else {

				$arabic = DB::delete('delete from language_user where user_id = '.$user_id.' and language_id = 1');
			}

        }



        $chinese = DB::select('select * from language_user where user_id = '.$user_id.' and language_id = 2');
		$update_chinese = $request->input('update-Chinese');

		if(empty($chinese)) {
        	

			if(!empty($update_chinese)) {

				$chinese_writing = $request->input('update-Chinese-writing');
				$chinese_reading = $request->input('update-Chinese-reading');
				$chinese_speaking = $request->input('update-Chinese-speaking');
				$chinese_understanding = $request->input('update-Chinese-understanding');
				$chinese_native = $request->input('native-Chinese');

				if(!empty($chinese_native)) {
					$chinese_native = 1;
				} else {
					$chinese_native = 0;
				}

				$id = DB::table('language_user')->insertGetId(
		            [
		            	'user_id' => $user_id,
		                'language_id' => 2,
		                'writing' => $chinese_writing,
		                'reading' => $chinese_reading,
		                'speaking' => $chinese_speaking,
		                'understanding' => $chinese_understanding,
		                'native' => $chinese_native
		            ]
		        );

		        $chinese_s = 1;

			} else {
				$chinese_s = 0;
			}

        } else {
        	
        	if(!empty($update_chinese)) {

        		$chinese_writing = $request->input('update-Chinese-writing');
				$chinese_reading = $request->input('update-Chinese-reading');
				$chinese_speaking = $request->input('update-Chinese-speaking');
				$chinese_understanding = $request->input('update-Chinese-understanding');
				$chinese_native = $request->input('native-Chinese');

				if(!empty($chinese_native)) {
					$chinese_native = 1;
				} else {
					$chinese_native = 0;
				}


        		DB::update('update language_user set writing=?, reading=?, speaking=?, understanding=?, native=? where user_id = '.$user_id.' and language_id = 2',[$chinese_writing, $chinese_reading, $chinese_speaking, $chinese_understanding, $chinese_native]);

        	} else {

				$chinese = DB::delete('delete from language_user where user_id = '.$user_id.' and language_id = 2');
			}

        }


        $english = DB::select('select * from language_user where user_id = '.$user_id.' and language_id = 3');
		$update_english = $request->input('update-English');

		if(empty($english)) {
        	

			if(!empty($update_english)) {

				$english_writing = $request->input('update-English-writing');
				$english_reading = $request->input('update-English-reading');
				$english_speaking = $request->input('update-English-speaking');
				$english_understanding = $request->input('update-English-understanding');
				$english_native = $request->input('native-English');

				if(!empty($english_native)) {
					$english_native = 1;
				} else {
					$english_native = 0;
				}

				$id = DB::table('language_user')->insertGetId(
		            [
		            	'user_id' => $user_id,
		                'language_id' => 3,
		                'writing' => $english_writing,
		                'reading' => $english_reading,
		                'speaking' => $english_speaking,
		                'understanding' => $english_understanding,
		                'native' => $english_native
		            ]
		        );

		        $english_s = 1;

			} else {
				$english_s = 0;
			}

        } else {
        	
        	if(!empty($update_english)) {

        		$english_writing = $request->input('update-English-writing');
				$english_reading = $request->input('update-English-reading');
				$english_speaking = $request->input('update-English-speaking');
				$english_understanding = $request->input('update-English-understanding');
				$english_native = $request->input('native-English');

				if(!empty($english_native)) {
					$english_native = 1;
				} else {
					$english_native = 0;
				}


        		DB::update('update language_user set writing=?, reading=?, speaking=?, understanding=?, native=? where user_id = '.$user_id.' and language_id = 3',[$english_writing, $english_reading, $english_speaking, $english_understanding, $english_native]);

        	} else {

				$english = DB::delete('delete from language_user where user_id = '.$user_id.' and language_id = 3');
			}

        }



        $french = DB::select('select * from language_user where user_id = '.$user_id.' and language_id = 4');
		$update_french = $request->input('update-French');

		if(empty($french)) {
        	

			if(!empty($update_french)) {

				$french_writing = $request->input('update-French-writing');
				$french_reading = $request->input('update-French-reading');
				$french_speaking = $request->input('update-French-speaking');
				$french_understanding = $request->input('update-French-understanding');
				$french_native = $request->input('native-French');

				if(!empty($french_native)) {
					$french_native = 1;
				} else {
					$french_native = 0;
				}

				$id = DB::table('language_user')->insertGetId(
		            [
		            	'user_id' => $user_id,
		                'language_id' => 4,
		                'writing' => $french_writing,
		                'reading' => $french_reading,
		                'speaking' => $french_speaking,
		                'understanding' => $french_understanding,
		                'native' => $french_native
		            ]
		        );

		        $french_s = 1;

			} else {
				$french_s = 0;
			}

        } else {
        	
        	if(!empty($update_french)) {

        		$french_writing = $request->input('update-French-writing');
				$french_reading = $request->input('update-French-reading');
				$french_speaking = $request->input('update-French-speaking');
				$french_understanding = $request->input('update-French-understanding');
				$french_native = $request->input('native-French');

				if(!empty($french_native)) {
					$french_native = 1;
				} else {
					$french_native = 0;
				}


        		DB::update('update language_user set writing=?, reading=?, speaking=?, understanding=?, native=? where user_id = '.$user_id.' and language_id = 4',[$french_writing, $french_reading, $french_speaking, $french_understanding, $french_native]);

        	} else {

				$french = DB::delete('delete from language_user where user_id = '.$user_id.' and language_id = 4');
			}

        }

        		$russian = DB::select('select * from language_user where user_id = '.$user_id.' and language_id = 5');
		$update_russian = $request->input('update-Russian');

		if(empty($russian)) {
        	

			if(!empty($update_russian)) {

				$russian_writing = $request->input('update-Russian-writing');
				$russian_reading = $request->input('update-Russian-reading');
				$russian_speaking = $request->input('update-Russian-speaking');
				$russian_understanding = $request->input('update-Russian-understanding');
				$russian_native = $request->input('native-Russian');

				if(!empty($russian_native)) {
					$russian_native = 1;
				} else {
					$russian_native = 0;
				}

				$id = DB::table('language_user')->insertGetId(
		            [
		            	'user_id' => $user_id,
		                'language_id' => 5,
		                'writing' => $russian_writing,
		                'reading' => $russian_reading,
		                'speaking' => $russian_speaking,
		                'understanding' => $russian_understanding,
		                'native' => $russian_native
		            ]
		        );

		        $russian_s = 1;

			} else {
				$russian_s = 0;
			}

        } else {
        	
        	if(!empty($update_russian)) {

        		$russian_writing = $request->input('update-Russian-writing');
				$russian_reading = $request->input('update-Russian-reading');
				$russian_speaking = $request->input('update-Russian-speaking');
				$russian_understanding = $request->input('update-Russian-understanding');
				$russian_native = $request->input('native-Russian');

				if(!empty($russian_native)) {
					$russian_native = 1;
				} else {
					$russian_native = 0;
				}


        		DB::update('update language_user set writing=?, reading=?, speaking=?, understanding=?, native=? where user_id = '.$user_id.' and language_id = 5',[$russian_writing, $russian_reading, $russian_speaking, $russian_understanding, $russian_native]);

        	} else {

				$russian = DB::delete('delete from language_user where user_id = '.$user_id.' and language_id = 5');
			}

        }

        $spanish = DB::select('select * from language_user where user_id = '.$user_id.' and language_id = 6');
		$update_spanish = $request->input('update-Spanish');

		if(empty($spanish)) {
        	

			if(!empty($update_spanish)) {

				$spanish_writing = $request->input('update-Spanish-writing');
				$spanish_reading = $request->input('update-Spanish-reading');
				$spanish_speaking = $request->input('update-Spanish-speaking');
				$spanish_understanding = $request->input('update-Spanish-understanding');
				$spanish_native = $request->input('native-Spanish');

				if(!empty($spanish_native)) {
					$spanish_native = 1;
				} else {
					$spanish_native = 0;
				}

				$id = DB::table('language_user')->insertGetId(
		            [
		            	'user_id' => $user_id,
		                'language_id' => 6,
		                'writing' => $spanish_writing,
		                'reading' => $spanish_reading,
		                'speaking' => $spanish_speaking,
		                'understanding' => $spanish_understanding,
		                'native' => $spanish_native
		            ]
		        );

		        $spanish_s = 1;

			} else {
				$spanish_s = 0;
			}

        } else {
        	
        	if(!empty($update_spanish)) {

        		$spanish_writing = $request->input('update-Spanish-writing');
				$spanish_reading = $request->input('update-Spanish-reading');
				$spanish_speaking = $request->input('update-Spanish-speaking');
				$spanish_understanding = $request->input('update-Spanish-understanding');
				$spanish_native = $request->input('native-Spanish');

				if(!empty($spanish_native)) {
					$spanish_native = 1;
				} else {
					$spanish_native = 0;
				}


        		DB::update('update language_user set writing=?, reading=?, speaking=?, understanding=?, native=? where user_id = '.$user_id.' and language_id = 6',[$spanish_writing, $spanish_reading, $spanish_speaking, $spanish_understanding, $spanish_native]);

        	} else {

				$spanish = DB::delete('delete from language_user where user_id = '.$user_id.' and language_id = 6');
			}

        }







		
		return redirect()->route('myprofile');
	}




	public function projects($user_id){

		$projects = DB::select('select * from projects_user where user_id = '.$user_id.'');

		$data = [];

		if ($projects) {
			foreach ($projects as $project) {

				error_log($project->project_id);

				$project_details = DB::select('select * from projects where id = '.$project->project_id.'');

	           	foreach ($project_details as $project_detail) {
	           		error_log($project_detail->title);

	           		$project_description = substr($project_detail->project_description, 0, 150);
	           		if (strlen($project_detail->project_description) > 150){
	           			$project_description = $project_description."...";
	           		}


	           		$data[] = [
		                'title' => $project_detail->title,
		                'detail' => $project_description,
		                'id' => $project_detail->id
		            ];
	           	}

	        }
		}


		return response()->json($data);
	}

	public function skills($user_id){

		$skills = DB::select('select * from childskill_user where user_id = '.$user_id.'');

		$data = [];

		if ($skills) {
			foreach ($skills as $skill) {

				error_log($skill->childskill_id);

			/*	$project_details = DB::select('select * from projects where id = '.$project->project_id.'');

	           	foreach ($project_details as $project_detail) {
	           		error_log($project_detail->title);

	           		 $data[] = [
		                'title' => $project_detail->title,
		                'detail' => $project_detail->project_description,
		                'id' => $project_detail->id
		            ];
	           	}*/

	        }
		}


		return response()->json($data);
	}

	public function storeImage(Request $request) {
        // $this->validate($request, [
        //     'file' => 'mimes:jpg,jpeg,png|max:8000',
        // ]);

        $user_id =  Auth::user()->id;

        $file = $request->file('file'); //your base64 encoded data

        $fileName = Str::random(10).$user_id.'.'.$file->getClientOriginalExtension();

        $path = $file->storeAs('public', $fileName);
        

        DB::update('update profile set photo=? where user_id=?',[$fileName, $user_id]);

        return redirect()->route('myprofile');
    }
}




