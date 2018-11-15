//初始化
var _CurrentDate = _CurrentDate || new Date();


/* HC_MODS */
var hc_mod = function(model) {
	var _model = hc_models[model];
	this.model = {};
	$.extend(true, this.model, _model);

};

hc_mod.prototype.setTitle = function(text) {
	var _title = {};
	_title.text = text;
	this.model.title = this.model.title || [];
	$.extend(true, this.model.title, _title);
	return this;
}


hc_mod.prototype.setxAxis = function(xaxis) {
	var _xAxis = [];
	_xAxis[0] = {}
	_xAxis[0].categories = xaxis;
	this.model.xAxis = this.model.xAxis || [];
	$.extend(true, this.model.xAxis, _xAxis);
	return this;
}

hc_mod.prototype.setData = function(data) {
	var series = [];
	for (var i = 0; i < data.length; i++) {
		series[i] = {};
		series[i].data = data[i]
	}
	this.model.series = this.model.series || []
	$.extend(true, this.model.series, series);
	return this;
}


hc_mod.prototype.setLabelInterval = function(interval){
	var _container = this.container || '';
	if(!_container) return;
	var _$container = $(_container);
	_$container.find('.highcharts-axis-labels text').each(function(index, el) {
		if(index%interval != 0){
			$(el).hide();
		}
	});
	return this;
}


hc_mod.prototype.combination = function(data, xAxis, container) {
	var _data = data;
	var _xaxis = xAxis;
	var _container = container;
	if (_data) this.setData(_data);
	if (_xaxis) {
		if (typeof(_xaxis) == 'array') {
			this.setxAxis(_xaxis);
		} else if (typeof(_xaxis) == 'string') {
			var _date = _xaxis.split(':')[0];
			var _count = _xaxis.split(':')[1];
			this.setxAxis(getDatexAxis(_date, _count));
		}
	}

	function getDatexAxis(date, count, interval) {
		var endDate = date == 'today' ? new Date() : new Date(window[date]);
		var _datexAxis = [];
		for (var i = 0; i < count; i++) {
			var tmpDate = new Date(endDate);
			_datexAxis.unshift(tmpDate.addDays(-i).format('MM/dd'));
		}
		return _datexAxis;
	}

	if (_container) this.container = _container;
	return this;
}

hc_mod.prototype.render = function(data, xAxis, container) {
	var _data = data;
	var _xaxis = xAxis;
	if (_data || _xaxis) {
		this.combination(_data, _xaxis);
	}
	if (container) {
		this.container = container;
	}
	$(this.container).highcharts(this.model);
	return this;
}


/* FX_MODS */
// var fx_mod = function(model) {
// 	var _model = fx_models[model];
// 	this.model = {};
// 	$.extend(true, this.model, _model);
// };

// fx_mod.prototype.combination = function(data, container) {
// 	var _data = data;
// 	var _container = container;
// 	if (_data) this.html = this.model.domFormat(data);
// 	if (_container) this.container = _container;
// 	return this;
// }


// fx_mod.prototype.render = function(data, container) {
// 	var _data = data;
// 	var _container;
// 	if (_data) this.html = this.model.domFormat(data);
// 	if (container) {
// 		this.container = container;
// 	}
// 	$(this.container).html(this.html);
// 	return this;
// }



/* 日期类型扩展 */
Date.prototype.dateDiff = function(interval, endTime) {
	switch (interval) {
		case "s": //計算秒差 
			return parseInt((endTime - this) / 1000);
		case "n": //計算分差 
			return parseInt((endTime - this) / 60000);
		case "h": //計算時差 
			return parseInt((endTime - this) / 3600000);
		case "d": //計算日差 
			return parseInt((endTime - this) / 86400000);
		case "w": //計算週差 
			return parseInt((endTime - this) / (86400000 * 7));
		case "m": //計算月差 
			return (endTime.getMonth() + 1) + ((endTime.getFullYear() - this.getFullYear()) * 12) - (this.getMonth() + 1);
		case "y": //計算年差 
			return endTime.getFullYear() - this.getFullYear();
		default: //輸入有誤 
			return undefined;
	}
};
Date.prototype.format = function(format) {
	var o = {
		"M+": this.getMonth() + 1, //month
		"d+": this.getDate(), //day
		"h+": this.getHours(), //hour
		"m+": this.getMinutes(), //minute
		"s+": this.getSeconds(), //second
		"q+": Math.floor((this.getMonth() + 3) / 3), //quarter
		"S": this.getMilliseconds() //millisecond
	};
	if (/(y+)/.test(format)) {
		format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
	}
	for (var k in o) {
		if (new RegExp("(" + k + ")").test(format)) {
			format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
		}
	}
	return format;
};
Date.prototype.addDays = function(d) {
	this.setDate(this.getDate() + d);
	return this;
};


/* 数字类型扩展 */
Number.prototype.addComma = function() {
	var str = '';
	var str = '';
	var tmpArr = this.toString().split('');
	var length = tmpArr.length;
	for (var i = 0; i < length; i++) {
		var last = tmpArr.pop();
		if ((i + 1) % 3 == 0 && i != length - 1) {
			str = ',' + last + str;
		} else {
			str = last + str;
		}
	}
	return str;
}