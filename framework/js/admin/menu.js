$.include(['../../css/default.css','../../js/default.js','../../js/basic/dropdown.js']);

function saveData(){
	var s = $("#myModalLabel").text();
	alert(s);
	$('#myModal').modal('hide');
}
