<div class="modal fade" id="editModal">
	<div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h4 class="modal-title">Edit Obligation</h4>
		  </div>
		  <div class="modal-body">
			
			<form class="form-horizontal" id="editObligationModal">
				<fieldset>
					
					<div class="form-group">
						<label for="editFirstName" class="col-lg-2 control-label">Student Name</label>
						<div class="col-lg-10">
							<div id="firstName" class="col-lg-14 ">
								<input type="text" class="typeahead form-control" id="editFirstName" placeholder="Student Name"/>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="editGradYear" class="col-lg-2 control-label">Graduating Year</label>
						<div class="col-lg-10">
							<select class="form-control" id="editGradYear"> 
								<option disabled selected>Graduating Year</option>
								<option value="2015">2015</option>
								<option value="2016">2016</option>
								<option value="2017">2017</option>
								<option value="2018">2018</option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label for="editActivity" class="col-lg-2 control-label">Class/Activity</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="editActivity" placeholder="Class/Activity"/>
						</div>
					</div>
					
					<div class="form-group">
						<label for="editType" class="col-lg-2 control-label">Type</label>
						<div class="col-lg-10">
							<div id="type" class="col-lg-14">
								<select class="form-control" id="editType">
									<option disabled selected>Type</option>
									<?php
										
										$Query = "SELECT `Title`, `ID` FROM ObligationTypes";
										
										$Result = $connection->query($Query);
										while(($row = $Result->fetch_row()))
										{
											echo "<option value='".$row[1]."'>".$row[0]."</option>";
										}
	
									?>
								</select>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="editItemNum" class="col-lg-2 control-label">Item #</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="editItemNum" placeholder="Item Number"/>
						</div>
					</div>
					
					<div class="form-group">
						<label for="editCost" class="col-lg-2 control-label" style="margin-right:1.25em">Cost</label>
						<div class="col-lg-9 input-group">
							<span class="input-group-addon">$</span>
							<input type="text" class="form-control" id="editCost" placeholder="Cost"/>
						</div>
					</div>
					
					<div class="form-group">
						<label for="editDescription" class="col-lg-2 control-label">Description</label>
						<div class="col-lg-10">
							<textarea class="form-control" rows="5" id="editDescription" style="resize:none" placeholder="Description"></textarea>
						</div>
					</div>

				</fieldset>
			</form>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="button" class="btn btn-primary" id="submitEdit"><div class='glyphicon glyphicon-pencil' style='margin-right:.5em'></div>Edit Obligation</button>
			<div id="appendAlert" style="text-align:center; margin-top:10px"></div>
		  </div>
		</div>
	</div>
</div>
	
<script>
	$("#submitEdit").click(function(event){
	
		function applyErrorTo(x)
		{
			$("#" + x).parent().addClass("has-error");
		}
		var FAIL = false;
		var data = {id:UIDs[Name.indexOf($("#editFirstName").val())], 
					gradYear:$("#editGradYear").val(),
					activity:$("#editActivity").val(), 
					type:$("#editType").val(), 
					itemNum:$("#editItemNum").val(), 
					cost:$("#editCost").val(), 
					description:$("#editDescription").val(),
					email:$("#editStudentEmail").val(),
					uid:EditTarget};
					

		if(!data.id)
		{
			FAIL = "Invalid Student Name";
			applyErrorTo("editFirstName");
		}
		if(!data.gradYear)
		{
			FAIL = "Invalid Grad Year";
			applyErrorTo("editGradYear");
		}
		if(!data.type)
		{
			FAIL = "Invalid Type";
			applyErrorTo("editType");
		}
		

		event.preventDefault();
		if(!FAIL)
		{
			console.log("go");
			$('#editModal').modal('hide');
			$(".form-group").removeClass("has-error");
			$.ajax({
				url:"settingsPHP/fixObligation.php",
				method:"POST",
				data:data,
				success:function(data){
					
					REFRESH_ALL_DATA();
					
					$("#appendSuccess").append('<div class="alert alert-dismissable alert-success" id="successObligation" style="display:none"><button type="button" class="close" data-dismiss="alert">x</button>Obligation Edited!</div>');
					$("#successObligation").slideDown(300);
					$("#successObligation").delay(5000).slideUp(300);
				},
			});
		}
		else
		{
			console.log("fail");
			$("#appendAlert").append('<div class="alert alert-dismissable alert-danger" id="failObligation" style="display:none"><button type="button" class="close" data-dismiss="alert">x</button>Failed: ' + FAIL + '</div>');
			$("#failObligation").slideDown(300);
			$("#failObligation").delay(5000).slideUp(300);
		}
		
	});
	
	$('#editFirstName').typeahead({
		hint: true,
		highlight: true,
		minLength: 1
	},
	{
		name: 'editFirstName',
		displayKey: 'value',
		source: substringMatcher(Name)
	});
</script>