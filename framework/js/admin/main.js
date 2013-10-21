$.include(['../../js/default.js','../../css/basic/modern.css','../../css/basic/modern-responsive.css','../../css/admin/main.css','../../js/basic/dropdown.js']);

function clean(){
	var urls ="/admin/manager/clean";
	var datas={};
	postData(urls,datas,function(msg){
		var json=eval(msg);
		alert(json['infoStr']);
	});
}
