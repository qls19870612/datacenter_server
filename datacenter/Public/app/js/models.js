var _CurrentDate = _CurrentDate || new Date();
var hc_models = hc_models || {};
var fx_models = fx_models || {};
// var dailyOverview = new FTX();
// var monthlyOverview = new FTX();


// var themeDefaul = ['#4f81bd','#c0504d','#9bbb59','#8064a2','#4bacc6', '#db843d', '#93a9cf', '#d19392'];

hc_models.recentConsumer = {
	chart: {
		animation : false,
		zoomType: 'none'
	},
	exporting: {
		enabled: false
	},
	title: {
		useHTML:true,
		text:'&nbsp;'
	},
	xAxis: [{
		categories: []
	}],
	yAxis: [{ // Primary yAxis
		labels: {
			format: '{value}人',
			style: {
				color: '#89A54E'
			}
		},
		title: {
			text: '用户数',
			style: {
				color: '#89A54E'
			}
		}
	}, { // Secondary yAxis
		title: {
			text: '消费',
			style: {
				color: '#4572A7'
			}
		},
		labels: {
			format: '{value}.00万元',
			style: {
				color: '#4572A7'
			}
		},
		opposite: true
	}],
	tooltip: {
		shared: true
	},
	legend: {
		align: 'center',
		verticalAlign: 'top',
		floating: true,
		backgroundColor: '#FFFFFF'
	},
	series: [{
		name: '日消费(万元)',
		color: '#4572A7',
		type: 'column',
		yAxis: 1,
		data: [],
		tooltip: {
			valueSuffix: '万元'
		}

	}, {
		name: '新增消费用户数',
		color: '#910000',
		type: 'line',
		data: [],
		tooltip: {
			valueSuffix: '人'
		}
	}, {
		name: '消费用户数',
		color: '#89A54E',
		type: 'line',
		data: [],
		tooltip: {
			valueSuffix: '人'
		}
	}],
	plotOptions:{
		series:{
			animation : false
		}
	}
}



hc_models.recentActive = {
	chart: {
		animation : false,
		zoomType: 'none'
	},
	exporting: {
		enabled: false
	},
	title: {
		useHTML:true,
		text:'&nbsp;'
	},
	xAxis: [],
	yAxis: [{
		labels: {
			format: '{value}人',
			style: {
				color: '#89A54E'
			}
		},
		stackLabels: {
			enabled: true,
			style: {
				fontWeight: 'bold',
				color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
			}
		},
		title: {
			text: '用户数',
			style: {
				color: '#89A54E'
			}
		}
	}],
	tooltip: {
		formatter: function() {
			var _dau = this.point.stackTotal ? 'DAU: ' + this.point.stackTotal : '';
			return '<b>' + this.x + '</b><br/>' +
				this.series.name + ': ' + this.y + '<br/>' + _dau
		}
	},
	legend: {
		align: 'center',
		verticalAlign: 'top',
		floating: true,
		backgroundColor: '#FFFFFF'
	},
	plotOptions: {
		column: {
			stacking: 'normal',
			dataLabels: {
				enabled: true,
				color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
			}
		},
		series:{
			animation : false
		}
	},
	series: [{
		name: '注册用户数',
		color: '#4572A7',
		type: 'column',
		data: [],
		tooltip: {
			valueSuffix: '人'
		}

	}, {
		name: '非新活跃用户数',
		color: '#8064a2',
		type: 'column',
		data: [],
		tooltip: {
			valueSuffix: '人'
		}
	}, {
		name: '创建角色数',
		color: '#910000',
		type: 'line',
		data: [],
		tooltip: {
			valueSuffix: '人'
		}
	}, {
		name: 'PCU',
		color: '#89A54E',
		type: 'line',
		data: [],
		tooltip: {
			valueSuffix: '人'
		}
	}]
}


hc_models.dashboard = {
	chart: {
		animation : false,
		type: 'gauge',
		plotBackgroundColor: null,
		plotBackgroundImage: null,
		plotBorderWidth: 0,
		plotShadow: false
	},
	exporting: {
		enabled: false
	},
	title: {
		text: null
	},
	pane: {
		startAngle: -150,
		endAngle: 150,
		background: [{
			backgroundColor: {
				linearGradient: {
					x1: 0,
					y1: 0,
					x2: 0,
					y2: 1
				},
				stops: [
					[0, '#FFF'],
					[1, '#333']
				]
			},
			borderWidth: 0,
			outerRadius: '109%'
		}, {
			backgroundColor: {
				linearGradient: {
					x1: 0,
					y1: 0,
					x2: 0,
					y2: 1
				},
				stops: [
					[0, '#333'],
					[1, '#FFF']
				]
			},
			borderWidth: 1,
			outerRadius: '107%'
		}, {
			// default background
		}, {
			backgroundColor: '#DDD',
			borderWidth: 0,
			outerRadius: '105%',
			innerRadius: '103%'
		}]
	},
	// the value axis
	yAxis: {
		min: 0,
		max: 200,

		minorTickInterval: 'auto',
		minorTickWidth: 1,
		minorTickLength: 10,
		minorTickPosition: 'inside',
		minorTickColor: '#666',

		tickPixelInterval: 30,
		tickWidth: 2,
		tickPosition: 'inside',
		tickLength: 10,
		tickColor: '#666',
		labels: {
			step: 2,
			rotation: 'auto'
		},
		title: {
			text: 'KPI'
		},
		plotBands: [{
			from: 0,
			to: 120,
			color: '#55BF3B' // green
		}, {
			from: 120,
			to: 160,
			color: '#DDDF0D' // yellow
		}, {
			from: 160,
			to: 200,
			color: '#DF5353' // red
		}]
	},
	series: [{
		name: 'kpi',
		data: [],
		tooltip: {
			valueSuffix: '% KPI已完成'
		},
		dataLabels: {
			formatter: function() {
				var p = this.y;
				return p + ' %';
			},
			style: {
				color: '#333',
				fontSize: '24px'
			}
		}
	}],
	plotOptions:{
		series:{
			animation : false
		}
	}
}


hc_models.retention = {
	chart: {
		animation : false
	},
	title: {
		useHTML:true,
		text:'&nbsp;'
	},
	exporting: {
		enabled: false
	},
	xAxis: [],
	yAxis: {
		labels: {
			format: '{value}%',
			style: {
				color: '#333'
			}
		},
		title: {
			text: '用户百分比'
		},
		plotLines: [{
			value: 0,
			width: 1,
			color: '#808080'
		}]
	},
	tooltip: {
		valueSuffix: '%'
	},
	legend: {
		align: 'center',
		verticalAlign: 'top',
		floating: true,
		backgroundColor: '#FFFFFF'

	},
	series: [{
		name: '30日留存',
		color: '#4f81bd'
	}, {
		name: '15日留存',
		color: '#c0504d'
	}, {
		name: '7日留存',
		color: '#9bbb59'
	}, {
		name: '3日留存',
		color: '#8064a2'
	}, {
		name: '次日留存',
		color: '#4bacc6'
	}],
	plotOptions:{
		series:{
			animation : false
		}
	}
}

hc_models.propsTop = {
	chart: {
		animation : false,
		plotBackgroundColor: null,
		plotBorderWidth: null,
		plotShadow: false
	},
	exporting: {
		enabled: false
	},
	title: {
		text: null
	},
	tooltip: {
		pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	},
	plotOptions: {
		pie: {
			allowPointSelect: true,
			cursor: 'pointer',
			dataLabels: {
				enabled: true,
				color: '#000000',
				connectorColor: '#000000',
				// format: '{point.name}'
				format: '{point.name}<br>{point.percentage:.1f} %'
			}
		},
		series:{
			animation : false
		}
	},
	series: [{
		type: 'pie',
		name: '所占比例',
		data: []
	}]
}




fx_models.dailyOverview = {

	props : [{
		icon: 'roles',
		title: '月创建角色'
	}, {
		icon: 'mincome',
		title: '月总收入'
	}, {
		icon: 'users',
		title: '月注册用户'
	}, {
		icon: 'dincome',
		title: '日均收入'
	}],

	domFormat : function(data) {
		var _prop = this.props;
		var html = '<div class="tf3" style="width: 12%; float: left; height: 160px; background: none repeat scroll 0% 0% rgb(69, 114, 167);"><p id="CurrentMonth" style="color: rgb(255, 255, 255); text-align: center; font-size: 32px; padding-top: 60px;">'+(_CurrentDate.getMonth()+1)+'月</p></div>'
		html += '<div class="tf2" style="width:88%; float:left"><table>';
		for (var i in _prop) {
			var _icon = _prop[i].icon || '',
				_title = _prop[i].title || '';
			if (_icon || _title) {
				var _data = data[i] || 'no data';
				if (i % 2 == 0) {
					html += '<tr><td><p class="sum_ttl"><i class="ttl_icon ' + _icon + '"></i>' + _title + ':</p></td><td><p class="sum_num">' + (_data == 'no data' ? _data : _data.addComma() )+ '</p></td>';
				} else {
					html += '<td><p class="sum_ttl"><i class="ttl_icon ' + _icon + '"></i>' + _title + ':</p></td><td><p class="sum_num">' + (_data == 'no data' ? _data : _data.addComma() )+ '</p></td></tr>';
				}
			} else {
				break;
			}
		}
		html += '</table></div>';
		return html;
	}
}



fx_models.monthlyOverview = {
	props : [{
		icon: 'servers',
		title: '总开服量'
	}, {
		icon: 'register',
		title: '总注册量'
	}, {
		icon: 'roless',
		title: '总创角量'
	}],

	domFormat : function(data) {
		var _prop = this.props;
		var html = '<div class="tf1"><table>';
		for (var i in _prop) {
			var _icon = _prop[i].icon || '',
				_title = _prop[i].title || '';
			if (_icon || _title) {
				var _data = data[i] || 'no data';
				html += '<tr><td><p class="sub_ttl"><i class="ttls_icon ' + _icon + '"></i>' + _title + ':</p></td><td><p class="sub_num">' + (_data == 'no data' ? _data : _data.addComma() )+ '</p></td></tr>';
			} else {
				break;
			}
		}
		html += '</table></div>';
		return html;
	}
}


