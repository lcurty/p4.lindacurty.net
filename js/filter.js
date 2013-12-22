// JavaScript Document
	
$(document).ready(function () {
	
	// Declare row variable
	var $rows = $('#animal_table tbody tr');
	
	// Listener and function
	$('#search').keyup(function () {
	
		var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
			reg = RegExp(val, 'i'),
			text;
	
		$rows.show().filter(function() {
			text = $(this).text().replace(/\s+/g, ' ');
			return !reg.test(text);
		}).hide();
	
	});

});