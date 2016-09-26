$(document).ready(function(){

	$("#genFullReport").click(function(){generateReport(true);});
	$("#genCurrentReport").click(function(){generateReport(false);});
	$("#hiddenformpush").append("<form id='actualhiddenform' method='POST' action='fpdf/generate.php'>" +
								"<input id='PUTVALUEHERE' value='nn' name='data'></input>" + 
								"<input id='PUTVALUE2HERE' name='headers'></input>" + 
								"</form>");
								
								
	$("#actualhiddenform").submit(function(e){
	
		if($("#PUTVALUEHERE").attr('value') === 'nn')
			e.preventDefault();
	
	});
});

function generateReport(isFull)
{
	var Data_Refiner = [16, 3, 18, 6, 13, 5, 4, 14];
	var Header_Data = ["Student Name", "GradYear", "Teacher Name", "Date", "Type", "Class/Activity", "Cost", "Return Type"];

	var data = new Array();
	var data_refined = new Array();
	if(isFull)
	{
		data = AllAvailableData;
	}
	else
	{
		data = RunFilter();
	}
	
	for(var x = 0; x < data.length; x++)
	{
		var temp = new Array();
		
		for(var y = 0; y < Data_Refiner.length; y++)
		{
			if(Data_Refiner[y] == 18)
			{
				temp.push(data[x][17].substr(0,1) + ". " + data[x][18]);
			}
			else if(Data_Refiner[y] == 16)
			{
				temp.push(data[x][16] + "@, " + data[x][15]);
			}
			else if(Data_Refiner[y] == 4)
			{
				temp.push("$" + (data[x][4] != "" ? data[x][4] : 0));
			}
			else
			{
				temp.push(data[x][Data_Refiner[y]]);
			}
		}
		
		data_refined.push(temp);
	}
	data_refined = "" + data_refined;
	data_refined = data_refined.replace(/([^@]),/g, "$1,,");
	data_refined = data_refined.replace(/@,/g, ",");
	$("#PUTVALUEHERE").attr('value', data_refined);
	$("#PUTVALUE2HERE").attr('value', Header_Data);
	$("#actualhiddenform").trigger("submit");

}