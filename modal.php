<div class="modal fade" id="modal">
	<div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h4 class="modal-title">Create Obligation</h4>
		  </div>
		  <div class="modal-body">
			
			<form class="form-horizontal" id="obligationModal">
				<fieldset>
				
					
					<div class="form-group">
						<label for="inputFirstName" class="col-lg-2 control-label">Student Name</label>
						<div class="col-lg-10">
							<div id="firstName" class="col-lg-14">
								<input type="text" class="typeahead form-control" id="inputFirstName" placeholder="Student Name"/>
							</div>
						</div>
					</div>
					
					<?php if($_SESSION['PermissionLevel'] == 1)
					echo '
					<div class="form-group">
						<label for="inputStudentEmail" class="col-lg-2 control-label">Student Email</label>
						<div class="col-lg-10">
							<input type="email" class="form-control" id="inputStudentEmail" placeholder="Student Email (Optional)"/>
						</div>
					</div>';?>
					
					<div class="form-group">
						<label for="inputGradYear" class="col-lg-2 control-label">Graduating Year</label>
						<div class="col-lg-10">
							<select class="form-control" id="inputGradYear"> 
								<option disabled selected>Graduating Year</option>
								<option value="2015">2015</option>
								<option value="2016">2016</option>
								<option value="2017">2017</option>
								<option value="2018">2018</option>
							</select>
						</div>
					</div>
					<?php if($_SESSION['PermissionLevel'] == 2)
					echo '
					<div class="form-group">
						<label for="inputTeacher" class="col-lg-2 control-label">Teacher</label>
						<div class="col-lg-10" id="teacher">
							<input type="text" class="typeahead form-control" id="inputTeacher" placeholder="Teacher"/>
						</div>
					</div>';?>
					
					<div class="form-group">
						<label for="inputActivity" class="col-lg-2 control-label">Class/Activity</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputActivity" placeholder="Class/Activity"/>
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputType" class="col-lg-2 control-label">Type</label>
						<div class="col-lg-10">
							<div id="type" class="col-lg-14">
								<select class="form-control" id="inputType">
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
						<label for="inputItemNum" class="col-lg-2 control-label">Item #</label>
						<div class="col-lg-10">
							<input type="text" class="form-control" id="inputItemNum" placeholder="Item Number"/>
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputCost" class="col-lg-2 control-label" style="margin-right:1.25em">Cost</label>
						<div class="col-lg-9 input-group">
							<span class="input-group-addon">$</span>
							<input type="text" class="form-control" id="inputCost" placeholder="Cost"/>
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputDescription" class="col-lg-2 control-label">Description</label>
						<div class="col-lg-10">
							<textarea class="form-control" rows="5" id="inputDescription" style="resize:none" placeholder="Description"></textarea>
						</div>
					</div>

				</fieldset>
			</form>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal" id='cancelCreateObligations'>Cancel</button>
			<button type="button" class="btn btn-primary" id="submitObligation"><div class='glyphicon glyphicon-floppy-disk' style='margin-right:.5em'></div>Create Obligation</button>
			<div id="appendAlert" style="text-align:center; margin-top:10px"></div>
		  </div>
		</div>
	</div>
</div>
	
<script>

	
	function applyErrorTo(x)
	{
		$("#" + x).parent().addClass("has-error");
	}
	
	$("#submitObligation").click(function(event){
	
		$("#obligationModal *").removeClass("has-error");
		var FAIL = false;
		var data = {id:UIDs[Name.indexOf($("#inputFirstName").val())], 
					gradYear:$("#inputGradYear").val(), 
					teacher:<?php if($_SESSION['PermissionLevel'] == 1) echo "'".$_SESSION['name']."'"; else echo '$("#inputTeacher").val()';?>, 
					teacheremail:<?php if($_SESSION['PermissionLevel'] == 1) echo "'".$_SESSION['email']."'"; else echo 'inverseTeachers[$("#inputTeacher").val()]';?>,
					activity:$("#inputActivity").val(), 
					type:$("#inputType").val(), 
					itemNum:$("#inputItemNum").val(), 
					cost:$("#inputCost").val(), 
					description:$("#inputDescription").val(),
					email:$("#inputStudentEmail").val()};

		if(!data.id)
		{
			FAIL = "Highlighted Field invalid!";
			applyErrorTo("inputFirstName");
		}
		if(!data.gradYear)
		{
			FAIL = "Highlighted Field invalid!";
			applyErrorTo("inputGradYear");
		}
		if(!data.type)
		{
			FAIL = "Highlighted Field invalid!";
			applyErrorTo("inputType");
		}
		if(!data.activity)
		{
			FAIL = "Highlighted Field invalid!";
			applyErrorTo("inputActivity");
		}
		if(!data.teacheremail)
		{
			FAIL = "Highlighted Field invalid!";
			applyErrorTo("inputTeacher");
		}
		if(data.cost && (isNaN(data.cost) || parseInt(data.cost) < 0))
		{
			FAIL = "Highlighted Field invalid!";
			applyErrorTo("inputCost");
		}
		if(!data.cost)
		{
			data.cost = "0";
		}

		event.preventDefault();
		if(!FAIL)
		{
			$('#modal').modal('hide');
			$(".form-group").removeClass("has-error");
			$.ajax({
				url:"settingsPHP/submitObligation.php",
				method:"POST",
				data:data,
				success:function(data){
					
					REFRESH_ALL_DATA();
					
					$("#appendSuccess").append('<div class="alert alert-dismissable alert-success" id="successObligation" style="display:none"><button type="button" class="close" data-dismiss="alert">x</button>Obligation Created!</div>');
					$("#successObligation").slideDown(300);
					$("#successObligation").delay(5000).slideUp(300);
					

				},
			});
			$('form').find('input[type=text], input[type=password], input[type=number], input[type=email], textarea').val('');	
			$('form').find('#inputType').val('.*');
			$('form').find('#inputGradYear').val('.*');
			}
		else
		{
			$("#appendAlert").append('<div class="alert alert-dismissable alert-danger" id="failObligation" style="display:none"><button type="button" class="close" data-dismiss="alert">x</button>Failed: ' + FAIL + '</div>');
			$("#failObligation").slideDown(300);
			$("#failObligation").delay(5000).slideUp(300);
		}
		
		document.getElementById("#obligationModal").reset();
	});

	//typeahead script
	var substringMatcher = function(strs) {
	  return function findMatches(q, cb) {
		var matches, substrRegex;
	 
		matches = [];
	 
		substrRegex = new RegExp(q, 'i');
	 
		
		$.each(strs, function(i, str) {
		  if (substrRegex.test(str)) {
			
			matches.push({ value: str });
		  }
		});
	 
		cb(matches);
	  };
	};
	 
	 //typeahead presets
	var teachers = <?php
	
	$Query = "SELECT `Email`, `FirstName`, `LastName` FROM Teachers";
	$result = $connection->query($Query);
	$row = $result->fetch_row();
	$arr = array();
	$arr2 = array();
	while($row)
	{
		$arr[$row[0]] = $row[2] . ", " . $row[1];
		$arr2[$row[2] . ", " . $row[1]] = $row[0];
		$row = $result->fetch_row();
	}
	echo json_encode($arr);
	?>;
	var inverseTeachers = <?php echo json_encode($arr2); ?>;
	
	$('#teacher .typeahead').typeahead({
		hint: true,
		highlight: true,
		minLength: 1
	},
	{
		name: 'teachers',
		displayKey: 'value',
		source: substringMatcher(teachers)
	});
	
	var Total = <?php
	
		$Query = "SELECT `FirstName`, `LastName`, `IDNumber` FROM Student_Definitions";
		
		$Result = $connection->query($Query);
		$arr = array();
		$row = $Result->fetch_row();
		while($row)
		{
			array_push($arr, $row[1].", ".$row[0]);
			array_push($arr, $row[2]);
			$row = $Result->fetch_row();
		}
		echo json_encode($arr);
	
	?>
	
	var Name = new Array();
	var UIDs = new Array();
	
	$(document).ready(function(){
		for(var xe = 0; xe < Total.length; xe += 2)
		{
			Name.push(Total[xe]);
			UIDs.push(Total[xe+1]);
		}
		
		$('#inputFirstName').typeahead({
			hint: true,
			highlight: true,
			minLength: 1
		},
		{
			name: 'inputFirstName',
			displayKey: 'value',
			source: substringMatcher(Name)
		});
	});
</script>