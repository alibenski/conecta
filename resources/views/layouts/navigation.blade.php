<nav class="navbar fixed-top navbar-expand-md">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo config('app.url'); ?>"><img src="{{ asset('img/logo.png') }}"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false"   aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <div class="input-group"  style="width:400px;">
                <input class="form-control" type="search" placeholder="Search for Skills" aria-label="Search" id="search">
                <span class="input-group-text orange" onclick="searchbutton();" style="background-color:#F5F1EB; border:0px; cursor: pointer;"><i class="bi bi-search"></i></span>
            </div>
            <ul id="searchResult"></ul>


            <script>
                
                

            var availableTags = [];

            $.getJSON("<?php echo config('app.url'); ?>/api/childskill", function(data){
                for (var i = 0, len = data.length; i < len; i++) {
                    childskill = data[i];
                    availableTags.push(childskill.skillname)
                }
            });

            $( "#search" ).autocomplete({
              source: availableTags
            });


            $("#search-form").submit(function(){
              console.log('test');
            });
       

            function search() {
               window.location.href = "<?php echo config('app.url'); ?>/search?term="+encodeURIComponent($('#search').val());
            }


             $(document).on("keypress", "#search", function(e){
                if(e.which == 13){
                    var inputVal = encodeURIComponent($(this).val());
                    window.location.href = "<?php echo config('app.url'); ?>/search?term="+inputVal;
                }
            });

             function searchbutton() {
                var inputVal = encodeURIComponent($('#search').val());
                window.location.href = "<?php echo config('app.url'); ?>/search?term="+inputVal;
             }

            </script>

           

            <ul class="navbar-nav ms-auto flex-nowrap">
                <li class="nav-item">
                    <a href="<?php echo config('app.url'); ?>/people" class="nav-link m-2 menu-item nav-active"><i class="bi bi-people me-3"></i>People</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo config('app.url'); ?>/projects" class="nav-link m-2 menu-item"><i class="bi bi-briefcase me-3"></i>Projects</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo config('app.url'); ?>/createproject" class="nav-link m-2 menu-item">Create Project</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link m-2 dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false" id="profile">{{ Auth::user()->name }}</a>
                    <ul class="dropdown-menu" aria-labelledby="profile" style="padding-left:16px;">
                        <li><a href="<?php echo config('app.url'); ?>/myprofile/">My Profile</a></li>
                        <li><a href="https://forms.office.com/Pages/ResponsePage.aspx?id=2zWeD09UYE-9zF6kFubccIsigobdGfpMhsZbIx8zkdpUQ09ISUNXVlJXTFZGU0FLSUU3Mk5UUVUzWC4u" target="_blank">Feedback</a></li>
                        <li><a href="<?php echo config('app.url'); ?>/logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
          
        </div>
    </div>
</nav>

