<x-app-layout>

<nav class="navbar fixed-top navbar-expand-md" id="search-nav" style="top:60px; z-index: 998;">
  <div class="container-fluid">

      <ul class="navbar-nav me-auto flex-nowrap">
        <li class="nav-item">
          <a class="nav-link m-2 menu-item nav-active"><button type="button" class="btn btn-primary btn-sm">People</button></a>
        </li>
        <li class="nav-item dropdown">
          <select name="update_station" id="update_station" class="form-select dropdown-toggle" style="border:0px; margin-top:10px; color:#CF8D34; font-weight: 600;">
            <option value="0" selected>Show All Locations</option>
            @foreach($locations_array as $location)
            <option value="{{ $location['id']}}">{{$location['locationname']}}</option>
            @endforeach
          </select>
        </li>


        <li class="nav-item dropdown">
          <a class="nav-link m-2 dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="off" id="status">Filter Language</a>
          <ul class="dropdown-menu" aria-labelledby="status" style="padding-left:16px;">
            <li>
              <input type="radio" class="language_c" id="showall_l" name="language_c" value="0"  selected>
              <label for="mentor">Show All</label><br>
            </li>

            @foreach($languages_array as $language)
            <li>
              <input type="radio" class="language_c" id="lang_{{$language['id']}}" name="language_c" value="{{$language['id']}}" autocomplete="off">
              <label for="mentor">{{$language['languagename']}}</label><br>
            </li>
            @endforeach


          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link m-2 dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="off" id="status">Filter Availabilty</a>
          <ul class="dropdown-menu" aria-labelledby="status" style="padding-left:16px;">
            <li>
              <input type="radio" class="available_c" id="showall_a" name="available_c" value="2"  selected>
              <label for="mentor">Show All</label><br>
            </li>
            <li>
              <input type="radio" class="available_c" id="available" name="available_c" value="1" autocomplete="off">
              <label for="mentor">Available Only</label><br>
            </li>
            <li>
              <input type="radio" class="available_c" id="unavailable" name="available_c" value="0" autocomplete="off">
              <label for="host">Unavailable Only</label><br>
            </li>
          </ul>
        </li>





        <li class="nav-item dropdown">
          <a class="nav-link m-2 dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="off" id="status">Filter Role</a>
          <ul class="dropdown-menu" aria-labelledby="status" style="padding-left:16px;">
            <li>
              <input type="radio" class="status_c" id="showall" name="status_c" value="0"  selected>
              <label for="mentor">Show All</label><br>
            </li>
            <li>
              <input type="radio" class="status_c" id="mentor" name="status_c" value="mentor" autocomplete="off">
              <label for="mentor">Mentor</label><br>
            </li>
            <li>
              <input type="radio" class="status_c" id="host" name="status_c" value="host" autocomplete="off">
              <label for="host">Host</label><br>
            </li>
            <li>
              <input type="radio" class="status_c" id="volunteer" name="status_c" value="volunteer" autocomplete="off">
              <label for="volunteer">Volunteer</label><br>
            </li>


          </ul>
        </li>


        <li class="nav-item dropdown">
          <a class="nav-link m-2 dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="off" id="status">Filter Skill Level</a>
          <ul class="dropdown-menu" aria-labelledby="status" style="padding-left:16px;">
            <li>
              <input type="radio" class="level_c" id="showall" name="level_c" value="0"  selected>
              <label for="mentor">Show All</label><br>
            </li>
            <li>
              <input type="radio" class="level_c" id="mentor" name="level_c" value="beginner" autocomplete="off">
              <label for="mentor">Beginner</label><br>
            </li>
            <li>
              <input type="radio" class="level_c" id="mentor" name="level_c" value="intermediate" autocomplete="off">
              <label for="mentor">Intermediate</label><br>
            </li>
            <li>
              <input type="radio" class="status_c" id="host" name="level_c" value="advanced" autocomplete="off">
              <label for="host">Advanced</label><br>
            </li>
            <li>
              <input type="radio" class="status_c" id="volunteer" name="level_c" value="expert" autocomplete="off">
              <label for="volunteer">Expert</label><br>
            </li>


          </ul>
        </li>


            <script>
              $('input[name="status_c"]').change(function() {
                val = $('input[name="status_c"]:checked').val();

                if(val != 0){
                  statusquery = "&"+val+"=1";
                } else {
                   statusquery = "";
                }
                $('#profiles').html('');

                pagen=1;
                offset = "&offset=0";
                getdata();

                if(val == 0) {
                  $('#status').html("Filter Role");
                } else {
                  $('#status').html("Showing "+val+"s");
                }

                

              });


              $('input[name="available_c"]').change(function() {
                vala = $('input[name="available_c"]:checked').val();

                if(vala == "2"){
                  availablequery = "";
                } else {
                   if(vala == "0"){
                    availablequery = "&availability=unavailable";
                  } else {
                    availablequery = "&availability=available";
                  }
                }

                $('#profiles').html('');

                pagen=1;
                offset = "&offset=0";
                getdata();

                

              });


              $('select[name="update_station"]').change(function() {
                console.log("test");
                locval = $('select[name="update_station"]').val();
                locationquery = "&station="+locval;
                $('#profiles').html('');
                pagen=1;
                offset = "&offset=0";
                getdata();



              });




            </script>
        


      </ul>
      
    </div>
  </div>
</nav>
<div id="main" class="container pb-4">
  <div class="container mt-4">
  <div class="row">
    <div class="col-sm-8">


      <div class="card mt-3 pt-0">
        <div class="card-body"  id="profiles">
          

       
          

          <div class="row" id="preloader">
            <div class="col-sm-12 text-center">
              <img src="{{ asset('img/preloader.gif') }}" class="preloader">
            </div>
          </div>


        

        </div>
      </div>

       <script>
      
      statusquery = "";
      locationquery = "";
      availablequery = "";
      pagen=1;
      offset = "&offset=0";

      currLoc = $(location).attr('href'); 
      params = currLoc.replace('<?php echo config('app.url'); ?>/people','');

      function loadmore(npage){ 
        $('#loadmore').remove();
        $('#preloader').remove();
        offset = "&offset="+5*npage;
        pagen=pagen+1;
        getdata();
      }


      function getdata(){
        

        if(params.length != 0) {
          newurl = "<?php echo config('app.url'); ?>/api/searchbyid"+params+","+statusquery+locationquery+availablequery+offset;
        } else {
          newurl = "<?php echo config('app.url'); ?>/api/searchbyid?id={{ $desiredskillsraw }}"+statusquery+locationquery+availablequery+offset;
        }



        $.getJSON(newurl, function(data){
          if (data.length == 0) {
            if((statusquery+locationquery+availablequery) != 0) {
              $('#profiles').html('<h4 class="grey">We can\'t find anyone to match for what you are searching for. Search using a different filter or search another skill.</h4>');
            } else {
              $('#profiles').html('<h4 class="grey">We can\'t find anyone to match with your desired skills.</h4><p class="orange"><b><a href="<?php echo config('app.url'); ?>/adddesiredskills">Add More Desired Skills</a></b> to your profile to connect you with more people or try searching for other skills.</p>');
            }
          } else {
            $('#preloader').remove();
            $('#loadmore').remove();

            for (var i = 0, len = data.length; i < 5; i++) {
                profile = data[i];


                if (profile.photo == null) {
                   $("#profiles").append('<div class="row card-item"><div class="col-sm-1"><div class="profile-image">'+profile.firstname.charAt(0)+profile.lastname.charAt(0)+'</div></div><div class="col-sm-8"><a class="orange" href="<?php echo config('app.url'); ?>/profile/'+profile.user_id+'"><h5>'+profile.lastname+', '+profile.firstname+'</h5></a><p class="sub light-grey">'+ profile.organization+' |  '+ profile.station +'</p><p class="grey">'+ profile.status_string +' for '+ profile.skills +'</p></div><div class="col-sm-3 text-end"><button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#connect"  onclick="connect('+profile.user_id+',\''+profile.firstname+'\',\''+profile.email+'\')">Connect</button></div></div><hr>');  
                } else {
                  $("#profiles").append('<div class="row card-item"><div class="col-sm-1"><div class="profile-image" style="background:url(<?php echo config('app.url'); ?>/storage/'+profile.photo+'); background-size:cover;"></div></div><div class="col-sm-8"><a class="orange" href="<?php echo config('app.url'); ?>/profile/'+profile.user_id+'"><h5>'+profile.lastname+', '+profile.firstname+'</h5></a><p class="sub light-grey">'+profile.organization+'  |  '+profile.station+'</p><p class="grey">'+ profile.status_string +' for '+ profile.skills +'</p></div><div class="col-sm-3 text-end"><button type="button" class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#connect"  onclick="connect('+profile.user_id+',\''+profile.firstname+'\',\''+profile.email+'\')">Connect</button></div></div><hr>');  
                }




            }

          if (data.length==6) {
             $("#profiles").append('<div class="row" id="loadmore"><div class="col-sm-12 text-center"><button type="button"  onclick="loadmore('+pagen+');" class="btn btn-link">Load More</button></div></div>');  
          }



             
          }
                 
        });

      }

      getdata();


    </script>



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
      $('.firstname_modal').html(firstname+'('+email+')');
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
