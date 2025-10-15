<x-app-layout>

<div id="main" class="container pb-4">
	<form action="adddesiredskills" method="post">
	@csrf
	<div class="container">
		<div class="row">
			<div class="col-sm-8 offset-sm-2">
					<h2 class="orange">Update Desired Skills</h2>
					<div class="card mt-3 pt-0">
						<div class="card-body" id="mentors">
						<div class="row">
							<div class="col-sm-9">
								<input type="text" class="form-control" id="skillsearch" placeholder="Search for a Skill">
							</div>
							<div class="col-sm-3">
								<div class="submit d-grid gap-2"><a class="btn btn-secondary" id="addskill"  onclick="addskill();" >Add Skill</a></div>
							</div>
							<div class="col-sm-12">

								<ul id="skillsinput" class="link-list mt-3">
									@foreach($desired_skills as $desired_skills)
										<li id="skill-{{ $desired_skills['id'] }}"><div class="row"><div class="col-sm-10"><a href="#" class="skillname">{{ $desired_skills['name'] }}</a></div><div class="col-sm-2"><a href="#"><i class="bi bi-x-circle-fill remove" onclick="remove('<?php echo $desired_skills['id']; ?>','<?php echo addslashes($desired_skills['name']); ?>');"></i></a></div></div></li>
									@endforeach
								</ul>







								<div class="d-grid gap-2 mt-4">
									<input type="submit" id="submitbutton" class="btn btn-primary btn-lg" value="Update Profile with Desired Skills">
								</div>

								<script>
					                
					                

					            $( "#skillsearch" ).autocomplete({
					              source: availableTags
					            });


					            inputValc = $('#skillsarray').val();
					            if (inputValc == "") {
									$('#submitbutton').attr('disabled', true);
								} else {
									$('#submitbutton').attr('disabled', false);
								}



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
					                   /* var inputVal = $(this).val();*/
					                    event.preventDefault();
					                    /*$('#skillsinput').append('<li><div class="row"><div class="col-sm-10"><a href="#">'+inputVal+'</a></div><div class="col-sm-2"><i class="bi bi-x-circle-fill remove-skill" onclick="remove('+inputVal+');"></i></div></div></li>');



					                    $(this).val("");

					                    currentset = $('#skillsarray').val();
					                    skillarray = inputVal+';'+currentset;
					                    $('#skillsarray').val(skillarray);*/
					                    
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

								            	currentset = $('#skillsarray').val();
								                skillarray = inputVal+';'+currentset;
								                $('#skillsarray').val(skillarray);
								                $('#submitbutton').attr('disabled', false);
								                $('#submitbutton').val('Update Profile with Desired Skills');
					            			}

							            	
							            }

						            });



					            }

/*								$(document).on("click", ".remove", function() {
								       $(this).parent().parent().parent().remove(); 
								});*/

								function remove(id, name){
									$('#skill-'+id).remove();

									inputVal = $('#skillsarray').val();
									inputVal = inputVal.replace(name+';', '');
									$('#skillsarray').val(inputVal);

									if (inputVal == "") {
										$('#submitbutton').attr('disabled', true);
										$('#submitbutton').val('Add a desired skill first to update profile');
									} else {
										$('#submitbutton').attr('disabled', false);
										$('#submitbutton').val('Update Profile with Desired Skills');
									}
								}

								</script>
							</div>



						</div>
					</div>
			</div>
		</div>
	</div>

	<input type="text" style="display:none;" id="skillsarray" name="skillsarray" value="<?php echo ($desired_skills_raw_name)  ?>">

	<script>
		$(document).ready(function() { 

			inputVal = $('#skillsarray').val();

			if (inputVal == "") {
				$('#submitbutton').attr('disabled', true);
				$('#submitbutton').val('Add a desired skill first to update profile');
			} else {
				$('#submitbutton').attr('disabled', false);
				$('#submitbutton').val('Update Profile with Desired Skills');
			}


		});

		function validate() {
			inputVal = $('#skillsarray').val();

			if (inputVal == "") {
				alert( "Add a desired skill" );
			} 
		}


	</script>
	</form>
</div>





</x-app-layout>
