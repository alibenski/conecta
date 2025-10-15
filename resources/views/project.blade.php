<x-app-layout>


<div id="main" class="container pb-4">
  <div class="container">
  <div class="row">
    <div class="col-sm-8">

      <h6 class="light-grey">&nbsp;</h6>
      <div class="card mt-3 pt-0">
        <div class="card-body">

          <div class="row">
            <div class="col-sm-10">
              <h2 class="orange">{{ $title }}</h2>
              <p class="sub light-grey">{{ $location_name }}  |  <?php if($stage == 1) {echo "Not Yet Started";}  ?>
                <?php if($stage == 2) {echo "Early Phase";} ?>
                <?php if($stage == 3) {echo "50% Through";} ?>
                <?php if($stage == 4) {echo "Finalization";} ?>
                <?php if($stage == 5) {echo "Done";} ?>  |  {{ $people_needed }} People Needed</p>
            </div>
            <div class="col-sm-2">
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <p class="grey">{{ $project_description }}</p>
              <h5 class="mt-5 orange">Early Phase</h5>
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


    </div>

      
    <div class="col-sm-4">

      <h6 class="light-grey">Project Team</h6>
      <div class="card mt-3 pt-0">
        <div class="card-body">

          @foreach($members as $member)
          

          <div class="row card-item">
            <div class="col-sm-2">
              <div class="profile-image">
                VS
              </div>
            </div>
            <div class="col-sm-10">
              <a class="orange" href="<?php echo config('app.url'); ?>/profile/{{ $member['user_id'] }}">
                <h5>{{ $member['first_name'] }} {{ $member['last_name'] }}</h5>
              </a>
              <p class="sub light-grey">{{ $member['role_description'] }}</p>
              @if ($user_member == false && $member['owner'] == 1)
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
  </div>
</div>

</div><!-- /.container -->

</x-app-layout>
