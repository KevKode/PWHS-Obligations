<?php session_start(); 
include "settingsPHP/SQLLogin.php";
if(!isset($_SESSION['login']))
	header("Location: login.php");
?>
<?php include "settingsPHP/header.php"; ?>

<style>
	
.myDropdown
{
	display: none;
}

.upButton
{
	border-radius: 20%;
	margin-left: 50px;
	margin-right: 50px;
}

.makeMeStrong
{
	font-weight: bold;
}

ul
{
	list-style-type: none;
}

.myLabel
{
	font-weight: bold;
}

li
{
	margin-bottom: 5px;
}

.completeButton
{
	float:right;
}

th{
	 cursor: pointer; 
	 cursor: hand;
}

.myRow{
	 cursor: pointer; 
	 cursor: hand;
}

input::-webkit-calendar-picker-indicator{
	display: none;
}

input[type="date"]::-webkit-input-placeholder{ 
	visibility: hidden !important;
}

.tab{
	cursor: pointer;
}

#oSort
{
	margin-right:2px;
	background-color:#7ECC7F;
	border-color: #13a113;
}


#floatPanel
{
	display: none;
	left: 0;
}

.floatHeader
{
	text-align: center;
	cursor: pointer;
	cursor: hand;
}

.scrolling
{ 
	position: fixed;
	top: 0;
}


</style>

<div class="row">
	<div style="text-align:center" class="col-lg-8 col-lg-offset-2">
		<h2>
			Welcome 
			<?php
				$level = $_SESSION['PermissionLevel'];
				
				if( $level == 0 ){ echo $_SESSION['login']; }
				if( $level == 1 ){ echo $_SESSION['name']; }
				if( $level == 2 ){ echo $_SESSION['name']; }
			?>
		</h2>
	</div>
	<div class='col-lg-2'>
		<a href="#" class="btn btn-primary btn-xs" id='logOutButton' style='float: right'>Logout<div class="glyphicon glyphicon-log-in" style="margin-left:.5em"></div></a>
	</div>
</div>
<div id="appendSuccess" style="text-align:center"></div>

<!-- PAID/UNPAID PANEL -->
<div class="row">
	<div class='col-lg-4'>
		<div style="cursor:pointer" class='panel panel-default' <?php if($_SESSION['PermissionLevel'] == 2) echo "data-toggle='modal' data-target='#modalIGuess'" ?>>
			<a>
				<div class='panel-heading'>
					Number of Paid Obligations:  <span id="PaidObligationNumber"></span>
				</div>
				<div class='panel-heading'>
					Number of Unpaid Obligations: <span id="UnpaidObligationNumber"></span>
				</div>
			</a>	
		</div>
	</div>
	<?php
				$level = $_SESSION['PermissionLevel'];
				
				if( $level == 0 ){ echo"	<div class='panel panel-default col-lg-5 col-lg-offset-1'> <div class='panel-body'>Please make sure to turn in your obligations. If the obligation deals with money, or you have money to replace the item, please go see Mrs. Neil in her office in room 204. If you have an item to return, please return it to the teacher you owe the item to.</div></div> ";}
				
			?>

	<div class="col-lg-6 col-lg-offset-2" style="display:none" id="FilterDisplay">
		<?php //include "Filter.php" ?>
	</div>
</div>

<div style="width:90">
	<div>

		<ul id='navList' class="nav nav-tabs">
			<li><button type='button' class='btn btn-success' id="oSort"><img src="images/refreshIcon.png"></button></li>
			<li class="active tab" id="allTab"><a data-toggle="tab">All</a></li>
			<li class="tab" id="completeTab"><a data-toggle="tab">Complete</a></li>
			<li class="tab" id="incompleteTab"><a data-toggle="tab">Incomplete</a></li>
			<li><button type='button' class='btn btn-default' id="collapse">Collapse All -</button></li>
			<li><button type='button' class='btn btn-default' id="expand">Expand All +</button></li>
			
			<!-- Include filter and create button if not a student -->
			<?php
				if( $_SESSION['PermissionLevel'] != 0 ){
					/*echo
						"<li style='float:right'>
							<button id='filterButton' class='btn btn-primary' style='font-size:30px; padding:0 5px 0 5px'> Filter
								<img src='images/downFilter.png'/>
							</button>
							<button id='antifilterButton' class='btn btn-primary' style='display:none; font-size:30px; padding:0 5px 0 5px'> Filter
								<img src='images/upFilter.png'/>
							</button>
						</li>";*/
						
					echo "<li><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modal'><div class='glyphicon glyphicon-floppy-disk' style='margin-right:.5em'></div>Create an Obligation</button></li>";	
				}		
			?>
			<li><img src="images/iou.jpg" style="height:40px; width:35px"/></li>
			
			
			
			
			<?php include "modal.php"?>
		</ul>
	</div>
	
	<!-- TABLE -->
	<table id='myTable' class="table table-striped table-hover">
	
		<thead id='tableHead'>
			
			<?php
				
				$level = $_SESSION['PermissionLevel'];
				if( $level != 0 ){
					echo "<th>
					
					<div class='input-group'>
						<span class='input-group-addon'>
							<img class='sortimg' id='stoodHead' src='images/sort-none.png' />
						</span>
							<input class='form-control input' id='filter16' placeholder='Student Name' />
					</div>
					
					</th>";
				}
				if( $level == 0 ){
					echo "<th id='dateHead'>Date</th>";
				}
				if( $level != 1 ){
					echo "<th>					
					<div class='input-group'>
					<span class='input-group-addon'>
						<img class='sortimg' id='teachHead' src='images/sort-none.png' />
					</span>
						<input class='form-control input' id='filter18' placeholder='Teacher' />
					</div>
					
					</th>";
				}
				if( $level != 0 ){
					echo "<th>
				<div class='input-group'>
					<span class='input-group-addon'>
						<img class='sortimg' id='gradHead' src='images/sort-none.png' />
					</span>
					<select id='filter3' class='form-control input'>
						<option value='.*' style='font-weight:bold'>Grad Year</option>
						<script>
							$(document).ready(function(){
								var d = new Date();
								for(var x = (d.getMonth() > 6 ? 1 : 0); x < (d.getMonth() > 6 ? 5 : 4); x++)
								{
									$('#filter3').append('<option value=\'' + (d.getFullYear() + x) + '\'>' + (d.getFullYear() + x) + '</option>');
								}
							});
						</script>
					</select>
				</div></th>";
				}
				
			?>
			
			<th>
				<div class="input-group"> <!-- actHead -->
					<span class="input-group-addon">
					<img class="sortimg" id="actHead" src="images/sort-none.png" />
					</span>
					<input class="form-control input" id="filter5" placeholder="Class/Activity" />
				</div>
			</th>
			<th>
				<div class="input-group">
					<span class="input-group-addon">
						<img class="sortimg" id="typeHead" src="images/sort-none.png" />
					</span>
					<select id="filter8" class="form-control input">
						<option value='.*' style="font-weight:bold">Type</option>
						<?php
							
							
							$Query = "SELECT `Title`, `ID` FROM ObligationTypes";
							$result = QueryGetRows($connection, $Query);
							
							for($x = 0; $x < sizeof($result); $x++)
							{
								echo "<option value='".$result[$x][1]."'>".$result[$x][0]."</option>";
							}
						
						?>
					</select>
				</div>
			</th>
			<th id='costHead'>$Owed</th>
			<th id='returnTypeHead' style='max-width: 40px'>Return Type</th>
		</thead>
		
		<tbody id="tableBod">
		</tbody>
	</table>
	
	<button class="btn btn-primary" id="LoadMoreButton">Load More</button>
	
	<?php include "editModal.php" ?>
	<!-- MODAL, I GUESS -->
	<div class="modal fade" id="modalIGuess">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Report Generation
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				</div>
				<div class="modal-body">
					You can use this modal to generate reports in .pdf format.
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-success" data-dismiss="modal">Current Report</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal">Full Report</button>
				</div>
			</div>
		</div>
	</div>
	
<script src="jscript/sort.js"></script>
<script src="jscript/AjaxPullAllData.js"></script>
<script>

var EditTarget;

	$(document).ready(function(){
		
		
		setClickEvents();												//Applies listeners for row clicks
		
		$('#filterButton').click(function(){								//When filter is clicked
			$("#FilterDisplay").slideDown(500);
			$(this).css('display', 'none');
			$('#antifilterButton').css('display', 'inline');
		});
		$('#antifilterButton').click(function(){							//When filter is closed
			$("#FilterDisplay").slideUp(500);
			$(this).css('display', 'none');
			$('#filterButton').css('display', 'inline');
		});	
		
		//FILTERING INTO TABS
		$('.tab').click(function(){										//Whenever a tab is clicked
		
			if( !$(this).hasClass('active') ){							//Checks if this is an active tab
				
				$('#tableBod').html("");									//Clears the table
				resetLoad();
				$('.tab').removeClass('active');
				$(this).addClass('active');
				RunFilter();
			}
		});
		
		//LOGOUT
		$('#logOutButton').click(function(){
			$.ajax({
				url: "logout.php",
				success: function(){
					window.location.replace("login.php");
				}
			});
		});
		
		/* SORT BY:
			-#stoodHead
			-#teachHead
			-#dateHead
			-#gradHead
			-#actHead
			-#typeHead
			-#costHead
		*/	
		$('th').mouseover(function(){
			$(this).css('background-color','#eeeeee');
		});
		$('th').mouseout(function(){
			$(this).css('background-color','white');
		});
		
		$('.floatHeader').mouseover(function(){
			$(this).css('background-color','#eeeeee');
		});
		$('.floatHeader').mouseout(function(){
			$(this).css('background-color','white');
		});
		
		$('.floatHeader').css('height', $('#floatPanel').height()+"px");
		
	});
	
	$("#collapse").click(collapseAll);
	$("#expand").click(expandAll);
	
	function collapseAll()
	{
		$.each($("#tableBod").find("tr[expanded~='1']"), 
		function(x, v){
			Collapse($(v));
		});
	}
	function expandAll()
	{
		$.each($("#tableBod").find("tr[expanded~='0']"), 
		function(x, v){
			Expand($(v));
		});
	}
	
	function Expand(ThisRow)
	{
					
		ThisRow.next().show();
		ThisRow.next()
			.find('td')
			.wrapInner('<div style="display: none;" />')
			.parent()
			.find('td > div')
			.slideDown(500, function(){

				var $set = $(this);
				$set.replaceWith($set.contents());

			});
		ThisRow.attr("expanded", 1);
	}
	
	function Collapse(ThisRow)
	{
		var row = ThisRow.next();
				row.find('td')
					 .wrapInner('<div style="display: block;" />')
					 .parent()
					 .find('td > div')
					 .slideUp(500, function(){
						$(this).parent().parent().hide();
						$(this).contents().unwrap();
					 });
				ThisRow.attr("expanded", 0);
	}
	
	function setClickEvents()
	{
		$('.myRow').unbind("click");
		$('.myRow').click(function(){
			var ThisRow = $(this);
			if(ThisRow.attr("expanded") == 1)
			{
				Collapse(ThisRow);
			}
			else
			{
				Expand(ThisRow);
			}
		});
		
		
		$(".completeButton").click(function(){
			COMPLETE_DATA_TARGET = $(this).attr("complete-id");
		});
		$(".PartPay").click(function(){
			PartialPayTarget = $(this).attr("complete-id");
		});
		$(".editButton").click(function(){
			EditTarget = $(this).attr("complete-id");
		});
	}
	
	/*
	//TABLE HEADER SCROLLING THINGY
	$(window).scroll(function(){
		
		var scrollPosition, headerOffset, isScrolling;
		scrollPosition = $(window).scrollTop();
		tableOffset = $('#myTable').offset().top;
		isScrolling = scrollPosition > tableOffset;
		
		if(isScrolling){
			$('#tableHead').toggleClass('scrolling');
			$('th').attr('colspan', 1);
		}
		
	}); 
	*/
	
	//FLOAT SCROLL THINGY I DON'T KNOW WHATEVER
	$(window).scroll(function(){
	  
	  var scrollPosition, headerOffset, isScrolling;
	  scrollPosition = $(window).scrollTop();
	  headerOffset = $('#tableHead').offset().top;
	  isScrolling = scrollPosition > headerOffset;
	  
	  if(isScrolling){
		  $('#floatPanel').css('display', 'inline');
		  $('#floatPanel').toggleClass('scrolling', isScrolling);
	  }
	  else{
		  $('#floatPanel').css('display','none');
	  }
	  
	});
	
	
</script>
	
	<?php include "completeModal.php"?>
	<?php include "PartialPay.php" ?>
</div>

<!--FLOATING PANEL-->
<div class='panel panel-default col-lg-12' id='floatPanel'>
	<div class='panel-body'>
		
		<?php
			
			$level = $_SESSION['PermissionLevel'];
			if( $level != 0 ){
				echo "
				<div class='col-lg-2"; 
				if($level == 1){
					echo " col-lg-offset-1";
				}
				
				echo " floatHeader'>
					<div class='input-group'>
						<span class='input-group-addon'>
							<img class='sortimg' id='floatStoodHead' src='images/sort-none.png' />
						</span>
							<input class='form-control input' placeholder='Student Name' />
					</div>
				</div>";
			}
			if( $level == 0 ){
				echo "<div class='col-lg-2 floatHeader' id='floatDateHead'>Date</div>";
			}
			if( $level != 1 ){
				echo "
				<div class='col-lg-2 floatHeader'>					
					<div class='input-group'>
						<span class='input-group-addon'>
							<img class='sortimg' id='floatTeachHead' src='images/sort-none.png' />
						</span>
							<input class='form-control input' placeholder='Teacher' />
					</div>
				</div>";
			}
			if( $level != 0 ){
				echo "
				<div class='col-lg-2 floatHeader'>
					<div class='input-group'>
						<span class='input-group-addon'>
							<img class='sortimg' id='floatGradHead' src='images/sort-none.png' />
						</span>
						<select class='form-control input'>
							<option value='.*' style='font-weight:bold'>Grad Year</option>
						</select>
					</div>
				</div>";
			}
			
		?>
		
		<div class='col-lg-2 floatHeader'>
			<div class="input-group">
				<span class="input-group-addon">
				<img class="sortimg" id="floatActHead" src="images/sort-none.png" />
				</span>
				<input class="form-control input" placeholder="Class/Activity" />
			</div>
		</div>
		<div class='col-lg-2 floatHeader'>
			<div class="input-group">
				<span class="input-group-addon">
					<img class="sortimg" id="floatTypeHead" src="images/sort-none.png" />
				</span>
				<select class="form-control input">
					<option value='.*' style="font-weight:bold">Type</option>
					<?php
						
						
						$Query = "SELECT `Title`, `ID` FROM ObligationTypes";
						$result = QueryGetRows($connection, $Query);
						
						for($x = 0; $x < sizeof($result); $x++)
						{
							echo "<option value='".$result[$x][1]."'>".$result[$x][0]."</option>";
						}
					
					?>
				</select>
			</div>
		</div>
		<div class='col-lg-2 floatHeader' id='floatCostHead'>$Owed</div>
		
		
		
	</div>
</div>

<?php require "settingsPHP/DataProcessingScript.php" ?>
<?php require "settingsPHP/footer.php"?>