<x-app-layout>

<div id="main" class="container pb-4">
	<form action="createproject" id="create" method="post">
	@csrf
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				<h1 class="orange">Create New Project</h1>
			</div>
			<div class="col-sm-4 text-right justify-content-md-end d-grid gap-2 d-md-flex">
				<input class="btn btn-primary btn-lg" value="Post This Project" onclick="validatesubmission();">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-8">

					<h6 class="light-grey mt-3">Project Details</h6>
					<div class="card mt-3 pt-0">
						<div class="card-body" id="mentors">
						  

						<div class="row">
							<div class="col-sm-12">
								<div class="form-floating">
									<input type="text" class="form-control required" id="projectitle" name="projectitle" placeholder="Enter Project Title">
									<label for="projectitle">Project Title</label>
								</div>
								<div class="form-floating mt-3">
									<select class="form-select required" id="currentstage" aria-label="stage" name="currentstage">
										<option selected disabled>Select Stage</option>
										<option value="1">Not Yet Started</option>
										<option value="2">Early Phase</option>
										<option value="3">50% Through</option>
										<option value="2">Finalization</option>
										<option value="3">Done</option>
									</select>
									<label for="currentstage">Select Stage</label>
								</div>
								<div class="form-floating mt-3">
									<input type="text" class="form-control required" id="location" name="location" placeholder="Enter Project Title">
									<label for="location">Type then Select from Location List</label>
									<div class="location-help-text"></div>
								</div>

								<div class="form-floating mt-3">
									<textarea class="form-control required" placeholder="Enter Project Description" id="projectdescription" name="projectdescription" style="height: 200px"></textarea>
									<label for="projectdescription">Project Description</label>
								</div>
								<div class="form-floating mt-3">
									<textarea class="form-control required" placeholder="What Tasks need to be done" id="tasksneeded" name="tasksneeded" style="height: 200px"></textarea>
									<label for="tasksneeded">Tasks needed to be done</label>
								</div>
								<div class="form-floating mt-3">
									<textarea class="form-control required" placeholder="What Tasks need to be done" id="tasksdone" name="tasksdone" style="height: 200px"></textarea>
									<label for="tasksdone">Tasks done</label>
								</div>
								


								
							</div>
						</div>


						</div>
					</div>
			</div>
			<div class="col-sm-4">
				<form>

					<h6 class="light-grey mt-3">Team Details</h6>
					<div class="card mt-3 pt-0">
						<div class="card-body" id="mentors">
						  

						<div class="row">
							<div class="col-sm-12">
								<div class="form-floating">
									<input type="number" step=1 class="form-control required" id="numberofpeople" name="numberofpeople" min="1" placeholder="Enter Project Title">
									<label for="numberofpeople">Number of People for this Project</label>
								</div>

								<hr class="mt-3">

								<label for="skillsearch" class="form-label">Skills Needed for this project</label>
								<input type="text" class="form-control" id="skillsearch" placeholder="Search for a Skill">
								<div class="submit d-grid gap-2 mt-1"><a class="btn btn-secondary btn-sm" id="addskill"  onclick="addskill();" >Add Skill</a></div>
								<ul id="skillsinput" class="link-list mt-3">
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
									rawInput = $('#skillsearch').val();
					            	inputVal = encodeURIComponent($('#skillsearch').val());

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


							                    $('#skillsinput').append('<li id="skill-'+skillid+'"><div class="row"><div class="col-sm-10"><a href="#">'+rawInput+'</a></div><div class="col-sm-2"><a href="#"><i class="bi bi-x-circle-fill remove-skill"  onclick="remove(\''+skillid+'\',\''+rawInput+'\');"></i></a></div></div></li>');

							                    $('#skillsearch').val("");

							                    currentset = $('#skillsarray').val();
							                    skillarray = rawInput+';'+currentset;
												console.log(currentset, skillarray)
							                    $('#skillsarray').val(skillarray);
							                }
						                }
						            });
					            }



					            function remove(id, name){
									$('#skill-'+id).remove();

									inputVal = $('#skillsarray').val();
									inputVal = inputVal.replace(name+';', '');
									$('#skillsarray').val(inputVal);

								}




					            </script>

					            <hr class="mt-3">

					            <label for="members" class="form-label">Who is part of the project already?</label>
								<input type="text" class="form-control" id="members" placeholder="Search for a Name">

								<ul id="membersinput" class="link-list mt-3">
								</ul>


								<script>
								$(document).on("keypress", "#members", function(e){

									console.log('test');

									var availableNames = [];

									term = $('#members').val();

						            $.getJSON("<?php echo config('app.url'); ?>/api/searchname?term="+term, function(data){
						                for (var i = 0, len = data.length; i < len; i++) {
						                    profile = data[i];
						                    availableNames.push(profile.name)
						                }
						            });

					         		$( "#members" ).autocomplete({
						              source: availableNames
						            });

						         });

								$(document).on("keypress", "#members", function(e){
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

								                    $(this).val("");

								                    currentsetm = $('#membersarray').val();
								                    membersarray = inputVal+';'+currentsetm;
								                    $('#membersarray').val(membersarray);
								                }
					                    	}


						                });
					                }

					                 
					            });

								function removemem(id, name){
									$('#member-'+id).remove();

									inputVal = $('#membersarray').val();
									inputVal = inputVal.replace(name+';', '');
									$('#membersarrayc').val(inputVal);

								}



								</script>



								<script>

									var availableLocations = [];

									availableLocations.push('Remote');

						            $.getJSON("<?php echo config('app.url'); ?>/api/locations", function(data){
						                for (var i = 0, len = data.length; i < len; i++) {
/*						                    location = data[i];
*/						                    availableLocations.push(data[i].locationname);
						                }
						            });


									$( "#location" ).autocomplete({
						              source: availableLocations
						            });
								</script>

							</div>
						</div>


						</div>
					</div>
			</div>
		</div>
	</div>

	<input type="text" style="display:none;" class="required" id="skillsarray" name="skillsarray">
	<input type="text" style="display:none;" id="membersarray" name="membersarray">
	</form>
</div>


<script>

	function validatesubmission() {

		var bSubmit = true;
		let b = 0;
		$.each(availableLocations, function( index, value ) {
			let a = $("input#location").val();
			
			if (a == value) {
				console.log(a)
				b = 1;
				$(".location-help-text").html('');
				$("#location").removeClass('field-error');
				return false;
			}
		});

		if (b == 0) {
			$("#location").addClass('field-error');
			$(".location-help-text").html('<small id="locationBlock" class="form-text text-danger">Please select from list.</small>');
			bSubmit = false;
		}

		$(".required").each(function(){
            if($(this).val() == "") {
            	$(this).addClass('field-error');
               bSubmit = false;
            } 

        });

        if( $('#skillsarray').val() == "" ) {
        	$('#skillsearch').addClass('field-error');
        	bSubmit = false;
        }

        if(bSubmit == true) {
        	$('#create').submit();
        }

        $('.field-error').click(function() {
			$(this).removeClass('field-error');		
		});
		
	}


	


</script>




</x-app-layout>
