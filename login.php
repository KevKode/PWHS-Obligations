<?php session_start();
require "settingsPHP/header.php" ?>

<div class="col-lg-4 col-lg-offset-4 " style="margin-top:5%">
<div class="well well-lg">
<form class="form-horizontal">

  <fieldset>
    <legend>Log In</legend>
    <div class="form-group">
		<span class="help-block" style="margin-left:6px">  If you are a student, log in with your school ID. If you are a teacher, please use your school email.</span>
      <label for="inputEmail" class="col-lg-2 control-label">Email/ID</label>
      <div class="col-lg-9">
        <input type="text" class="form-control " id="UsernameInput" placeholder="Email/ID">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPassword" class="col-lg-2 control-label">Password</label>
      <div class="col-lg-9">
        <input type="password" class="form-control" id="PasswordInput" placeholder="Password">
        
      </div>
    </div>
    
    
    
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
       
        <input id="SubmitButton" type="submit" class="btn btn-primary" value="Log In"></input>
      </div>
    </div>
  </fieldset>
</form>
</div>
</div>

<!--INVALID USER MESSAGE -->
<div class='row'>
	<div class='col-lg-8 col-lg-offset-2'>
		<div style='display:none' id='fadeMeIn' class='alert alert-dismissable alert-danger'>
			<button type='button' class='close' data-dismiss='alert'>x</button>
			<h4 style='font-weight: bold'>Invalid User</h4>
			<p><span style='font-weight: bold'>Oops!</span> Looks like that username and password combination didn't match up with any of our users. Make sure you entered everything in correctly.</p>
		</div>
	</div>
</div>


<script type="text/javascript">

$(document).ready(function(){

	$("#SubmitButton").click(function(event){
	
		
		event.preventDefault();
		$.ajax({
			method:"POST",
			url:"externalPHP/LoginVerification.php",
			data:{Username:CleanInput($("#UsernameInput").val()) , Password:CleanInput($("#PasswordInput").val())},
			dataType:"JSON",
			success:function(data)
			{
				if(data['result'] == "Success")
				{
					console.log("Success!!");
					window.location.href = "index.php";
				}
				else{
					console.log("FAIL: " + data['reason']);
					$('#fadeMeIn').fadeIn();
				}	
			}
		});
		
	});

	function CleanInput(input)
	{
		input = input.replace(/\\/, "\\");
		input = input.replace(/"/, "\"");
		input = input.replace(/'/, "\'");
		return input;
	}
	
});

</script>

<?php require "settingsPHP/footer.php" ?>