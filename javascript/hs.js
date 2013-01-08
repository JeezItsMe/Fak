$(document).ready(function(){ 
	$("#officeDetails").hide(); 
	$("#specialDetails").hide();
	$("#catDetails").show(); 
	$('#hsCatering').click(function() {
	$("#officeDetails").slideUp(); 
	$("#specialDetails").slideUp();
	$("#catDetails").slideDown(); 
		});
	$('#hsOffice').click(function() {
	$("#specialDetails").slideUp();
	$("#catDetails").slideUp(); 
	$("#officeDetails").slideDown(); 
		});
	$('#hsSpecial').click(function() {
	$("#officeDetails").slideUp(); 
	$("#catDetails").slideUp(); 
	$("#specialDetails").slideDown();
		});
	}); 