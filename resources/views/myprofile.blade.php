<x-app-layout>
<!--     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
 -->
<div id="main" class="container pb-4">
  <div class="container">
  <div class="row">
    <div class="col-sm-4">

      <h6 class="light-grey">&nbsp;</h6>
      <div class="card mt-3 pt-0">
        <div class="card-body text-center">

        
          @if ($photo == "")
            <div class="profile-image-big">
              <?php echo substr($first_name, 0, 1); echo substr($last_name, 0, 1);?>
            </div>
          @else
            <div class="profile-image-big" style="background:url('<?php echo config('app.url'); ?>/storage/{{ $photo }}'); background-size:cover;">
            </div>


          @endif

          <form action="updateimage" method="post" id="image" enctype="multipart/form-data">
           @csrf
          <label for="file" class="btn btn-secondary mb-3 btn-sm" style="margin-top:-32px;">Change Profile Image</label>
          <input type="file" name="file" id="file" size="40" hidden>
         
          <input type="submit" value="Send" hidden>
          </form>
       	

          <script>
             document.getElementById("file").onchange = function() {
              document.getElementById("image").submit();
          };
          </script>

          <h2 class="orange">{{ $last_name }}, {{ $first_name }}</h2>

          <div class="mt-3 mb-3">
            @if ($availability == 1)
              <span class="alert alert-success" role="alert" style="padding:8px;">Available<?php if($availability_text != null) { echo ' | '.$availability_text; } ?></span> 
            @else
              <span class="alert alert-danger" role="alert" style="padding:8px;">Unavailable<?php if($availability_text != null) { echo ' | '.$availability_text; } ?></span>  
            @endif
          </div>
    
          <h5 class="light-grey">
          	

          	@if ($organization_name == "" or $station_name == "")
          		{{ $organization_name}}{{ $station_name }} 
          	@else
          		{{ $organization_name}}  |  {{ $station_name }}
          	@endif
          	
          </h5>
          <h5 class="light-grey" id="status"><?php if($mentor == 1) { echo 'Mentor, ';} ?><?php if($host == 1) { echo 'Host, ';} ?><?php if($mentee == 1) { echo 'Mentee, ';} ?><?php if($shadow == 1) { echo 'Shadow, ';} ?><?php if($volunteer == 1) { echo 'Volunteer, ';} ?></h5>

          <script>
            raw = $('#status').html();
            $('#status').html(raw.slice(0,-2));
          </script>


          <h5 class="mt-3">
          	<a href="#">
          		{{ $email_address }}
          	</a>
          </h5>
          <button type="button" class="btn btn-primary btn-lg mt-5" data-bs-toggle="modal" data-bs-target="#updateprofile">Update Details</button>





        </div>

        


      </div>


       @if ( $bio != null )
        <div class="card mt-3 pt-0">
          <div class="card-body text-left">
            {{ $bio }}
          </div>
        </div>
        @endif


    </div>


      
    <div class="col-sm-8">


      <h6 class="light-grey" id="skillsheader">Skills</h6>

      

      <div class="card mt-3">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-7">

              @foreach($skills as $skill)

                <div class="row skill mb-2">
                  <div class="col-sm-3">
                    <div class="skill-pill {{ $skill['level'] }}">{{ $skill['level'] }}</div>
                  </div>
                  <div class="col-sm-9"><a href="<?php echo config('app.url'); ?>/search?term={{ urlencode($skill['name']) }}"><h5 class="orange">{{ $skill['name'] }}</h5></a></div>
                </div>
                
              @endforeach 

              <a href="<?php echo config('app.url'); ?>/addskills" class="btn btn-primary btn-lg mt-5">Update Skills</a>

              

            </div>

            <script>

            </script>



            <div class="col-sm-5">
              <h4 class="light-grey">{{$first_name}} wants to develop the following skills</h4>
              <ul class="link-list">
                @foreach($desired_skills as $desired_skill)
                <li><a href="<?php echo config('app.url'); ?>/search?term={{ urlencode($desired_skill['name']) }}">{{ $desired_skill['name'] }}</a></li>
                @endforeach 
              </ul>
              <a href="<?php echo config('app.url'); ?>/adddesiredskills" class="btn btn-primary btn-lg mt-5">Update Desired Skills</a>

            </div>
          </div>
        


        </div>


      </div>

      

      <h6 class="light-grey mt-4">Languages</h6>


      <div class="card mt-3">
        <div class="card-body">

          @foreach($languages as $lang)

          <div class="row skill mb-2">
            <div class="col-sm-4">
              <h5 class="grey">{{ $lang['name'] }}</h5>
              <h6 class="light-grey"><?php if($lang['native'] == 1){ echo "Main Language"; } ?></h6>
            </div>
            <div class="col-sm-2">
              <h6 class="grey">Writing</h6>
              <h6 class="orange">{{ $lang['writing'] }}</h6>
            </div>
            <div class="col-sm-2">
              <h6 class="grey">Reading</h6>
              <h6 class="orange">{{ $lang['reading'] }}</h6>
            </div>
            <div class="col-sm-2">
              <h6 class="grey">Speaking</h6>
              <h6 class="orange">{{ $lang['speaking'] }}</h6>
            </div>
            <div class="col-sm-2">
              <h6 class="grey">Listening</h6>
              <h6 class="orange">{{ $lang['understanding'] }}</h6>
            </div>
          </div>


          <hr>

          @endforeach

          <a href="<?php echo config('app.url'); ?>/updatelanguage" class="btn btn-primary btn-lg mt-5">Update Language</a>

         

        </div>
      </div>






      <h6 class="light-grey  mt-4" id="projects-header">Projects</h6>
      <div class="card mt-3 pt-0" id="projects-card">
        <div class="card-body" id="projects">


          	<div class="row">
          		<div class="col-sm-12 text-center">
        			<img src="{{ asset('img/preloader.gif') }}" class="preloader">
        		</div>
        	</div>

         
        </div>
        <script>

			$.getJSON("<?php echo config('app.url'); ?>/profile/{{ $user_id }}/projects", function(data){
				$('#projects').html('');
		    for (var i = 0, len = data.length; i < len; i++) {
		        project = data[i];
		        $("#projects").append('<div class="row card-item"><div class="col-sm-12"><a class="orange" href="<?php echo config('app.url'); ?>/project/'+project.id+'"><h5>'+project.title+'</h5></a><p class="sub light-grey">Remote  |  Early Phase  |  5 People Needed</p><p class="grey">'+project.detail+'</p></div></div>');  
		    }

        if (data.length == 0) {
          $('#projects').remove();
          $('#projects-header').remove();
          $('#projects-card').remove();
          $('#skillsheader').removeClass('mt-4');
        }
			});

        </script>
      </div>





    </div>
  </div>
</div>

</div><!-- /.container -->

<div class="modal fade" id="updateprofile" tabindex="-1" aria-labelledby="updateprofile" aria-hidden="true">
  <div class="modal-dialog">
    <form action="myprofile" method="post">
      @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update your details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <div class="row">
          <div class="col-sm-12">
            <div class="form-floating">
              <input type="text" class="form-control" id="update_firstname" name="update_firstname" placeholder="Enter First Name" value="{{ $first_name }}">
              <label for="projectitle">First Name</label>
            </div>
            <div class="form-floating mt-3">
              <input type="text" class="form-control" id="update_lastname" name="update_lastname" placeholder="Enter First Name" value="{{ $last_name }}">
              <label for="projectitle">First Name</label>
            </div>
            <div class="form-floating mt-3">
              <input type="text" class="form-control" id="update_email" name="update_email" placeholder="Enter Email Address" value="{{ $email_address }}">
              <label for="projectitle">Email Address</label>
              <p>Changing your email address will log you out. We'll ask you to verify your email again.</p>
            </div>


            <div class="mt-3">
              <label for="update_availability" class="form-label">Availability</label>
              <select name="update_availability" id="update_availability" class="form-select">
                @if ($availability == "1")
                  <option value="1" selected>Available</option>
                  <option value="0">Not Available</option>
                @else 
                  <option value="1">Available</option>
                  <option value="0" selected>Not Available</option>
                @endif
                
              </select>
            </div>

            <div class="form-floating">
              <input type="text" class="form-control" id="update_availability_text" name="update_availability_text" placeholder="Availability Status" value="{{ $availability_text }}">
              <label for="update_availability_text">Availability Status</label>
            </div>


            <div class="mt-3">
              <label for="update_station" class="form-label">Duty Station</label>
              <select name="update_station" id="update_station" class="form-select">
                @if ($station_name == "")
                  <option disabled selected>Select Station</option>
                @else 
                  <option disabled>Select Station</option>
                @endif
                @foreach($locations_array as $location)
                  @if ($station_id == $location['id'])
                    <option value="{{ $location['id']}}" selected>{{$location['locationname']}}</option>
                  @else
                    <option value="{{ $location['id']}}">{{$location['locationname']}}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="mt-3">
              <label for="update_organization" class="form-label">Organization</label>
              <select name="update_organization" id="update_organization" class="form-select">
                @if ($organization_name == "")
                  <option disabled selected>Select Organization</option>
                @else 
                  <option disabled>Select Organization</option>
                @endif
                @foreach($organizations_array as $organization)
                  @if ($organization_id == $organization['id'])
                    <option value="{{ $organization['id']}}" selected>{{$organization['organizationname']}}</option>
                  @else
                    <option value="{{ $organization['id']}}">{{$organization['organizationname']}}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="mt-3">
              <label for="update_statuses" class="form-label">Select your status</label>
              <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                
                @if ($mentor == 1)
                  <input type="checkbox" class="btn-check" id="update_mentor" name="update_mentor" value="1" autocomplete="off" checked>
                  <label class="btn btn-outline-primary" for="update_mentor" name="update_mentor">Mentor</label>
                @else
                  <input type="checkbox" class="btn-check" id="update_mentor" name="update_mentor" value="1" autocomplete="off">
                  <label class="btn btn-outline-primary" for="update_mentor" name="update_mentor">Mentor</label>
                @endif

                @if ($host == 1)
                  <input type="checkbox" class="btn-check" id="update_host" name="update_host" value="1" autocomplete="off" checked>
                  <label class="btn btn-outline-primary" for="update_host" name="update_host">Host</label>
                @else
                  <input type="checkbox" class="btn-check" id="update_host" name="update_host" value="1" autocomplete="off">
                  <label class="btn btn-outline-primary" for="update_host" name="update_host">Host</label>
                @endif

                @if ($mentee == 1)
                  <input type="checkbox" class="btn-check" id="update_mentee" name="update_mentee" value="1" autocomplete="off" checked>
                  <label class="btn btn-outline-primary" for="update_mentee" name="update_mentee">Mentee</label>
                @else
                  <input type="checkbox" class="btn-check" id="update_mentee" name="update_mentee" value="1" autocomplete="off">
                  <label class="btn btn-outline-primary" for="update_mentee" name="update_mentee">Mentee</label>
                @endif

                @if ($shadow == 1)
                  <input type="checkbox" class="btn-check" id="update_shadow" name="update_shadow" value="1" autocomplete="off" checked>
                  <label class="btn btn-outline-primary" for="update_shadow" name="update_shadow">Shadow</label>
                @else
                  <input type="checkbox" class="btn-check" id="update_shadow" name="update_shadow" value="1" autocomplete="off">
                  <label class="btn btn-outline-primary" for="update_shadow" name="update_shadow">Shadow</label>
                @endif

                @if ($volunteer == 1)
                  <input type="checkbox" class="btn-check" id="update_volunteer" name="update_volunteer" value="1" autocomplete="off" checked>
                  <label class="btn btn-outline-primary" for="update_volunteer" name="update_volunteer">Volunteer</label>
                @else
                  <input type="checkbox" class="btn-check" id="update_volunteer" name="update_volunteer" value="1" autocomplete="off">
                  <label class="btn btn-outline-primary" for="update_volunteer" name="update_volunteer">Volunteer</label>
                @endif
                
              </div>

            </div>

            <div class="mt-3">
          

              <label for="update_bio">Bio</label>
              <textarea class="form-control" placeholder="Bio" id="update_bio" name="update_bio" style="height: 200px">{{ $bio }}</textarea>
              
            </div>

          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary update" value="Update">
      </div>

      </form>

    </div>
  </div>
</div>



</x-app-layout>
