$(function() {
	// 初始化
	var _configStr = $('#setting').data('config');
	if(_configStr){
	    try{
	        DC_CHART_CONFIG = JSON.parse(_configStr.replace(/\#\@/g, '"'));
	    }catch(e){}
	}
	if(DC_CHART_CONFIG){
		fetchHighchartColum(DC_CHART_CONFIG);
	}

	$('#configSave').on('click', function() {
		var json = getHighchartColum();
		var jsonStr = JSON.stringify(json);
		var jsonStr_f = jsonStr.replace(/\#\@/g, '').replace(/\"/g, '#@');
		$('#configStr').val(jsonStr_f);
		$('#configSql').val($('#sqlContent').val());
		$('#configSqlp').val($('#sqlContentp').val());
		$('#detailSettingSave').submit();
	})

	$('#setting').on('click', 'button', function() {
		var _this = $(this);
		if (_this.hasClass('addBtn')) {
			var _parent = _this.parent('fieldset.config-collection');
			var idx = _parent.find('fieldset.config-group').length;
			var newadd = itemCollection.series(idx);
			_parent.append(newadd);
		} else if(_this.hasClass('removeBtn')){
			var _parent = _this.parent('fieldset.config-group');
			_parent.remove();
		}
		renderNum();
	})


	// 恢复设置
	$('#refresh').on('click', function(){
		window.location = window.location;
	})
})

var DC_CHART_CONFIG = {};

// 输出
var getHighchartColum = function() {
	var module = {

		chart: {
			type: 'gauge',
		},

		title: {
			text: ''
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
						[0, '#fff'],
						[1, '#fff']
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
						[0, '#fff'],
						[1, '#fff']
					]
				},
				borderWidth: 1,
				outerRadius: '107%'
			}, {
				backgroundColor: '#DDD',
				borderWidth: 0,
				outerRadius: '105%',
				innerRadius: '103%'
			}]
		},

		yAxis: {
			min: 0,
			max: 160,

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
				text: ''
			},
			plotBands: [{
				from: 0,
				to: 100,
				color: '#55BF3B'
			}, {
				from: 100,
				to: 140,
				color: '#DDDF0D'
			}, {
				from: 140,
				to: 160,
				color: '#DF5353'
			}]
		},

		series: [{
			name: '',
			data: [],
			tooltip: {
				valueSuffix: ''
			}
		}]

	}

	// var zoomType = $('#zoomType').val() || '';
	var mainTitle = $('#mainTitle').val() || '';
	// var subTitle = $('#subTitle').val() || '';
	// var xkey = $('#xkey').val() || '';

	// var ylabels = $('#yAxis').find('input[cid="ylabels"]').val() || '';
	// var ytitle = $('#yAxis').find('input[cid="ytitle"]').val() || '';
	var sname = $('#sname').val() || '';
	var svalueSuffix = $('#svalueSuffix').val() || '';
	var t_scompleted = $('#scompleted').val() || '';
	var t_stotal = $('#stotal').val() || '';
	var scompleted = $.trim(t_scompleted);
	var stotal = $.trim(t_stotal);	


	module.title.text = mainTitle;


	module.series[0].name = sname;
	module.series[0].tooltip.valueSuffix = svalueSuffix;
	module.series[0].completedkey = scompleted;
	module.series[0].totalkey = stotal;
	
	return module;
}

// 输入
var fetchHighchartColum = function(configData) {
	if (!isEmpty(configData)) {
		var cg = configData,
			mainTitle = cg.title.text || '',
			sname = cg.series[0].name || '',
			svalueSuffix = cg.series[0].tooltip.valueSuffix || '',
			scompleted = cg.series[0].completedkey || '',
			stotal = cg.series[0].totalkey || '';


		$('#mainTitle').val(mainTitle);
		$('#sname').val(sname);
		$('#svalueSuffix').val(svalueSuffix);
		$('#scompleted').val(scompleted);
		$('#stotal').val(stotal);
	}
}

// 对象为空
var isEmpty = function(obj){ for (var name in obj) { return false; } return true; };

