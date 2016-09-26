<script type="text/javascript">

var AllAvailableData = Array();
function showAll()
	{
		$("#tableBod").html("");
		for(var x = 0; x < AllAvailableData.length; x++)
		{
			appendRow(x);
		}
	}
	
function appendRow(x)
	{
		appendSpecificRow(AllAvailableData[x]);
	}
	
function appendSpecificRow(row)
	{
		$("#tableBod").append("<tr class='myRow" + (row[12] === '3' ? " active" : "") + (row[12] === '0' ? " danger" : "") + "' expanded='0'>"+
						<?php
							$level = $_SESSION['PermissionLevel'];
							
							if( $level == 0 ){
								echo "'	<td>'+row[6]+'</td>'+";
							}
							
							if( $level != 0 ){
								echo "'	<td>'+row[16] + ', ' + row[15] + '</td>'+";
							}
							
							if( $level != 1 ){
								echo "'	<td>' + row[18] + ', ' + row[17] + '</td>'+";
							}
							
							if( $level !=0 ){
								echo "'	<td>'+row[3]+'</td>'+";
							}
						?>	
							"	<td>"+row[5]+"</td>"+
							"	<td>"+row[13]+"</td>"+
							"	<td>$"+parseInt((parseFloat(row[4]) - parseFloat(row[19])) * 100) / 100+"</td>	"+
							" 	<td><img class='tinyimg' src='images/" + (row[12] == '0' ? "Non" : row[12] == '1' ? "Check" : row[12] == '2' ? "Paid" : "Withdrawn") + "Icon.png'></img></td>"+
							"</tr>"+
							"<tr class='myDropdown" + (row[12] === '3' ? " active" : "") + (row[12] === '0' ? " danger" : "") + "' >"+
							"	<td colspan='8'>"+
							"		<ul>"+
										<?php
											if( $_SESSION['PermissionLevel'] != 0 ){
												echo "'			<li>'+row[6]+'</li>'+";
											}
										?>
							"			<li><span class='myLabel'>Date Returned:</span> <i>" + ((row[12] == 0) ? "Not Returned" : row[7]) + "</i></li>"+
							"			<li><span class='myLabel'>Equipment/Book/Uniform #:</span> "+row[10]+"</li>"+
							"			<li><span class='myLabel'>Description:</span> "+row[11]+"</li>"+
							"			<li><span class='myLabel'>Return Method:</span> <i>" + row[14] + "</i></li>"+
							
										(row[12] == 0 ? "<?php if($_SESSION['PermissionLevel'] != 0) echo "<li style='float:right'><button type='button' complete-id='\"+row[0]+\"' class='btn btn-primary editButton' data-toggle='modal' data-target='#editModal' style='margin-right:.5em'><div class='glyphicon glyphicon-pencil' style='margin-right:.25em'></div> Edit </button><button style='margin-right:.5em' data-toggle='modal' data-target='#ppmodal' class='btn btn-danger PartPay' complete-id='\"+row[0]+\"'>Partial Payment</button><button data-toggle='modal' data-target='#completeModal' class='btn btn-success clear' type='button' complete-id='\"+row[0]+\"'><div class='glyphicon glyphicon-ok' style='margin-right:.5em'></div>Complete </button>" ?></li>" : "")+ 
							"		</ul>"+
							"	</td>"+
								
						
							"</tr>"
							
							);
						
		setClickEvents();
	}

var COMPLETE_DATA_TARGET = -1;
	
function pushData(array, max)
{
	$("#tableBod").html("");
	for(var x = 0; x < Math.min(array.length, max); x++)
	{
		appendSpecificRow(array[x]);
	}
}

function applyFilter(filters, max)
{
	var defaultFilter = Array();
	var currentArray = Array();
	
	for(var x = 0; x < 20; x++)
	{
		defaultFilter.push(".*");
	}
	
	defaultFilter['push'] = 0;
	
	var CurrentFilter = $.extend(defaultFilter, filters);
	
	var RegexCheck = Array();
	for(var i = 0; i < 20; i++)
	{
		RegexCheck.push(new RegExp(CurrentFilter[i], "i"));
	}
	
	for(var x = 0; x < AllAvailableData.length; x++)
	{
		var match = true;
		for(var i = 0; i < 20; i++)
		{
			var check = RegexCheck[i];
			if(!check.test(AllAvailableData[x][i]))
			{
				match = false;
			}
		}
		
		if(match)
		{
			currentArray.push(AllAvailableData[x]);
		}
	}
	
	if(CurrentFilter['push'] == 1)
	{
		pushData(currentArray, max);
	}
	
	return currentArray;
}

/*
0: ID
1: StudentID
2: TeacherEmail
3: GradYear
4: Cost
5: Activity
6: CreateDate
7: ReturnDate
8: TypeId
9: Other Specification
10: ItemNumber
11: Description
12: ReturnTypeId
13: ObligationTypeTitle
14: ObligationReturnTypeTitle
15-19: ??? ??? ???
19: Partial Pay Amount
*/
</script>