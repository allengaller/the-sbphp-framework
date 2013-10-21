$.include(['../../css/default.css','../../js/default.js']);
function LoadVerifyPic() {
	var clsDate = new Date();
	var url = "/admin/manager/code?cachetime=" + clsDate.getTime();
	document.getElementById("verify_code").src = url;
}

function login() {
	var user = $.trim($('#user').val());
	var pwd = $.trim($('#pwd').val());
	var code = $.trim($('#code').val());
	
	if(isEmpty(user)){
		alert('请填写用户名');
		$('#user').focus();
		return;
	}
	
	if(isEmpty(pwd)){
		alert('请输入密码');
		$('#pwd').focus();
		return;
	}
	
	if(isEmpty(code)){
		alert('请输入验证码');
		$('#code').focus();
		return;
	}
	
	var urls ="/admin/manager/ck";
	var datas={'user':user,'pwd':pwd,'code':code};
	postData(urls,datas,function(msg){
		var json=eval(msg);
		if(json['infoNo'] == 0){
			alert(json['infoStr']);
			$('#code').val('123');
			LoadVerifyPic();
		}else{
			var info = json['infoStr']
			location.href='/admin/manager/main';
		}
	});
}