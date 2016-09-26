<div class="modal fade" id="ppmodal">
	<div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h4 class="modal-title">Partial Payment</h4>
		  </div>
		  <div class="modal-body">
			
			<form class="form-horizontal" id="PPform">
				<fieldset>
					<div class="form-group">
						<label for="inputType" class="col-lg-2 control-label">Paid Amount</label>
						<div class="col-lg-10">
							<div id="type" class="col-lg-14">
								<input id="InputPaidPartial" type="text" class="form-control" />
							</div>
						</div>
					</div>
				</fieldset>
			</form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			<button type="button" class="btn btn-success" id="completePayButton" data-dismiss="modal">Pay</button>
			<div id="appendPPSuccess"></div>
		  </div>
		</div>
	</div>
</div>

<script>
var PartialPayTarget = -1;

$(document).ready(function(){
	$("#PPform").submit(formSubmit);
	
	$("#completePayButton").click(formSubmit);

	function getRowTarget(ppt)
	{
		for(var x = 0; x < AllAvailableData.length; x++)
		{
			if(AllAvailableData[x][0] == ppt)
				return AllAvailableData[x];
		}
	}
	
	function formSubmit(event)
	{
		event.preventDefault();
		
		var RGX = /^\d*\.?\d{0,2}$/gi;
		var inp = $("#InputPaidPartial").val();
		console.log("PartPayTarget:" + PartialPayTarget);
		if(RGX.test(inp))
		{
			
			var amt = parseFloat(inp);
			var RowTarget = getRowTarget(PartialPayTarget);
			
			
			var old = parseFloat(RowTarget[19]);
			
			console.log(RowTarget);
			console.log((old + amt) + ">" + RowTarget[4]);
			if(old + amt < parseFloat(RowTarget[4]))
			{
				RowTarget[19] = old + amt;
				$("ppmodal").hide();
				$.ajax({
					url:"externalPHP/PartialPay.php",
					method:"POST",
					data:{id:PartialPayTarget, amt:old += amt},
					success:function(data)
					{
						$("#ppmodal").hide();
						REFRESH_ALL_DATA();
					},
				});
			}
			else
			{
				console.log("Over Amt");
			}
		}
		else
		{
			console.log("RGX fail");
		}
	}
});
</script>