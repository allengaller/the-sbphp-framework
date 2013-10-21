$.include(['../../css/basic/bootstrap.min.css',

			'../../js/basic/bootstrap.min.js',
			'../../css/basic/font-awesome.min.css']);
/**
 * 统一提交数据方法 urls: 处理数据的url地址 datas:需要处理的数据，数组键值对 callback：返回数据处理的回调函数
 */
function postData(urls, datas, callback) {
	try {
		$.ajax({
			async:false,
			type : 'POST',
			dataType : 'json',
			url : urls,
			data : datas,
			success : callback
		});
	} catch (e) {
		alert(e.message);
		return;
	}
}

//异步方式提交数据
function post(urls, datas, callback) {
	try {
		$.ajax({
			async:true,
			type : 'POST',
			dataType : 'json',
			url : urls,
			data : datas,
			success : callback
		});
	} catch (e) {
		alert(e.message);
		return;
	}
}
/**
 * 判断是否为空
 *
 * @param value
 * @returns {Boolean}
 */
function isEmpty(value) {
	if (value == undefined || value == null || value == 'null' || value == 'undefined' || value.length == 0) {
		return true;
	}
	return false;
}

