//设置highchart属性
var _realTime = moment().format('YYYY-MM-DD hh:mm:ss'), __timeOuter, __freeze = false;
var _loadDom = '<div id="iframeLoading" style="padding:24px 0 0 0;" class="row" ><div style="background: url(../../resource/images/GUI/loading2.gif) center top no-repeat; height: 32px;" class="loading"></div><div><p style="text-align:center;">正在加载...</p></div></div>';


var _stockCharts = {
	'accountcount':{
		'title':'实时在线账户数据',
		'subtitle':'',
		'case':'#AccountCount',
		'sql_id':126,
		'sql_key':'online_dynamic',
		'time_axis':'stattime',
		'series' : [{
				'name' : '今天账号数',
				'dataVal' : 'accountcount_a',
				'data':[]
			},{
				'name' : '昨天账号数',
				'dataVal' : 'accountcount_b',
				'data':[]
			},{
				'name' : '周同比账号数',
				'dataVal' : 'accountcount_c',
				'data':[]
			}],
		'intervaler':{}
	},
		'playercount':{
		'title':'实时在线角色数据',
		'subtitle':'',
		'case':'#PlayerCount',
		'sql_id':127,
		'sql_key':'online_dynamic',
		'time_axis':'stattime',
		'series' : [{
				'name' : '今天角色数',
				'dataVal' : 'playercount_a',
				'data':[]
			},{
				'name' : '昨天角色数',
				'dataVal' : 'playercount_b',
				'data':[]
			},{
				'name' : '周同比角色数',
				'dataVal' : 'playercount_c',
				'data':[]
			}],
		'intervaler':{}
	}
}





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

var __rendererStockChart = function(stockid){
	var stock_config = _stockCharts[stockid];
	var tcase = $(stock_config['case']);
	tcase.highcharts('StockChart', {
		chart : {
			events : {}
		},
		legend: {
	    	enabled: true,
	    	align: 'right',
        	borderColor: 'black',
        	borderWidth: 1,
	    	layout: 'vertical',
	    	verticalAlign: 'top',
	    	y: 100
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
			text : stock_config['title']
		},

		subtitle: {
			text : stock_config['subtitle']
		},
		
		exporting: {
			enabled: false
		},
		
		series : stock_config['series']
	});
}

var __renderAjaxMods = function(num){
	if(!__freeze){
		__freeze = true;
		clearTimeout(__timeOuter);
		SUB_STATUS.cur.sel_server = SUB_STATUS.ope.serverCount();

		$('.highchart').each(function(){
			var _this = $(this), _stockid = _this.data('stockid');
			var stock_config = _stockCharts[_stockid], tcase = $(stock_config['case']);
			var params = {
				'controller': 'ajax',
				'method': 'getdata',
				'et': SUB_STATUS.cur.sel_end_date,
				'ft': SUB_STATUS.cur.sel_start_date,
				'game': SUB_STATUS.cur.sel_game,
				'sql_id': stock_config['sql_id'],
				'sql_key': stock_config['sql_key']
			}
			$.extend(params, SUB_STATUS.cur.sel_server);

			$.ajax({
				url: SUB_STATUS.url.request,
				type: 'POST',
				data: params,
				dataType: 'json',
				beforeSend: function() {
					tcase.html(_loadDom);
				},
				success: function(d) {
					if (d.code == 200) {
						var resultData = d.data;
						var series = stock_config['series'];
						var time_axis = stock_config['time_axis'];

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
								}
							}
							__rendererStockChart(_stockid);
							__freeze = false;
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
		})
		__timeOuter = setTimeout(__renderAjaxMods, 120000);
	}
	
}



