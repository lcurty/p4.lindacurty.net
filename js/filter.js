// JavaScript Document
	
$(document).ready(function () {
		resetForms();
		filter();
});

var $rows = $('#animal_table tr');

function resetForms() {
    document.forms['animal_filter'].reset();
}

// Listeners
$('input').keyup(filter);

// Calculation function
function filter() {

    var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
        reg = RegExp(val, 'i'),
        text;

    $rows.show().filter(function() {
        text = $(this).text().replace(/\s+/g, ' ');
        return !reg.test(text);
    }).hide();

}