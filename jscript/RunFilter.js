var OldFilter;
var DEFAULT_MAX = 15;
var maxNumber = DEFAULT_MAX;

function resetLoad()
{
	maxNumber = DEFAULT_MAX;
	$("#LoadMoreButton").show();
	if(maxNumber > AllAvailableData.length)
	{
		$("#LoadMoreButton").hide();
	}
}
function RunFilter()
{
	return RunFilter({});
}

function RunFilter(cusfil)
{
	var FilterToApply = {};
	
	for(var x = 0; x < 20; x++)
	{
		var objx = $("#filter" + x);
		if(objx.length)
		{
			FilterToApply[x] = objx.val();
			if(objx.val() === "")
				FilterToApply[x] = ".*";
		}
		else
		{
		}
	}
	FilterToApply[12] = $("#allTab").hasClass('active') ? ".*" : $("#incompleteTab").hasClass('active') ? "0" : "[^0]";
	
	FilterToApply = $.extend(FilterToApply, cusfil);
	FilterToApply['push'] = 1;
	
	return applyFilter(FilterToApply, maxNumber);
}

$(document).ready(function(){

	for(var x = 0; x < 20; x++)
	{
		var objx = $("#filter" + x);
		if(objx.length)
		{
			objx.keyup(RunFilter);
			objx.change(RunFilter);
		}
	}
	
	$(".floatInput").keyup(function(){
	
		var ths = $(this);
	
		var filtertgt = ths.attr("filter-target");
		
		$("#filter" + filtertgt).val(ths.val());
		RunFilter();
	});
	$(".floatInput").change(function(){
	
		var ths = $(this);
	
		var filtertgt = ths.attr("filter-target");
		
		$("#filter" + filtertgt).val(ths.val());
		RunFilter();
	});
	
	$("#LoadMoreButton").click(function(){
		maxNumber += DEFAULT_MAX;
		if(maxNumber > AllAvailableData.length)
		{
			$("#LoadMoreButton").hide();
		}
		RunFilter();
	});
});