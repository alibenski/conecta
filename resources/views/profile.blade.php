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
       	

          <h2 class="orange">{{ $last_name }}, {{ $first_name }}</h2>
          <h5 class="light-grey">
          	
          	@if ($organization_name == "" or $station_name == "")
          		{{ $organization_name}}{{ $station_name }} 
          	@else
          		{{ $organization_name}}  |  {{ $station_name }}
          	@endif
          	
          </h5>

          <h5 class="light-grey" id="status">
            @if ($mentor == 1) Mentor,@endif
            @if ($host == 1) Host,@endif
            @if ($mentee == 1) Mentee,@endif
            @if ($shadow == 1) Shadow,@endif
            @if ($volunteer == 1) Volunteer,@endif
          </h5>
          
          <script>
            raw = $('#status').html();
            raw = $.trim(raw);
            $('#status').html(raw.slice(0,-1));
          </script>
          
          <h5 class="mt-3">
          	<a href="#">
          		{{ $email_address }}
          	</a>
          </h5>

          <div class="mt-3">
            @if ($availability == 1)
              <span class="alert alert-success" role="alert" style="padding:8px;">Available<?php if($availability_text != null) { echo ' | '.$availability_text; } ?></span> 
            @else
              <span class="alert alert-danger" role="alert" style="padding:8px;">Unavailable<?php if($availability_text != null) { echo ' | '.$availability_text; } ?></span>  
            @endif
          </div>


          <button type="button" class="btn btn-primary btn-lg mt-5" data-bs-toggle="modal" data-bs-target="#connect">Connect</button>





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
              <h6 class="light-grey"><?php if($lang['native'] == 1){ echo "Native Language"; } ?></h6>
            </div>
            <div class="col-sm-2">
              <h6 class="grey">Write</h6>
              <h6 class="orange">{{ $lang['writing'] }}</h6>
            </div>
            <div class="col-sm-2">
              <h6 class="grey">Read</h6>
              <h6 class="orange">{{ $lang['reading'] }}</h6>
            </div>
            <div class="col-sm-2">
              <h6 class="grey">Speak</h6>
              <h6 class="orange">{{ $lang['speaking'] }}</h6>
            </div>
            <div class="col-sm-2">
              <h6 class="grey">Understand</h6>
              <h6 class="orange">{{ $lang['understanding'] }}</h6>
            </div>
          </div>


          <hr>

          @endforeach

         

        </div>
      </div>




      <h6 class="light-grey mt-4" id="projects-header">Projects</h6>
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



<div class="modal fade" id="connect" tabindex="-1" aria-labelledby="connect" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Connect with {{$first_name}}({{ $email_address }})</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label for="messagecontent" class="form-label">Message</label>
        <textarea class="form-control" id="messagecontent" rows="3">Hi {{ $first_name }}! I would like to connect with you</textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary send-email" onclick="sendEmail('{{ $email_address }}');">Send</button>
      </div>
    </div>
  </div>
</div>


<script>

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
