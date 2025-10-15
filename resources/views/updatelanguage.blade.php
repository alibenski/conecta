<x-app-layout>

<div id="main" class="container pb-4">
	<form action="updatelanguage" method="post">
	@csrf
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
					
					<div class="row">
						<div class="col-sm-6">
							<h2 class="orange">Update Language</h2>
						</div>
						<div class="col-sm-6 text-justify">
							
						</div>
					</div>
					<div class="card mt-3 pt-0">
						<div class="card-body" id="language">
							@foreach($languages as $language)
								<div class="row mt-3">
									<div class="col-sm-2 d-grid gap-2">
										@if ($language['active'] == 1)
											<input type="checkbox" class="btn-check" id="update-{{ $language['name'] }}" name="update-{{ $language['name'] }}" value="1" autocomplete="off" checked onchange="languagetoggle('<?php echo $language['name']; ?>');" >
											<label class="btn btn-outline-primary" for="update-{{ $language['name'] }}" name="update_mentor">{{ $language['name'] }}</label>

											@if ($language['native'] == 1)
											<input type="checkbox" class="btn-check" id="native-{{ $language['name'] }}" name="native-{{ $language['name'] }}" checked value="1" autocomplete="off">
											@else
											<input type="checkbox" class="btn-check" id="native-{{ $language['name'] }}" name="native-{{ $language['name'] }}" value="1" autocomplete="off">
											@endif
											<label class="btn btn-outline-primary" id="native-button-{{ $language['name'] }}" for="native-{{ $language['name'] }}" name="update_mentor" style="display:block;">Native</label>
										@else 
											<input type="checkbox" class="btn-check" id="update-{{ $language['name'] }}" name="update-{{ $language['name'] }}" value="1" autocomplete="off" onchange="languagetoggle('<?php echo $language['name']; ?>');">
											<label class="btn btn-outline-primary" for="update-{{ $language['name'] }}" name="update_mentor">{{ $language['name'] }}</label>
											<input type="checkbox" class="btn-check" id="native-{{ $language['name'] }}" name="native-{{ $language['name'] }}" value="1" autocomplete="off">
											<label class="btn btn-outline-primary" id="native-button-{{ $language['name'] }}" for="native-{{ $language['name'] }}" name="update_mentor" style="display:none;">Native</label>
										@endif
		                  				
		                  			</div>
		                  			@if ($language['active'] == 1)
		                  			<div class="col-sm-10" id="proficiency-set-{{ $language['name'] }}" style="display: inline-block;">
		                  			@else 
		                  			<div class="col-sm-10" id="proficiency-set-{{ $language['name'] }}" style="display: none;">
		                  			@endif
		                  				<div class="row">
		                  					<div class="col-sm-3">
		                  						<div class="mt-3">
									              <label for="update-{{ $language['name'] }}-writing" class="form-label">Writing</label>
									              <select name="update-{{ $language['name'] }}-writing" id="update-{{ $language['name'] }}-writing" class="form-select">
									                  <option value="0">Select Proficiency</option>
									                  <option value="1">Basic (UN Level I)</option>
									                  <option value="2">Intermediate (UN Level II)</option>
									                  <option value="3">Advanced (UN Level III)</option>
									                  <option value="4">Expert (UN Level IV).</option>
									              </select>
									            </div>
									       	</div>
									       	<div class="col-sm-3">
									            <div class="mt-3">
									              <label for="update-{{ $language['name'] }}-reading" class="form-label">Reading</label>
									              <select name="update-{{ $language['name'] }}-reading" id="update-{{ $language['name'] }}-reading" class="form-select">
									                  <option value="0">Select Proficiency</option>
									                  <option value="1">Basic (UN Level I)</option>
									                  <option value="2">Intermediate (UN Level II)</option>
									                  <option value="3">Advanced (UN Level III)</option>
									                  <option value="4">Expert (UN Level IV).</option>
									              </select>
									            </div>
									        </div>
									       	<div class="col-sm-3">
									            <div class="mt-3">
									              <label for="update-{{ $language['name'] }}-speaking" class="form-label">Speaking</label>
									              <select name="update-{{ $language['name'] }}-speaking" id="update-{{ $language['name'] }}-speaking" class="form-select">
									                  <option value="0">Select Proficiency</option>
									                  <option value="1">Basic (UN Level I)</option>
									                  <option value="2">Intermediate (UN Level II)</option>
									                  <option value="3">Advanced (UN Level III)</option>
									                  <option value="4">Expert (UN Level IV).</option>
									              </select>
									            </div>
									        </div>
									       	<div class="col-sm-3">
									            <div class="mt-3">
									              <label for="update-{{ $language['name'] }}-understanding" class="form-label">Listening</label>
									              <select name="update-{{ $language['name'] }}-understanding" id="update-{{ $language['name'] }}-understanding" class="form-select">
									                  <option value="0">Select Proficiency</option>
									                  <option value="1">Basic (UN Level I)</option>
									                  <option value="2">Intermediate (UN Level II)</option>
									                  <option value="3">Advanced (UN Level III)</option>
									                  <option value="4">Expert (UN Level IV).</option>
									              </select>
									            </div>
		                  					</div>

		                  					<script>

		                  						$('#update-<?php echo $language['name']; ?>-writing').val('<?php echo $language['writing']; ?>');
		                  						$('#update-<?php echo $language['name']; ?>-reading').val('<?php echo $language['reading']; ?>');
		                  						$('#update-<?php echo $language['name']; ?>-speaking').val('<?php echo $language['speaking']; ?>');
		                  						$('#update-<?php echo $language['name']; ?>-understanding').val('<?php echo $language['understanding']; ?>');

		                  					</script>				


		                  				</div>
		                  				
		                  			</div>
		                  			<hr class="mt-3">
		                  		</div>

							@endforeach
							<h4>
							<input type="submit" class="btn btn-primary btn-lg" value="Update Profile with Skills">
						</div>
					</div>
			</div>
		</div>
	</div>

	</form>
</div>

<script>
	function languagetoggle(lang) {

		status = $("#update-"+lang).prop("checked");
		
		if(status == "false") {
			$("#proficiency-set-"+lang).css('display','none');
			$("#native-button-"+lang).css('display','none');
			console.log("false");
		} else {
			$("#proficiency-set-"+lang).css('display','inline-block');
			$("#native-button-"+lang).css('display','block');
			console.log("true");
		}
	}
</script>





</x-app-layout>
