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
    <div class="col-sm-8">

      <h6 class="light-grey">People with {{ $term ?? '' }} as a Skill</h6>
      <div class="card mt-3 pt-0">
        <div class="card-body" id="profiles">
          

          <div class="row">
            <div class="col-sm-12 text-center">
              <img src="{{ asset('img/preloader.gif') }}" class="preloader">
            </div>
          </div>


        </div>
      </div>

    <script>
     newurl = "<?php echo config('app.url'); ?>/api/searchbyid?id={{ $id }},&limit=4";

      $.getJSON(newurl, function(data){

        $('#profiles').html('');


          if (data.length == 0) {
            $('#profiles').html('<h2 class="grey">We can\'t find any profiles that matches your search.</h3><p class="orange">Please try searching another term</p>');
          } else {
            $('#preloader').remove();
            $('#loadmore').remove();

            for (var i = 0, len = data.length; i < 3; i++) {
                profile = data[i];

                if (profile.photo == null) {
                   $("#profiles").append('<div class="row card-item"><div class="col-sm-1"><div class="profile-image">'+profile.firstname.charAt(0)+profile.lastname.charAt(0)+'</div></div><div class="col-sm-8"><a class="orange" href="<?php echo config('app.url'); ?>/profile/'+profile.user_id+'"><h5>'+profile.lastname+', '+profile.firstname+'</h5></a><p class="sub light-grey">'+ profile.organization+' |  '+ profile.station +'</p><p class="grey">'+ profile.status_string +' for '+ profile.skills +'</p></div><div class="col-sm-3 text-end"><button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#connect"  onclick="connect('+profile.user_id+',\''+profile.firstname+'\',\''+profile.email+'\')">Connect</button></div></div><hr>');  
                } else {
                  $("#profiles").append('<div class="row card-item"><div class="col-sm-1"><div class="profile-image" style="background:url(<?php echo config('app.url'); ?>/storage/'+profile.photo+'); background-size:cover;"></div></div><div class="col-sm-8"><a class="orange" href="<?php echo config('app.url'); ?>/profile/'+profile.user_id+'"><h5>'+profile.lastname+', '+profile.firstname+'</h5></a><p class="sub light-grey">'+profile.organization+'  |  '+profile.station+'</p><p class="grey">'+ profile.status_string +' for '+ profile.skills +'</p></div><div class="col-sm-3 text-end"><button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#connect"  onclick="connect('+profile.user_id+',\''+profile.firstname+'\',\''+profile.email+'\')">Connect</button></div></div><hr>');  
                }




            }

          if (data.length==4) {
             $("#profiles").append('<div class="row" id="loadmore"><div class="col-sm-12 text-center"><a href="<?php echo config('app.url'); ?>/people?id='+{{$id}}+'"><button type="button" class="btn btn-link">See More Profiles</button></a></div></div>');  
          }



             
          }
                 
        });

    </script>

      <h6 class="light-grey mt-5">Projects Looking for People with {{ $term ?? '' }} as a Skill</h6>
      <div class="card mt-3 pt-0">
        <div class="card-body" id="projects">
          





        </div>


        <script>
          newurl = "<?php echo config('app.url'); ?>/api/searchprojectsbyid?id={{ $id }},&limit=4";

          $.getJSON(newurl, function(data){

            $('#projects').html('');
              let loop = 3;
              if (data.length < 3) {
                loop = data.length;
              } 


              if (data.length == 0) {
            $('#projects').html('<h2 class="grey">We can\'t find any project that matches your search.</h3><p class="orange">Please try searching another term</p>');
          } else {

              for (var i = 0, len = data.length; i < 3; i++) {
                  project = data[i];

                  $("#projects").append('<div class="row card-item"><div class="col-sm-12"><a class="orange" href="<?php echo config('app.url'); ?>/project/'+project.id+'"><h5>'+project.title+'</h5></a><p class="sub light-grey">'+project.station+'  |  '+project.stage+'</p><p class="grey">Looking for People with skills in '+project.skills+'</p></div></div><hr>');  
              


              }

               $("#projects").append('<div class="row"><div class="col-sm-12 text-center"><a href="<?php echo config('app.url'); ?>/projects?id='+{{$id}}+'"><button type="button" class="btn btn-link">See More Projects</button></a></div></div>');   

              }       
          });


        </script>
      </div>


    </div>
    <div class="col-sm-4">
      <!-- <h6 class="light-grey">&nbsp;</h6>
      

      <div class="card mt-3">
        <div class="card-body">
          <h4 class="light-grey">People with {{ $term ?? '' }} as a skill also have the following skills</h4>
            <ul class="link-list">
              <li><a href="#">Strategic communications</a></li>
              <li><a href="#">Digital communication</a></li>
              <li><a href="#">Communication Skills</a></li>
              <li><a href="#">Communication and collaboration</a></li>
              <li><a href="#">Research</a></li>
            </ul>
          


        </div>
      </div> -->

    </div>
  </div>
  </div>

</div><!-- /.container -->

<div class="modal fade" id="connect" tabindex="-1" aria-labelledby="connect" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Connect with <span class="firstname_modal"></span></h5>
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
  function connect(user_id, firstname, email) {
      $('.firstname_modal').html(firstname);
      $('#messagecontent').html('Hi '+firstname+'! I would like to connect with you');
      $('.send-email').attr('onClick' , 'sendEmail(\''+email+'\')');
      console.log('click');
  }

  function sendEmail(email) {
    let msg = $('#messagecontent').val();
    let user_id = {{ Auth::user()->id }};
      $.ajax({
        url: '/api/sendemail',
        type: 'POST',
        data: {email:email, msg:msg, user_id:user_id},
      })
      .done(function(data) {
        alert(data.message);
        $('#connect').modal('hide');
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


</x-app-layout>
