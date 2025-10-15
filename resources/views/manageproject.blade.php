<x-app-layout>


<div id="main" class="container pb-4">
  <div class="container">
  <div class="row">


      
    <div class="col-sm-4">

    
     <h6 class="light-grey">&nbsp;</h6>
      <div class="card mt-3 pt-0">
        <div class="card-body">

          <div class="row">
            <div class="col-sm-10">
              <h2 class="orange">{{ $title }}</h2>
              <p class="sub light-grey">{{ $location_name }}</p>
              <button type="button" class="btn btn-primary btn-lg mt-3" data-bs-toggle="modal" data-bs-target="#updateproject">Update Details</button>
            </div>
            <div class="col-sm-2">
            </div>
          </div>

          <div class="row mt-5">
            <div class="col-sm-12">
              <p class="grey">{{ $project_description }}</p>
              <h5 class="mt-5 orange">
                <?php if($stage == 1) {echo "Not Yet Started";}  ?>
                <?php if($stage == 2) {echo "Early Phase";} ?>
                <?php if($stage == 3) {echo "50% Through";} ?>
                <?php if($stage == 4) {echo "Finalization";} ?>
                <?php if($stage == 5) {echo "Done";} ?>
              </h5>
              <p class="grey">{{ $tasks_done }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="card mt-3 pt-0">
        <div class="card-body">       
          <h5 class="orange">What tasks need to be done?</h5>
          <p class="grey">{{ $remaining_tasks }}</p>
        </div>
      </div>



      <h6 class="light-grey mt-5">Project Team</h6>
      <div class="card mt-3 pt-0">
        <div class="card-body">

          @foreach($members as $member)
          

          <div class="row card-item">
            <div class="col-sm-2">
              @if ($member['photo'] == "")
                <div class="profile-image"><?php echo substr($member['first_name'], 0, 1); echo substr($member['last_name'], 0, 1);?></div>
              @else
                <div class="profile-image" style="background:url('<?php echo config('app.url'); ?>/storage/{{ $member['photo'] }}'); background-size:cover;">
                </div>
              @endif
             


            </div>
            <div class="col-sm-10">
              <a class="orange" href="<?php echo config('app.url'); ?>/profile/{{ $member['user_id'] }}">
                <h5>{{ $member['first_name'] }} {{ $member['last_name'] }}</h5>
              </a>
              <p class="sub light-grey">{{ $member['role_description'] }}</p>
              @if ($member['owner'] == 1)
                <a href="<?php echo config('app.url'); ?>/profile/{{ $member['user_id']}}" class="btn btn-primary btn-sm mb-3" >Connect</a>

          


              @endif
            </div>
          </div>

          <hr>

          @endforeach 





          <div class="project-need mt-3 p-4 text-center">
            <h4 class="orange">{{ $people_needed }} people needed</h4>
          </div>


          <h4 class="light-grey mt-5">This project is looking for people with the following skills:</h4>
          <ul class="link-list">
            @foreach($skills as $skill)
              <li><a href="<?php echo config('app.url'); ?>/search?term={{ urlencode($skill['name']) }}">{{ $skill['name'] }}</a></li>
            @endforeach 
            
          </ul>


        </div>
      </div>

    </div>

    
    <div class="col-sm-8">

      @foreach($skills as $skill)

      <h6 class="light-grey">Invite these people with the {{ $skill['name'] }} skill to your project</h6>

      <div class="card mt-3 pt-0 mb-5">
        <div class="card-body"  id="profiles-{{ $skill['id'] }}">
          

       
          

          <div class="row">
            <div class="col-sm-12 text-center">
              <img src="{{ asset('img/preloader.gif') }}" class="preloader">
            </div>
          </div>


        

        </div>
      </div>

       <script>
      newurl = "<?php echo config('app.url'); ?>/api/searchbyid?id={{ $skill['id'] }},";

      $.getJSON(newurl, function(data){

        $("#profiles-{{ $skill['id'] }}").html('');
          let loop = 20;
          if (data.length < 20) {
            loop = data.length;
            console.log(loop);
          } 

          for (var i = 0, len = data.length; i < loop; i++) {
              profile = data[i];

              if (profile.photo == null) {
                 $("#profiles-{{ $skill['id'] }}").append('<div class="row card-item"><div class="col-sm-1"><div class="profile-image">'+profile.firstname.charAt(0)+profile.lastname.charAt(0)+'</div></div><div class="col-sm-8"><a class="orange" href="<?php echo config('app.url'); ?>/profile/'+profile.user_id+'"><h5>'+profile.lastname+', '+profile.firstname+'</h5></a><p class="sub light-grey">'+profile.organization+'  |  '+profile.station+'</p></div><div class="col-sm-3 text-end"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#invite" onclick="invite('+profile.user_id+',\''+profile.firstname+'\',\''+profile.email+'\')">Invite</button></div></div><hr>');  
              } else {
                $("#profiles-{{ $skill['id'] }}").append('<div class="row card-item"><div class="col-sm-1"><div class="profile-image" style="background:url(<?php echo config('app.url'); ?>/storage/'+profile.photo+'); background-size:cover;"></div></div><div class="col-sm-8"><a class="orange" href="<?php echo config('app.url'); ?>/profile/'+profile.user_id+'"><h5>'+profile.lastname+', '+profile.firstname+'</h5></a><p class="sub light-grey">'+profile.organization+'  |  '+profile.station+'</p></div><div class="col-sm-3 text-end"><button type="button" class="btn btn-primary"data-bs-toggle="modal" data-bs-target="#invite" onclick="invite('+profile.user_id+',\''+profile.firstname+'\',\''+profile.email+'\')">Invite</button></div></div><hr>');  
              }


          }

           $("#profiles-{{ $skill['id'] }}").append('<div class="row"><div class="col-sm-12 text-center"><a href="<?php echo config('app.url'); ?>/people?id={{ $skill['id'] }}"><button type="button" class="btn btn-link">Load More</button></a></div></div>');          
      });

      </script>

      @endforeach 



    </div>
    
  </div>


</div>







</div><!-- /.container -->




<div class="modal fade" id="invite" tabindex="-1" aria-labelledby="invite" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Invite <span class="firstname_modal"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label for="messagecontent" class="form-label">Message</label>
        <textarea class="form-control" id="messagecontent" rows="3"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary send-email">Send</button>
      </div>
    </div>
  </div>
</div>


<script>
  function invite(user_id, firstname, email) {
      $('.firstname_modal').html(firstname);
      $('#messagecontent').html('Hi '+firstname+'! I would like to invite you to be part of the {{ $title }} team');
      $('.send-email').attr('onClick' , 'sendEmail(\''+email+'\')');
      console.log('click');
  }

  function sendEmail(email) {
    let msg = $('#messagecontent').val();
    let user_id = {{ Auth::user()->id }};
    let project_id = {{ $project_id }};
      $.ajax({
        url: '/api/sendemail',
        type: 'POST',
        data: {email:email, msg:msg, user_id:user_id, project_id:project_id},
      })
      .done(function(data) {
        alert(data.message);
        $('#invite').modal('hide');
        $('.modal-preloader').remove();
      })
      .fail(function() {
        console.log("error");
      });
  }

  $('.send-email').on('click', function () {
      $('.modal-footer').append('<div><img src="{{ asset('img/preloader.gif') }}" class="modal-preloader"></div>');
  })
</script>


<div class="modal fade" id="updateproject" tabindex="-1" aria-labelledby="updateproject" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <form action="update" method="post" id="updateform">
      @csrf
      <input type="text" value="{{$project_id}}" name="project_id" id="project_id" hidden>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update project details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-8">
            <div class="form-floating">
              <input type="text" class="form-control" id="update_projectitle" name="update_projectitle" placeholder="Enter Project Title" value="{{ $title }}">
              <label for="projectitle">Project Title</label>
            </div>
            <div class="mt-3">
              <label for="update_station" class="form-label">Duty Station</label>
              <select name="update_station" id="update_station" class="form-select" value="{{ $location_id  }}">
                @foreach($locations_array as $location)
                  @if ($location_id == $location['id'])
                    <option value="{{ $location['id']}}" selected>{{$location['locationname']}}</option>
                  @else
                    <option value="{{ $location['id']}}">{{$location['locationname']}}</option>
                  @endif
                @endforeach
              </select>




            </div>
            <div class=" mt-3">
                        <label for="currentstage">Select Stage</label>

              <select class="form-select" id="update_currentstage" aria-label="stage" name="update_currentstage">
                <option selected>Select Stage</option>
                <option value="1" <?php if($stage == 1) {echo "selected";}  ?>>Not Yet Started</option>
                <option value="2" <?php if($stage == 2) {echo "selected";} ?>>Early Phase</option>
                <option value="3" <?php if($stage == 3) {echo "selected";} ?>>50% Through</option>
                <option value="4" <?php if($stage == 4) {echo "selected";} ?>>Finalization</option>
                <option value="5" <?php if($stage == 5) {echo "selected";} ?>>Done</option>
              </select>
            </div>
            <div class="mt-3">
              <label for="projectdescription">Project Description</label>
              <textarea class="form-control" placeholder="Enter Project Description" id="update_projectdescription" name="update_projectdescription" style="height: 200px">{{ $project_description }}</textarea>
              
            </div>
            <div class="mt-3">
              

              <label for="tasksneeded">Tasks needed to be done</label>
              <textarea class="form-control" placeholder="What Tasks need to be done" id="update_tasksneeded" name="update_tasksneeded" style="height: 200px">{{ $remaining_tasks }}</textarea>
              
            </div>
            <div class="mt-3">
              
              <label for="tasksdone">Tasks done</label>
              <textarea class="form-control" placeholder="What Tasks need to be done" id="update_tasksdone" name="update_tasksdone" style="height: 200px">{{ $tasks_done }}</textarea>
              
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-floating">
              <input type="number" step=1 class="form-control required" id="update_numberofpeople" name="update_numberofpeople" min="1" placeholder="Enter Project Title" value="{{ $people_needed }}">
              <label for="update_numberofpeople">Number of People for this Project</label>
            </div>

            <hr class="mt-3">

            <label for="skillsearch" class="form-label">Skills Needed for this project</label>
            <input type="text" class="form-control" id="skillsearch" placeholder="Search for a Skill">
            <div class="submit d-grid gap-2 mt-1"><a class="btn btn-secondary btn-sm" id="addskill"  onclick="addskill();" >Add Skill</a></div>
            <ul id="skillsinput" class="link-list mt-3">
              @foreach($skills as $skill)

                <li id="skill-{{ $skill['id'] }}"><div class="row"><div class="col-sm-10"><a href="#">{{ $skill['name'] }}</a></div><div class="col-sm-2"><a href="#"><i class="bi bi-x-circle-fill remove-skill"  onclick="remove('{{ $skill['id'] }}','{{ $skill['name'] }}');"></i></a></div></div></li>
              @endforeach 

            </ul>

            <script>
                      
                      

                  $( "#skillsearch" ).autocomplete({
                    source: availableTags
                  });

                  $(document).on("keypress", "input", function(e){
                      if(e.which == 13){
                        event.preventDefault();
                      }
                  });

                  $(document).on("keypress", "textarea", function(e){
                      if(e.which == 13){
                        event.preventDefault();
                      }
                  });

                  


                  $(document).on("keypress", "#skillsearch", function(e){
                      if(e.which == 13){
                          
                          event.preventDefault();
                      }
                  });


                  function addskill() {
                    inputVal = $('#skillsearch').val();

                        $.getJSON("<?php echo config('app.url'); ?>/api/getskillid?term="+inputVal+"", function(data){  

                      skillid = 0;
                      skillid = data.skill_id;

                      existingskill = $('#skill-'+skillid).length;

                      if (skillid == null) {
                        alert( "Select an existing skill" );
                      } else {

                        if (existingskill == 1) {
                          alert( "You've already added this skill" );
                        } else {


                              $('#skillsinput').append('<li id="skill-'+skillid+'"><div class="row"><div class="col-sm-10"><a href="#">'+inputVal+'</a></div><div class="col-sm-2"><a href="#"><i class="bi bi-x-circle-fill remove-skill"  onclick="remove(\''+skillid+'\',\''+inputVal+'\');"></i></a></div></div></li>');

                              $('#skillsearch').val("");

                              currentset = $('#update_skillsarray').val();
                              skillarray = inputVal+';'+currentset;
                              $('#update_skillsarray').val(skillarray);
                          }
                        }
                    });
                  }



                  function remove(id, name){
              $('#skill-'+id).remove();

              inputVal = $('#update_skillsarray').val();
              inputVal = inputVal.replace(name+';', '');
              $('#update_skillsarray').val(inputVal);

            }




                  </script>

                  <hr class="mt-3">

            <label for="update_members" class="form-label">Who is part of the project already?</label>
            <input type="text" class="form-control" id="update_members" placeholder="Search for a Name">

            <ul id="membersinput" class="link-list mt-3">
              @foreach($members as $member)
                @if ($member['owner'] == 0)
                  <li id="member-{{ $member['user_id'] }}"><div class="row"><div class="col-sm-10"><a href="#">{{ $member['first_name'] }} {{ $member['last_name'] }}</a></div><div class="col-sm-2"><a href="#"><i class="bi bi-x-circle-fill remove-skill" onclick="removemem('{{ $member['user_id'] }}','{{ $member['first_name'] }} {{ $member['last_name'] }}');"></i></a></div></div></li>
                @endif


              @endforeach 

            </ul>


            <script>
            $(document).on("keypress", "#update_members", function(e){

              var availableNames = [];

              term = $('#update_members').val();

                    $.getJSON("<?php echo config('app.url'); ?>/api/searchname?term="+term, function(data){
                        for (var i = 0, len = data.length; i < len; i++) {
                            profile = data[i];
                            availableNames.push(profile.name);
                            console.log(profile.name);
                        }

                        $( "#update_members" ).autocomplete({
                        source: availableNames
                      });
                    });

                  

               
                      if(e.which == 13){
                          var inputVal = $(this).val();


                          $.getJSON("<?php echo config('app.url'); ?>/api/validatename?term="+term, function(data){

                            if(data.length == 0) {
                              alert( "Member is not registered" );
                            } else {


                              existingmember = $('#member-'+data[0].id).length;


                              if (existingmember == 1) {
                                alert( "You've already added this user as member" );
                              } else {


                                $('#membersinput').append('<li id="member-'+data[0].id+'"><div class="row"><div class="col-sm-10"><a href="#">'+inputVal+'</a></div><div class="col-sm-2"><a href="#"><i class="bi bi-x-circle-fill remove-skill" onclick="removemem(\''+data[0].id+'\',\''+inputVal+'\');"></i></a></div></div></li>');

                                

                                currentsetm = $('#update_membersarray').val();
                                membersarray = inputVal+';'+currentsetm;
                                $('#update_membersarray').val(membersarray);

                               
                            }

                             $(this).val("");
                          }


                        });
                      }

                       
                });

            function removemem(id, name){
              $('#member-'+id).remove();

              inputVal = $('#update_membersarray').val();
              inputVal = inputVal.replace(name+';', '');
              $('#update_membersarray').val(inputVal);

            }



            </script>



            <script>

              var availableLocations = [];

              availableLocations.push('Remote');

                    $.getJSON("<?php echo config('app.url'); ?>/api/locations", function(data){
                        for (var i = 0, len = data.length; i < len; i++) {
/*                                location = data[i];
*/                                availableLocations.push(data[i].locationname);
                        }
                    });


              $( "#location" ).autocomplete({
                      source: availableLocations
                    });
            </script>


            <input type="text" class="required" id="update_skillsarray" name="update_skillsarray" value="{{ $skills_raw_name }}" hidden>
            <input type="text" id="update_membersarray" name="update_membersarray"  value="{{ $members_raw_name }}" hidden>



          </div>



        </div>


      </div>
      <div class="modal-footer">

        


        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="#" id="editsubmit" class="btn btn-primary update">Update</a>
      </div>



      </form>

       <script>

        $('#editsubmit').click(function() {
          if( $("#update_skillsarray").val() == "") {
            alert("Add Skills to submit");
            
          } else {
            $('#updateform').submit();
          }
        });


      </script>


    </div>
  </div>
</div>




</x-app-layout>
