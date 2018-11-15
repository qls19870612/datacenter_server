$(function() {

	// 初始化
	var _configStr = $('#setting').data('config');
	if(_configStr){
	    try{
	        DC_CHART_CONFIG = JSON.parse(_configStr.replace(/\#\@/g, '"'));
	    }catch(e){
	    }
	}
	if(DC_CHART_CONFIG){
		fetchHighchartColum(DC_CHART_CONFIG);
	}
		

	// 保存*
	$('#configSave').on('click', function() {
		var json = getHighchartColum();
		var jsonStr = JSON.stringify(json);
		var jsonStr_f = jsonStr.replace(/\#\@/g, '').replace(/\"/g, '#@');
		$('#configStr').val(jsonStr_f);
		$('#configSql').val($('#sqlContent').val());
		$('#configSqlp').val($('#sqlContentp').val());
		$('#detailSettingSave').submit();
		// console.log(jsonStr_f)
	})
	
	// 恢复设置
	$('#refresh').on('click', function(){
		window.location = window.location;
	})

	
})

// 全局对象 
var DC_CHART_CONFIG;


// 输出配置信息
var getHighchartColum = function() {
	var module = {
		column: []
	};
	$('#setting').find('fieldset.config-group').each(function(idx){
		var _this = $(this);
		var itm = {};
		itm.title = _this.find('.emval[cid="stitle"]').val();
		_sname = _this.find('.emval[cid="sname"]').val();
		itm.name = $.trim(_sname);
		module.column.push(itm);
	})
	return module;
}

// 读取保存已信息配置信息
var fetchHighchartColum = function(configData) {
	if (!isEmpty(configData)) {
		var cg = configData.column || '',
			cg_len = cg.length,
			html = '';
		var selector_default = {
			ssortable: ['1|是', '0|否'],
			salign: ['center|居中', 'left|左对齐', 'right|右对齐'],
			stype:['number|数字', '0|非数字']
		}
		var selector = function(option, val) {
			var str = '';
			for (var i = 0; i < option.length; i++) {
				var itm = option[i].split('|'),
					selected = itm[0] == val ? 'selected' : '';
				str += '<option value="' + itm[0] + '" ' + selected + '>' + itm[1] + '</option>'
			}
			return str;
		}

		if(cg_len>1){
			$('#setting').find('fieldset.config-group').each(function(idx){
				var _this = $(this);
				_this.find('.emval[cid="stitle"]').val(cg[idx]['title']);
				_this.find('.emval[cid="sname"]').val(cg[idx]['name']);
			})
		}
	}
}



// 对象为空
var isEmpty = function(obj){ for (var name in obj) { return false; } return true; };
