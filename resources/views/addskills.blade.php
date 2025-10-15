<x-app-layout>

<div id="main" class="container pb-4">
	<form action="addskills" method="post">
	@csrf
	<div class="container">
		<div class="row">
			<div class="col-sm-8 offset-sm-2">
					<h2 class="orange">Update Skills</h2>
					<div class="card mt-3 pt-0">
						<div class="card-body" id="mentors">
						<div class="row">
							<div class="col-sm-5">
								<input type="text" class="form-control" id="skillsearch" placeholder="Search for a Skill">
							</div>
							<div class="col-sm-4">
								<select name="skilllevel" id="skilllevel" class="form-select">
									<option value="0" selected disabled>Select Level</option>
									<option value="Beginner">Beginner</option>
									<option value="Intermediate">Intermediate</option>
									<option value="Advanced">Advanced</option>
									<option value="Expert">Expert</option>
								</select>
							</div>
							<div class="col-sm-3">
								<div class="submit d-grid gap-2"><a class="btn btn-secondary " id="addskill"  onclick="addskill();" >Add Skill</a></div>
							</div>
							<div class="col-sm-12">

								<ul id="skillsinput" class="link-list mt-3">
									@foreach($skills as $skills)
										<li id="skill-{{ $skills['id'] }}">
											<div class="row mt-2">
												<div class="col-sm-9">
													<a href="#" class="skillname">{{ $skills['name'] }}</a>
												</div>
												<div class="col-sm-2">
													<select name="skilllevel" id="skilllevel-{{ $skills['id'] }}" onchange="changelevel('<?php echo $skills['id']; ?>','<?php echo addslashes($skills['name']); ?>')" class="form-select">
														<option value="0" selected disabled>Select Level</option>
														<option value="Beginner">Beginner</option>
														<option value="Intermediate">Intermediate</option>
														<option value="Advanced">Advanced</option>
														<option value="Expert">Expert</option>
													</select>

													<script>$('#skilllevel-<?php echo $skills['id']; ?>').val('<?php echo $skills['level']; ?>');</script>												
												</div>
												<div class="col-sm-1">
													<a href="#"><i class="bi bi-x-circle-fill remove" onclick="remove('<?php echo $skills['id']; ?>','<?php echo addslashes($skills['name']); ?>');"></i></a>
												</div>
											</div>
										</li>
									@endforeach
								</ul>







								<div class="d-grid gap-2 mt-4">
									<input type="submit" id="submitbutton" class="btn btn-primary btn-lg" value="Update Profile with Skills">
								</div>

								<script>

								inputValc = $('#skillsarray').val();
								if (inputValc == "") {
									$('#submitbutton').attr('disabled', true);
								} else {
									$('#submitbutton').attr('disabled', false);
								}
					                
					                

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
/*					                    var inputVal = $(this).val();
*/					                    event.preventDefault();
					                    /*$('#skillsinput').append('<li><div class="row"><div class="col-sm-10"><a href="#">'+inputVal+'</a></div><div class="col-sm-2"><i class="bi bi-x-circle-fill remove-skill" onclick="remove('+inputVal+');"></i></div></div></li>');



					                    $(this).val("");

					                    currentset = $('#skillsarray').val();
					                    skillarray = inputVal+';'+currentset;
					                    $('#skillsarray').val(skillarray);*/
					                    
					                }
					            });

					            function addskill() {
					            	inputVal = $('#skillsearch').val();
					            	skilllevel = $('#skilllevel').val();

					            	$.getJSON("<?php echo config('app.url'); ?>/api/getskillid?term="+inputVal+"", function(data){	

					            		skillid = 0;
					            		skillid = data.skill_id;

					            		if (skillid == null) {
					            			alert( "Select an existing skill" );
					            		} else {
					            			$('#skillsinput').append('<li  id="skill-'+skillid+'"><div class="row mt-2"><div class="col-sm-9"><a href="#" class="skillname">'+inputVal+'</a></div><div class="col-sm-2"><select id="skilllevel-'+skillid+'" onchange="changelevel(\''+skillid+'\',\''+inputVal+'\')" class="form-select" val="'+skilllevel+'"><option value="0" selected disabled>Select Level</option><option value="Beginner">Beginner</option><option value="Intermediate">Intermediate</option><option value="Advanced">Advanced</option><option value="Expert">Expert</option></select></div><div class="col-sm-1"><a href="#"><i class="bi bi-x-circle-fill remove" onclick="remove(\''+skillid+'\',\''+inputVal+'\');"></i></a></div></div></li>');

							            	$('#skilllevel-'+skillid).val(skilllevel);

							            	$('#skillsearch').val("");

						            		currentset = $('#skillsarray').val();
						                    skillarray = inputVal+'%'+skilllevel+';'+currentset;
						                    $('#skillsarray').val(skillarray);

						                    $('#submitbutton').attr('disabled', false);
					            		}

					    


									});



					            	


					            }

/*								$(document).on("click", ".remove", function() {
								       $(this).parent().parent().parent().remove(); 
								});*/


								function remove(id, name){
									$('#skill-'+id).remove();

									inputVal = $('#skillsarray').val();
									inputVal = inputVal.replace(name+'%Beginner;', '');
									inputVal = inputVal.replace(name+'%Intermediate;', '');
									inputVal = inputVal.replace(name+'%Advanced;', '');
									inputVal = inputVal.replace(name+'%Expert;', '');
									inputVal = inputVal.replace(name+'%Undefined;', '');
									$('#skillsarray').val(inputVal);


									if (inputVal == "") {
										$('#submitbutton').attr('disabled', true);
									} else {
										$('#submitbutton').attr('disabled', false);
									}


								}

								function changelevel(id, name){
									newlevel = $('#skilllevel-'+id).val();
									inputVal = $('#skillsarray').val();
									inputVal = inputVal.replace(name+'%Beginner;', name+'%'+newlevel+';');
									inputVal = inputVal.replace(name+'%Intermediate;', name+'%'+newlevel+';');
									inputVal = inputVal.replace(name+'%Advanced;', name+'%'+newlevel+';');
									inputVal = inputVal.replace(name+'%Expert;', name+'%'+newlevel+';');
									inputVal = inputVal.replace(name+'%Undefined;', name+'%'+newlevel+';');
									$('#skillsarray').val(inputVal);
								}

								</script>
							</div>



						</div>
					</div>
			</div>
		</div>
	</div>

	<input type="text" id="skillsarray" style="display:none;" name="skillsarray" value="<?php echo ($skills_raw_name)?>">
	</form>
</div>





</x-app-layout>
