$(document).ready(function(){
	REFRESH_ALL_DATA();
	//console.log("DEBUG:: Data first call");		//		//		//		//		//
});

function REFRESH_ALL_DATA()
{
	$(".sortimg").attr("src", "images/sort-none.png");
	$.ajax({
		url:"externalPHP/PullAllData.php",
		method:"POST",
		dataType:"JSON",
		success:function(data)
		{
			AllAvailableData = data;
			console.log("DEBUG:: Data Refresh");
			var paid = 0;
			for(var x = 0; x < AllAvailableData.length; x++)
			{
				if(AllAvailableData[x][12] != 0)
					paid++;
			}
			
			$("#PaidObligationNumber").html(paid);
			$("#UnpaidObligationNumber").html(AllAvailableData.length - paid);
			
			RunFilter();
		},
	});
}