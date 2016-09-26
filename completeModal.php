	<div class="modal fade" id="completeModal">
		<div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title">Complete Obligation</h4>
			  </div>
			  <div class="modal-body">
				
				<form class="form-horizontal">
					<fieldset>
						
						<div class="form-group">
							<label for="inputType" class="col-lg-2 control-label">Return Types</label>
							<div class="col-lg-10">
								<div id="type" class="col-lg-14">
									<select id="ReturnType" class="form-control">
										<?php
											
											$Query = "SELECT `Title`, `ID` FROM ObligationReturnTypes";
											$result = QueryGetRows($connection, $Query);
											
											for($x = 0; $x < sizeof($result); $x++)
											{
												if($result[$x][1] != 0)
												{
													if($result[$x][0] == "Paid")
													{
														if($_SESSION['PermissionLevel'] == 2)
														{
															echo "<option value='".$result[$x][1]."'>".$result[$x][0]."</option>";
														}
													}
													else
													{
														echo "<option value='".$result[$x][1]."'>".$result[$x][0]."</option>";
													}
												}
											}
										
										?>
									</select>
								</div>
							</div>
						</div>
						
						
	
					</fieldset>
				</form>
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-success" id="complete" data-dismiss="modal"><div class="glyphicon glyphicon-ok" style="margin-right:.5em"></div>Complete Obligation</button>
				<div id="appendSuccess"></div>
			  </div>
			</div>
		</div>
	</div>
	
	<script>
	
	$(document).ready(function(){
	
		$("#complete").click(function(){
			console.log("clog: " + COMPLETE_DATA_TARGET);
			$.ajax({
				method:"POST",
				url:"externalPHP/complete.php",
				data:{index:COMPLETE_DATA_TARGET, type:$("#ReturnType").val()},
				dataType:"JSON",
				success:function(data){
					console.log("DAT:" + data);
					REFRESH_ALL_DATA();
					
					$("#appendSuccess").append('<div class="alert alert-dismissable alert-success" id="successObligation" style="display:none"><button type="button" class="close" data-dismiss="alert">x</button>Obligation Completed!</div>');
					$("#successObligation").slideDown(300);
					$("#successObligation").delay(5000).slideUp(300);
				}
			});
			
		});
	
	});
	
	</script>