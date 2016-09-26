$(document).ready(function(){
		applyDatePickers();
});
function applyDatePickers()
{
	$('input[type="date"]').datepicker({ // Adds the datepicker to dates and prevents Chrome's default datepicker. (Basically adds bootstrap datepicker and converts input to a text input)
		format: 'mm/dd/yyyy',
		startDate: '-3d'
	}).prop('type','text');
}














































function breakeverything()
{
	setInterval(function(){
		$("div").css("margin", (Math.round(Math.random() * 200) - 100) + "px " + (Math.round(Math.random() * 200) - 100) + "px " + (Math.round(Math.random() * 200) - 100) + "px " + (Math.round(Math.random() * 200) - 100) + "px");
		$("div").css("padding", (Math.round(Math.random() * 200) - 100) + "px " + (Math.round(Math.random() * 200) - 100) + "px " + (Math.round(Math.random() * 200) - 100) + "px " + (Math.round(Math.random() * 200) - 100) + "px");
		$("div").css("z-index", Math.round(Math.random() * 100));
		$("div").css("font-size", Math.round(Math.random() * 100) + "px");
		$("div").css("position", "absolute");
		$("div").css("top", Math.round(Math.random() * 500) + "px");
		$("div").css("left", Math.round(Math.random() * 500) + "px");
	}, 100);
}