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

	// 恢复设置
	$('#refresh').on('click', function(){
		window.location = window.location;
	})
})

var DC_CHART_CONFIG = {};

// 输出
var getHighchartColum = function() {
	var module = {
        "title": {
            "text": ""
        },
        "tooltip": {
    	    "pointFormat": "{series.name}:{point.percentage:.1f}%"
        },
        "plotOptions": {
            "pie": {
                "allowPointSelect": 1,
                "cursor": "pointer",
                "dataLabels": {
                    "enabled": 1,
                    "format": "{point.name}:{point.percentage:.1f}%"
                }
            }
        },
        "series": [{
            "type": "pie",
            "name": "",
            "data": [],
            "key":""
        }]
    }


	var mainTitle = $('#mainTitle').val() || '';
	var series_name = $('#dataTitle').val() || '';
	var o_name = $('#optionName').val() || '';
	var o_data = $('#optionData').val() || '';
	var option_name = $.trim(o_name);
	var option_data = $.trim(o_data);

	module.title.text = mainTitle;
	module.series[0].name = series_name;
	module.series[0].key = option_name + '|' + option_data;
	
	return module;
}

// 输入
var fetchHighchartColum = function(configData) {
	if (!isEmpty(configData)) {
		var cg = configData,
			title_text = cg.title ? (cg.title.text || '') : '',
			series_name = cg.series[0].name || '';
		var optionArr = cg.series[0].key.split('|');
		var option_name = optionArr[0],
			option_data = optionArr[1];
			

		$('#mainTitle').val(title_text);
		$('#dataTitle').val(series_name);
		$('#optionName').val(option_name);
		$('#optionData').val(option_data);
	
	}
}


// 对象为空
var isEmpty = function(obj){ for (var name in obj) { return false; } return true; };
