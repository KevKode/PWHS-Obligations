$(document).ready(function()
{
	//var gradDefault = $('#gradDefaultOption').val();
	//var typeDefault = $('#typeDefaultOption').val();
	
	var lastClicked = -1;
	var sortUp = true;
	
	function doLastClicked(lc, element)
	{
		$(".sortimg").attr("src", "images/sort-none.png");
		if(lc == lastClicked)
		{
			sortUp = !sortUp;
		}
		else
		{
			sortUp = true;
			lastClicked = lc;
		}
		
		if(element.is("img"))
		{
			element.attr("src", "images/sort-" + (sortUp ? "up" : "down") + ".png");
		}
	}

	function getSortFunction(index, string)
	{
		if(string)
		{
			if(sortUp)
			{
				return function(a,b){ return a[index].localeCompare(b[index]); };
			}
			else
			{
				return function(a,b){ return b[index].localeCompare(a[index]); };
			}
		}
		else
		{
			if(sortUp)
			{
				return function(a,b){ return a[index] - b[index]; };
			}
			else
			{
				return function(a,b){ return b[index] - a[index]; };
			}
		}
	}
	
	$('#stoodHead').click(function(){
		doLastClicked(0, $(this));
		AllAvailableData.sort(getSortFunction(16,true));
		RunFilter();
	});
	
	$('#floatStoodHead').click(function(){
		doLastClicked(0, $(this));
		AllAvailableData.sort(getSortFunction(16,true));
		RunFilter();
	});
	
	$('#teachHead').click(function(){
		doLastClicked(1, $(this));
		AllAvailableData.sort(getSortFunction(2,true));	
		RunFilter();
	});
	
	$('#floatTeachHead').click(function(){
		doLastClicked(1, $(this));
		AllAvailableData.sort(getSortFunction(2,true));	
		RunFilter();
	});
	
	$('#dateHead').click(function(){
		doLastClicked(2, $(this));
		AllAvailableData.sort(getSortFunction(6,false));
		RunFilter();
	});
	
	$('#floatDateHead').click(function(){
		doLastClicked(2, $(this));
		AllAvailableData.sort(getSortFunction(6,false));
		RunFilter();
	});
	
	$('#gradHead').click(function(){
		doLastClicked(3, $(this));
		AllAvailableData.sort(getSortFunction(3,false));
		RunFilter();
	});
	
	$('#floatGradHead').click(function(){
		doLastClicked(3, $(this));
		AllAvailableData.sort(getSortFunction(3,false));
		RunFilter();
	});
	
	$('#actHead').click(function(){
		doLastClicked(4, $(this));
		AllAvailableData.sort(getSortFunction(5,true));
		RunFilter();
	});
	$('#floatActHead').click(function(){
		doLastClicked(4, $(this));
		AllAvailableData.sort(getSortFunction(5,true));
		RunFilter();
	});
	
	$('#typeHead').click(function(){
		doLastClicked(5, $(this));
		AllAvailableData.sort(getSortFunction(13,true));
		RunFilter();
	});
	$('#floatTypeHead').click(function(){
		doLastClicked(5, $(this));
		AllAvailableData.sort(getSortFunction(13,true));
		RunFilter();
	});
	
	$('#costHead').click(function(){
		doLastClicked(6, $(this));
		AllAvailableData.sort(getSortFunction(4,false));
		RunFilter();
	});
	$('#floatCostHead').click(function(){
		doLastClicked(6, $(this));
		AllAvailableData.sort(getSortFunction(4,false));
		RunFilter();
	});
	$('#oSort').click(function(){
		REFRESH_ALL_DATA();
		$('.filterInput').val('');
		$('.filterDrop').val('.*');
		//$('#gradDefaultOption').val('.*');
		//$('#typeDefaultOption :nth-child(0)').prop('selected', true);
	});
});