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
		"chart": {
			"zoomType": ""
		},
		"title": {
			"text": ""
		},
		"subtitle": {
			"text": ""
		},
		"yAxis":[{
			"labels":{
				"format":""
			},
			"title":{
				"text":""
			},
			"stackLabels": {
	            "enabled": false
	        }
		}],
		"xAxis": [{
			"categories": []
		}],
		"xkey":"",
		"series": []
	}
	var yAxis_r = {
		"labels":{
				"format":""
		},
		"title":{
			"text":""
		},
		"stackLabels": {
            "enabled": false
        },
        "opposite":true
	};
	var indepenColumns = {
		"series": {
			"dataLabels": {
				"color": "gray"
			}
		}
	};
	var groupColumns = {
		"series": {
			"dataLabels": {
				"color": "gray"
			}
		},
        "column": {
			"stacking": "normal"
		}
	};

	var zoomType = $('#zoomType').val() || '';
	var mainTitle = $('#mainTitle').val() || '';
	var subTitle = $('#subTitle').val() || '';
	var xkey = $('#xkey').val() || '';

	var ylabels = $('#yAxis').find('input[cid="ylabels"]').val() || '';
	var ytitle = $('#yAxis').find('input[cid="ytitle"]').val() || '';

	

	
	var series = [];
	$('#series').find('fieldset.config-group').each(function(i) {
		var _configGroup = $(this),
			itm = {};
		var name = _configGroup.find('[cid="sname"]').val();
		var dataLabels = { "enabled": false }
		if(_configGroup.find('[cid="sdataLabels"]:checked').length > 0){
			dataLabels = { "enabled": true };
		}
		var yAxis = _configGroup.find('[cid="syAxis"]').val();
		var type = _configGroup.find('[cid="stype"]').val();
		var valueSuffix = _configGroup.find('[cid="svalueSuffix"]').val();
		var t_key = _configGroup.find('[cid="skey"]').val();
		var key = $.trim(t_key);
		itm.name = name;
		itm.dataLabels = dataLabels;
		itm.yAxis = Number(yAxis);
		itm.type = type;
		itm.tooltip = {};
		itm.tooltip.valueSuffix = valueSuffix;
		itm.key = key;
		itm.data = [];
		series.push(itm);
	})
	module.chart.zoomType = zoomType;
	module.title.text = mainTitle;
	module.subtitle.text = subTitle;
	module.xkey = xkey;
	module.yAxis[0].labels.format = '{value}' + $.trim(ylabels);
	module.yAxis[0].title.text = $.trim(ytitle);

	if($('#yAxis_r').find('input[cid="yAxis_r_enable"]:checked').length > 0){
		var ylabels_r = $('#yAxis_r').find('input[cid="ylabels_r"]').val() || '';
		var ytitle_r = $('#yAxis_r').find('input[cid="ytitle_r"]').val() || '';
		yAxis_r.labels.format = '{value}' + $.trim(ylabels_r);
		yAxis_r.title.text = $.trim(ytitle_r);
		module.yAxis.push(yAxis_r);
	}

	module.series = series;

	if($('#groupColumns').is(':checked')){
		module.plotOptions = groupColumns;
	}else{
		module.plotOptions = indepenColumns;
	}
	
	return module;
}

// 输入
var fetchHighchartColum = function(configData) {
	if (!isEmpty(configData)) {
		var cg = configData,
			chart_zoomType = cg.chart ? (cg.chart.zoomType || '') : '',
			title_text = cg.title ? (cg.title.text || '') : '',
			subtitle_text = cg.subtitle ? (cg.subtitle.text || '') : '',
			xkey = cg.xkey || '',
			yAxis = cg.yAxis || [],
			series = cg.series || [],
			groupColumns = cg.plotOptions.column ? 1 : 0,
			series_len = series.length;

		var selector = function(option, val) {
			var str = '';
			for (var i = 0; i < option.length; i++) {
				var itm = option[i].split('|'),
					selected = itm[0] == val ? 'selected' : '';
				str += '<option value="' + itm[0] + '" ' + selected + '>' + itm[1] + '</option>'
			}
			return str;
		}

		var checkbox = function(val){
			if(val){
				return 'checked = "checked"';
			}else{
				return '';
			}
		}
		$('#zoomType').val(chart_zoomType);
		$('#mainTitle').val(title_text);
		$('#subTitle').val(subtitle_text);
		$('#xkey').val(xkey);
	
		var _yAxisItems = $('#yAxis')
		var ylabels = yAxis[0].labels.format.replace('{value}', '') || '',
		ytitle = yAxis[0].title.text || '';
		_yAxisItems.find('input[cid="ylabels"]').val(ylabels);
		_yAxisItems.find('input[cid="ytitle"]').val(ytitle);
		if(yAxis.length > 1){
			var _yAxis_rItems = $('#yAxis_r')
			var ylabels_r = yAxis[1].labels.format.replace('{value}', '') || '',
			ytitle_r = yAxis[1].title.text || '';
			var _yAxis_rEnableBtn = _yAxis_rItems.find('input[cid="yAxis_r_enable"]');
			if(!_yAxis_rEnableBtn.is(':checked')){
				_yAxis_rEnableBtn.trigger('click');
				_yAxis_rItems.find('input[cid="ylabels_r"]').val(ylabels_r);
				_yAxis_rItems.find('input[cid="ytitle_r"]').val(ytitle_r);
			}
		}



		if(groupColumns && !$('#groupColumns').is(':checked')){
			if(!$('#groupColumns').is('checked')) $('#groupColumns').trigger('click');
		}

		if (series_len > 0) {
			var series_str = '<legend>数据：</legend><button class="addBtn">添加</button>';
			for (var i = 0; i < series_len; i++) {
				var series_itm = series[i];
				var sname = series_itm.name || '',
					stype = series_itm.type || '',
					svalueSuffix = series_itm.tooltip.valueSuffix || '',
					skey = series_itm.key || '',
					sdataLabels_l = series_itm.dataLabels || {},
					sdataLabels = sdataLabels_l.enabled || false,
					syAxis = series_itm.yAxis || 0,
					syAxis_select = ['0|左侧', '1|右侧'],
					stype_select = ['column|柱状', 'spline|曲线', 'line|折线'];

				series_str += '<fieldset class="config-group"><legend>项目：<span class="count">' + (i + 1) + '</span></legend><p class="config-itm" >标题：<input class="valElm" cid="sname" type="text" value="' + sname + '"></p><p class="config-itm">显示数据：<input class="valElm" cid="sdataLabels" type="checkbox" value="" '+checkbox(sdataLabels)+'></p><p class="config-itm">对应y轴：<select class="valElm" cid="syAxis">' + selector(syAxis_select, syAxis) + '</select></p><p class="config-itm">图形类别：<select class="valElm" cid="stype">' + selector(stype_select, stype) + '</select></p><p class="config-itm">单位：<input class="valElm" cid="svalueSuffix" type="text" value="' + svalueSuffix + '"></p><p class="config-itm">键名：<input class="valElm" cid="skey" type="text" value="' + skey + '"><span class="remark">用于关联数据</span></p><button class="removeBtn">删除</button></fieldset>';
			}
			$('#series').html(series_str);
		}
	}
}

var itemCollection = {
	series: function(idx){
		return '<fieldset class="config-group"><legend>项目：<span class="count">'+idx+'</span></legend><p class="config-itm">标题：<input class="valElm" cid="sname" type="text" value="图表标题"></p><p class="config-itm">显示数据：<input class="valElm" cid="sdataLabels" type="checkbox" value=""></p><p class="config-itm">对应y轴：<select cid="syAxis" class="valElm"><option selected="" value="0">左侧</option><option value="1">右侧</option></select></p><p class="config-itm">图形类别：<select class="valElm" cid="stype"><option value="column">柱状</option><option value="spline">曲线</option><option value="line">折线</option></select></p><p class="config-itm">单位：<input class="valElm" cid="svalueSuffix" type="text" value=""></p><p class="config-itm">键名：<input class="valElm" cid="skey" type="text" value=""><span class="remark">用于关联数据</span></p><button class="removeBtn">删除</button></fieldset>';
	}
}


// 刷新序数
var renderNum = function(){
	if(jQuery){
		$('#setting').find('fieldset.config-collection').each(function(){
			var _collection = $(this);
			_collection.find('fieldset.config-group').each(function(index) {
				var _group = $(this);
				_group.find('span.count').text(index+1);
			});
		});
	}
}

// 对象为空
var isEmpty = function(obj){ for (var name in obj) { return false; } return true; };