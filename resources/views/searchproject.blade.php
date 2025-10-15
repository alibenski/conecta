
<x-app-layout>


<nav class="navbar fixed-top navbar-expand-md" id="search-nav" style="top:60px; z-index: 998;">
  <div class="container-fluid">

      <ul class="navbar-nav me-auto flex-nowrap">
        <li class="nav-item">
          <a href="#" class="nav-link m-2 menu-item nav-active"><button type="button" class="btn btn-primary btn-sm">Projects</button></a>
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
          <a class="nav-link m-2 dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" id="status">All Phases</a>
          <ul class="dropdown-menu" aria-labelledby="status" style="padding-left:16px; width:300px;">
            <li>
              <input type="radio" class="status_c" id="showall" name="status_c" value="0" selected>
              <label for="showall">Show All</label><br>
            </li>
            <li>
              <input type="radio" id="stage-1" name="status_c" value="1" autocomplete="off">
              <label for="stage-1" id="label1">Not started yet</label><br>
            </li>
            <li>
              <input type="radio" id="stage-2" name="status_c" value="2" autocomplete="off">
              <label for="stage-2" id="label2">Early phase</label><br>
            </li>
            <li>
              <input type="radio" id="stage-3" name="status_c" value="3" autocomplete="off">
              <label for="stage-3" id="label3">50% through</label><br>
            </li>
            <li>
              <input type="radio" id="stage-4" name="status_c" value="4" autocomplete="off">
              <label for="stage-4" id="label4">Finalisation phase</label><br>
            </li>
            <li>
              <input type="radio" id="stage-5" name="status_c" value="5" autocomplete="off">
              <label for="stage-5" id="label5">Done</label><br>
            </li>
          </ul>
        </li>

        <script>

          $('input[name="status_c"]').change(function() {
            val = $('input[name="status_c"]:checked').val();

            if(val != 0){
              statusquery = "&stage="+val;
            } else {
               statusquery = "";
            }
            $('#projects').html('');

            pagen=1;
            offset = "&offset=0";
            getdata();

            if(val == 0) {
              $('#status').html("All Phases");
            } else {
              labelname = $('#label'+val).html();
              $('#status').html("Showing "+labelname);
            }

          });


          $('select[name="update_station"]').change(function() {
            locval = $('select[name="update_station"]').val();
            locationquery = "&station="+locval;

            if(locval == 0) {
              locationquery = "";
            }
            $('#projects').html('');
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
        <div class="card-body" id="projects">
          

          

          <div class="row">
            <div class="col-sm-12 text-center">
              <img src="{{ asset('img/preloader.gif') }}" class="preloader" id="preloader">
            </div>
          </div>



        </div>

        
      </div>

      <h6 class="light-grey mt-5 hideonrandom">Check out these projects you might be interested in</h6>
      <div class="card mt-3 pt-0 hideonrandom">
        <div class="card-body" id="randomprojects">


        </div>
        <script>
          $.getJSON('<?php echo config('app.url'); ?>/api/randomprojects', function(data){

          let loop = 3;
          if (data.length < 3) {
            loop = data.length;
          } 

          for (var i = 0, len = data.length; i < loop; i++) {
                project = data[i];

            $("#randomprojects").append('<div class="row card-item"><div class="col-sm-12"><a class="orange" href="<?php echo config('app.url'); ?>/project/'+project.id+'"><h5>'+project.title+'</h5></a><p class="sub light-grey">'+project.station+'  |  '+project.stage+'</p><p class="grey">Looking for People with skills in '+project.skills+'</p></div></div><hr>');  
          }

          $("#randomprojects").append('<div class="row"><div class="col-sm-12 text-center"><a href="<?php echo config('app.url'); ?>/projects?id=rand"><button type="button" class="btn btn-link">See More Projects</button></a></div></div>');



      });
        </script>
      </div>




    </div>
    <div class="col-sm-4">      

     <!--  <div class="card mt-3">
        <div class="card-body">
          <h4 class="light-grey">People with Communication as a skill also have the following skills</h4>
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

<script>

          statusquery = "";
          locationquery = "";
          pagen=1;
          offset = "&offset=0";

          currLoc = $(location).attr('href'); 
          params = currLoc.replace('<?php echo config('app.url'); ?>/projects','');



          function loadmore(npage){ 
            $('#loadmore').remove();
            $('#preloader').remove();
            offset = "&offset="+5*npage;
            pagen=pagen+1;
            getdata();
          }

          function getdata(){

            if(params.length != 0) {


              if(params == "?id=rand") {
                newurl = "<?php echo config('app.url'); ?>/api/randomprojects?random=yes"+statusquery+locationquery;
                
              } else {
                newurl = "<?php echo config('app.url'); ?>/api/searchprojectsbyid"+params+","+statusquery+locationquery+offset;
                
              }
            } else {
              newurl = "<?php echo config('app.url'); ?>/api/searchprojectsbyid?id={{ $skillforsearch }}"+statusquery+locationquery+offset;
            }

            if(params == "?id=rand") {
              $('.hideonrandom').css('display','none');
            } else {
              $('.hideonrandom').css('display','block');
            }

            $.getJSON(newurl, function(data){

              if (data.length == 0) {
                if((statusquery+locationquery).length != 0) {
                  $('#projects').html('<h4 class="grey">We can\'t find any project that matches what you are searching for. Search using a different filter or search another skill.</h4>');
                } else {
                  $('#projects').html('<h4 class="grey">We can\'t find any project that matches your skill. <b><a href="<?php echo config('app.url'); ?>/addskills">Add More Skills</a></b> to your profile to connect you with more projects.</h4>');
                }
              } else {

                $('#preloader').remove();
                $('#loadmore').remove();


                for (var i = 0, len = data.length; i < 5; i++) {
                  project = data[i];
                  $("#projects").append('<div class="row card-item"><div class="col-sm-12"><a class="orange" href="<?php echo config('app.url'); ?>/project/'+project.id+'"><h5>'+project.title+'</h5></a><p class="sub light-grey">'+project.station+'  |  '+project.stage+'</p><p class="grey">Looking for People with skills in '+project.skills+'</p></div></div><hr>');
                }

                if (data.length==6) {
                  if(params == "?id=rand") {
                    $("#projects").append('<div class="row" id="loadmore"><div class="col-sm-12 text-center"><a href="<?php echo config('app.url'); ?>/projects?id=rand" type="button" class="btn btn-link">Load More</a></div></div>'); 
                  } else {
                    $("#projects").append('<div class="row" id="loadmore"><div class="col-sm-12 text-center"><a href="<?php echo config('app.url'); ?>/projects?id=rand" type="button" class="btn btn-link">Load More</a></div></div>'); 
                  }
                }




              }
            });
          }

          getdata();

        </script>



</x-app-layout>
