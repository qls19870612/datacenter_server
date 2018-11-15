//设置highchart属性
var _realTime = moment().format('YYYY-MM-DD hh:mm:ss'), __setIntervaler, __setIntervalerUpdate;
var _loadDom = '<div id="iframeLoading" style="padding:24px 0 0 0;" class="row" ><div style="background: url(../../resource/images/GUI/loading2.gif) center top no-repeat; height: 32px;" class="loading"></div><div><p style="text-align:center;">正在加载...</p></div></div>';


var _stockCharts = [{
	'title':'实时在线数据',
	'subtitle':'',
	'case':'#OnlineInfo',
	'sql_id':112,
	'sql_key':'online_by_day_dynamic_g',
	'time_axis':'stattime',
	'series' : [{
			'name' : '账号数(人)',
			'dataVal' : 'accountcount',
			'data':[]
		},{
			'name' : '角色数(人)',
			'dataVal' : 'playercount',
			'data':[]
		}],
	'intervaler':{}
},{
	'title':'实时充值数据',
	'subtitle':'',
	'case':'#RechargeInfo',
	'sql_id':114,
	'sql_key':'online_by_day_dynamic_g',
	'time_axis':'stattime',
	'series' : [{
			'name' : '充值额(元)',
			'dataVal' : 'addrecharge',
			'data':[]
		}],
	'intervaler':{}
},{
	'title':'实时创角数据',
	'subtitle':'',
	'case':'#CreateroleInfo',
	'sql_id':121,
	'sql_key':'online_by_day_dynamic_g',
	'time_axis':'stattime',
	'series' : [{
			'name' : '创建账号数(人)',
			'dataVal' : 'accountcount',
			'data':[]
		},{
			'name' : '创建角色数(人)',
			'dataVal' : 'playercount',
			'data':[]
		}],
	'intervaler':{}
}]








if(Highcharts.setOptions){
	Highcharts.setOptions({ 
		global : { useUTC : false },
		lang: {
			months: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
			shortMonths:['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
			weekdays:['周日', '周一', '周二', '周三', '周四', '周五', '周六']
		}
	});
}

var __rendererStockChart = function(StockChart){
	var sc = StockChart;
	var tcase = $(sc['case']);
	tcase.highcharts('StockChart', {
		chart : {
			events : {
				load : function() {
					// var chart_series = this.series;
					// sc['intervaler'] = setInterval(function() {
					// 	var params = {
					// 		'controller': 'ajax',
					// 		'method': 'getdata',
					// 		'et': SUB_STATUS.cur.sel_end_date,
					// 		'ft': SUB_STATUS.cur.sel_start_date,
					// 		'game': SUB_STATUS.cur.sel_game,
					// 		'sql_id': sc['sql_id'],
					// 		'sql_key': sc['sql_key']
					// 	}
					// 	$.extend(params, SUB_STATUS.cur.sel_server);
					// 	$.ajax({
					// 		url: SUB_STATUS.url.request,
					// 		type: 'POST',
					// 		data: params,
					// 		dataType: 'json',
					// 		success: function(d) {
					// 			if (d.code == 200) {
					// 				var resultData = d.data;
					// 				var series = sc['series'];
					// 				var time_axis = sc['time_axis'];
					// 				var hasData = 0;

					// 				if(resultData.length > 0){
					// 					for(var k=0; k<series.length; k++){
					// 						series[k]['data'] = [];
					// 					}

					// 					for(var l=0; l<resultData.length; l++){
					// 						var resultData_item = resultData[l];
					// 						for(var j=0; j<series.length; j++){
					// 							var series_item = series[j], tmpArr = [], dataVal = series_item['dataVal'];
					// 							var xaxis = resultData_item[time_axis], yaxis = resultData_item[series_item['dataVal']];
					// 							tmpArr[0] = moment(xaxis, 'YYYY-MM-DD hh:mm:ss').valueOf();
					// 							tmpArr[1] = Number(yaxis);
					// 							series_item['data'].push(tmpArr);
					// 						}
					// 					}
					// 					for(var m=0; m<chart_series.length; m++){
					// 						chart_series[m].setData(series[m]['data']);
					// 						console.log('ok');
					// 					}
					// 				}
					// 			}
					// 		},
					// 		error: function(e) {
					// 		}
					// 	})
					// }, 10000);
				}
			}
		},
		rangeSelector: {
			buttons: [{
				count: 360,
				type: 'minute',
				text: '6h'
			}, {
				count: 720,
				type: 'minute',
				text: '12h'
			}, {
				type: 'all',
				text: '全部'
			}],
			inputEnabled: false,
			selected: 2
		},
		
		title : {
			text : sc['title']
		},

		subtitle: {
			text : sc['subtitle']
		},
		
		exporting: {
			enabled: false
		},
		
		series : sc['series']
	});
}

var __renderAjaxMods = function(num){
	__clearAllInterval(_stockCharts)
	SUB_STATUS.cur.sel_server = SUB_STATUS.ope.serverCount();
	
	for(var i=0; i<_stockCharts.length; i++){
		var StockChart = _stockCharts[i];
		var tcase = $(StockChart['case']);
		var params = {
			'controller': 'ajax',
			'method': 'getdata',
			'et': SUB_STATUS.cur.sel_end_date,
			'ft': SUB_STATUS.cur.sel_start_date,
			'game': SUB_STATUS.cur.sel_game,
			'sql_id': StockChart['sql_id'],
			'sql_key': StockChart['sql_key']
		}
		$.extend(params, SUB_STATUS.cur.sel_server);

		$.ajax({
			url: SUB_STATUS.url.request,
			type: 'POST',
			data: params,
			dataType: 'json',
			async: false,
			beforeSend: function() {
				tcase.html(_loadDom);
			},
			success: function(d) {
				if (d.code == 200) {
					var resultData = d.data;
					var series = StockChart['series'];
					var time_axis = StockChart['time_axis'];
					var hasData = 0;

					if(resultData.length > 0){
						for(var k=0; k<series.length; k++){
							series[k]['data'] = [];
						}

						for(var l=0; l<resultData.length; l++){
							var resultData_item = resultData[l];
							for(var j=0; j<series.length; j++){
								var series_item = series[j], tmpArr = [], dataVal = series_item['dataVal'];
								var xaxis = resultData_item[time_axis], yaxis = resultData_item[series_item['dataVal']];
								tmpArr[0] = moment(xaxis, 'YYYY-MM-DD hh:mm:ss').valueOf();
								tmpArr[1] = Number(yaxis);
								series_item['data'].push(tmpArr);
								// console.log(series_item['data']);
								// StockChart.series[j]['data'].push[tmpArr];
							}
						}
						__rendererStockChart(StockChart);

					}else {
						tcase.html('<p class="mod-error">没有数据</p>');
					}
				}else if(d.code == 0){
					tcase.html('<p class="mod-error">SQL执行异常</p>');
				}else {
					var err_msg = d.msg;
					tcase.html('<p class="mod-error">' + err_msg + '</p>');
				}
			},
			error: function(e) {
				tcase.html('<p class="mod-error">数据请求失败</p>');
			}
		})
	}
}


var __clearAllInterval = function(sc){
	for(var i=0; i<sc.length; i++){
		clearInterval(sc['intervaler']);
	}
}