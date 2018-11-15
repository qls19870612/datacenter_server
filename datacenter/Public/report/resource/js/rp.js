var SUB_STATUS = window.parent.APP_STATUS || {};
var HELF_MODS = [];

$(function() {

	// 初始化时间
	var _interval = Number($('#rpHeader').data('interval'));
	var _start = Number($('#rpHeader').data('start'));
	SUB_STATUS.cur.sel_start_date = moment().subtract('days', _interval).format('YYYY-MM-DD');
	SUB_STATUS.cur.sel_end_date = moment().subtract('days', _start).format('YYYY-MM-DD');

	// 初始化服务器列表
	var _dsel = Number($('#rpHeader').data('defserverlist'));
	SUB_STATUS.cur.prefab_dsel = _dsel > 0 ? _dsel : 0;
	SUB_STATUS.ope.init_all_platform();
	SUB_STATUS.cur.sel_server = SUB_STATUS.ope.serverCount();

	// 初始化预设参数
	SUB_STATUS.cur.prefab_param = __initPrefabParam();


	// 报表标题初始化
	if (SUB_STATUS.cur) {
		var sel_cat_ttl = SUB_STATUS.cur.sel_cat_ttl || '',
			sel_report_ttl = SUB_STATUS.cur.sel_report_ttl || '';

		var sct = sel_cat_ttl ?  sel_cat_ttl  : '';
		var lstr = sct + '<li>' + sel_report_ttl + '</li>' ;

		_rpHeader = $('#rpHeader');
		_rpHeader.find('#curGameTitle').before(sel_report_ttl);
		_rpHeader.find('.breadcrumb').append(lstr);
	}

	// 初始化控件
	$('.report-mod').each(function() {
		var _reportMod = $(this);
		var _sqlid = _reportMod.data('sqlid') || '',
			_sqlkey = _reportMod.data('sqlkey') || '',
			_sqlc = _reportMod.data('sqlcontent') || '',
			_configStr = _reportMod.data('config') || '',
			_mtype = _reportMod.data('mtype') || '',
			_loadtype = _reportMod.data('loadtype') || '';

		var prop = {
			'sqlid': _sqlid,
			'sqlkey': _sqlkey,
			'sqlc': _sqlc,
			'mtype': _mtype,
			'configStr':_configStr
		}

		if (_loadtype == 'ajax') {
			var newMod = new __ajaxMODS(prop);
			$.extend(_reportMod, newMod);
			_reportMod.m_render();
			HELF_MODS.push(_reportMod);
		}else{
			var config_f = {};
			if(prop.configStr){
			    try{
			        config_f = JSON.parse(prop.configStr.replace(/\#\@/g, '"'));
			    }catch(e){}
			}
			if(__MODS_PARSER[prop.mtype]){
				__MODS_PARSER[prop.mtype](config_f, _reportMod);
			}
		}
	})

	// 折叠控件
	$('.ctrl-title').on('click', function(){
		var _this = $(this).parents('.panel-heading');
		_this.next('.panel-body').toggle();
	})

})

// 加载动画
var __loadDom = '<div id="iframeLoading" style="padding:24px 0 0 0;" class="row" ><div style="background: url(resource/images/GUI/loading2.gif) center top no-repeat; height: 32px;" class="loading"></div><div><p style="text-align:center;">正在加载...</p></div></div>';


// 刷新服务器选择控件
var __reFreshServerCtrl = function(idx, item_count) {
	var _pltSelBtn = $("#selectListShow button.pltSelBtn").eq(idx);
	_pltSelBtn.find('span').text(item_count);
	if (item_count == 0) {
		_pltSelBtn.removeClass('btn-primary').addClass('btn-default');
	} else {
		_pltSelBtn.removeClass('btn-default').addClass('btn-primary');
	}
}


// 数据控件扩展方法
var __ajaxMODS = function(prop) {
	var config_f = {};
	if(prop.configStr){
	    try{
	        config_f = JSON.parse(prop.configStr.replace(/\#\@/g, '"'));
	    }catch(e){}
	}
	this.m_config = config_f;
	this.m_prop = prop || {};
	this.m_render = function(){
		return __doAjax(this);
	}
}


var __doAjax = function(mod){
	if(mod.m_config){
		if(mod.m_prop.sqlc){
			var params = {
				'controller': 'ajax',
				'method': 'getdata',
				'et': SUB_STATUS.cur.sel_end_date,
				'ft': SUB_STATUS.cur.sel_start_date,
				'game': SUB_STATUS.cur.sel_game,
				'sql_id': mod.m_prop.sqlid,
				'sql_key': mod.m_prop.sqlkey
			}
			$.extend(params, SUB_STATUS.cur.sel_server);
			$.extend(params, SUB_STATUS.cur.prefab_param);
			$.ajax({
				url: SUB_STATUS.url.request,
				type: 'POST',
				data: params,
				dataType: 'json',
				beforeSend: function() {
					mod.html(__loadDom);
				},
				success: function(d) {
					if (d.code == 200) {
						var resultData = d.data;
						if (__MODS_PARSER[mod.m_prop.mtype]) {
							__MODS_PARSER[mod.m_prop.mtype](mod.m_config, mod, resultData);
						} else {
							mod.html('<p class="mod-error">配置异常</p>');
						}
					}else if(d.code == 0){
						mod.html('<p class="mod-error">SQL执行异常</p>');
					}else {
						var err_msg = d.msg;
						mod.html('<p class="mod-error">' + err_msg + '</p>');
					}
				},
				error: function(e) {
					mod.html('<p class="mod-error">数据请求失败</p>');
				}
			})
		}else{
			mod.html('<p class="mod-error">该控件没有配置SQL</p>')
		}
	}else{
		mod.html('<p class="mod-error">该控件没有配置信息</p>')
	}
	
}

// 更新ajax控件
var __renderAjaxMods = function(idx){
	var _idx = Number(idx);
	SUB_STATUS.cur.sel_server = SUB_STATUS.ope.serverCount();
	SUB_STATUS.cur.prefab_param = __getPrefabParam();
	if(idx == 999){
		for(var i=0; i<HELF_MODS.length; i++){
			HELF_MODS[i].m_render();
		}
	}else{
		if(HELF_MODS[_idx]) HELF_MODS[_idx].m_render();
	}
}

// 普通表导出
var __saveAsExcel = function(idx){
	var _idx = Number(idx);
	var _mod = HELF_MODS[_idx];
	if(HELF_MODS[_idx]){
		var head_name = [], filter_name = [];
		var _column = _mod.m_config['column']
	    for(var e in _column){
	        var itm = _column[e];
	        if(itm['cols'] && itm['cols'].length > 0){
	            for(var f in itm['cols']){
	                var subitm = itm['cols'][f];
	                if(subitm['name']){
	                    filter_name.push(subitm['name']);
	                    var ttl =  subitm['title'] || '未知项';
	                    head_name.push(ttl);
	                }
	            }
	        }else{
	            if(itm['name']){
	                filter_name.push(itm['name']);
	                var ttl =  itm['title'] || '未知项';
	                head_name.push(ttl);
	            }
	        }
	    }
		var ipt_controller = '<input type="hidden" name="controller" value="ajax">'
		, ipt_method = '<input type="hidden" name="method" value="getdata">'
		, ipt_et = '<input type="hidden" name="et" value="'+SUB_STATUS.cur.sel_end_date+'">'
		, ipt_ft = '<input type="hidden" name="ft" value="'+SUB_STATUS.cur.sel_start_date+'">'
		, ipt_game = '<input type="hidden" name="game" value="'+SUB_STATUS.cur.sel_game+'">'
		, ipt_sql_id = '<input type="hidden" name="sql_id" value="'+_mod.m_prop.sqlid+'">'
		, ipt_sql_key = '<input type="hidden" name="sql_key" value="'+_mod.m_prop.sqlkey+'">'
		, ipt_output = '<input type="hidden" name="output_excel" value="1">'
		, ipt_head_name = '<input type="hidden" name="output_head_names" value="'+head_name.join(',')+'">'
		, ipt_filter_name = '<input type="hidden" name="output_filter_names" value="'+filter_name.join(',')+'">'
		, ipt_sid = ''
		, ipt_prefab = '';


		var sel_server = SUB_STATUS.cur.sel_server;
		for(var g in sel_server){
			ipt_sid += '<input type="hidden" name="'+g+'" value="'+sel_server[g]+'">';
		}

		var prefab_param = SUB_STATUS.cur.prefab_param;
		for(var p in prefab_param){
			ipt_prefab += '<input type="hidden" name="'+p+'" value="'+prefab_param[p]+'">';
		}

		var saveAsExcelForm = '<form id="saveAsExcelForm" action="'+SUB_STATUS.url.request+'" method="post" target="_blank" style="display:none">'+ipt_controller+ipt_method+ipt_et+ipt_ft+ipt_game+ipt_sql_id+ipt_sql_key+ipt_output+ipt_head_name+ipt_filter_name+ipt_sid+ipt_prefab+'</form>'
		$('#saveAsExcelForm').remove();
		$(saveAsExcelForm).appendTo('body').submit();
	}
	
}


// 转置表导出
var __saveAsExcelzz = function(idx){
	var _idx = Number(idx);
	var _mod = HELF_MODS[_idx];
	if(HELF_MODS[_idx]){
		var head_name = [], filter_name = [];
		var _column = _mod.m_config['column']
	    var z_first = _column[0]['title'];
	    var z_group = _column[0]['name'];
	    var z_sub = _column[1]['title'];
	    var z_data = _column[1]['name'];


		var ipt_controller = '<input type="hidden" name="controller" value="ajax">'
		, ipt_method = '<input type="hidden" name="method" value="getdata">'
		, ipt_et = '<input type="hidden" name="et" value="'+SUB_STATUS.cur.sel_end_date+'">'
		, ipt_ft = '<input type="hidden" name="ft" value="'+SUB_STATUS.cur.sel_start_date+'">'
                , ipt_ett = '<input type="hidden" name="ett" value="'+SUB_STATUS.cur.prefab_param.ett+'">'
                , ipt_ftt = '<input type="hidden" name="ftt" value="'+SUB_STATUS.cur.prefab_param.ftt+'">'
		, ipt_game = '<input type="hidden" name="game" value="'+SUB_STATUS.cur.sel_game+'">'
		, ipt_sql_id = '<input type="hidden" name="sql_id" value="'+_mod.m_prop.sqlid+'">'
		, ipt_sql_key = '<input type="hidden" name="sql_key" value="'+_mod.m_prop.sqlkey+'">'
		, ipt_output = '<input type="hidden" name="output_excel" value="1">'

		, ipt_name = '<input type="hidden" name="output_tasikmalaya_name" value="'+z_sub+'">'
		, ipt_group_name = '<input type="hidden" name="output_tasikmalaya_group_name" value="'+z_group+'">'
		, ipt_group_head_name = '<input type="hidden" name="output_tasikmalaya_group_head_name" value="'+z_first+'">'
		, ipt_data_name = '<input type="hidden" name="output_tasikmalaya_data_name" value="'+z_data+'">'

		, ipt_sid = '';

		var sel_server = SUB_STATUS.cur.sel_server;
		for(var g in sel_server){
			ipt_sid += '<input type="hidden" name="'+g+'" value="'+sel_server[g]+'">';
		}

		var saveAsExcelForm = '<form id="saveAsExcelForm" action="'+SUB_STATUS.url.request+'" method="post" target="_blank" style="display:none">'+ipt_controller+ipt_method+ipt_et+ipt_ft+ipt_game+ipt_sql_id+ipt_sql_key+ipt_output+ipt_name+ipt_group_name+ipt_group_head_name+ipt_data_name+ipt_sid+ipt_ett+ipt_ftt+'</form>'
		$('#saveAsExcelForm').remove();
		$(saveAsExcelForm).appendTo('body').submit();
	}
	
}

// 统计图导出
var __saveAsChart = function(idx){
	var _idx = Number(idx);
	var _mod = HELF_MODS[_idx];
	var _width_s = _mod.data('area') || 12;
	var _width = Number(_width_s)
	_mod.highcharts().exportChart({
		width:_width*150,
		sourceWidth:_width*100,
		sourceHeight:400,
        url:'http://115.239.231.9:8089/hsem/SaveAsImage'
    });
}

// 预设参数初始化
var __initPrefabParam = function(){
	var _param = {};
	$('div.report-mod[data-mtype="parameter"]').each(function(){
		var _parameter = $(this);
		var configStr = _parameter.data('config'),config_f = {};
		if(configStr){
		    try{
		        config_f = JSON.parse(configStr.replace(/\#\@/g, '"'));
		    }catch(e){}
		    if(config_f.parameter && config_f.parameter.length > 0){
		    	for(var i=0; i<config_f.parameter.length; i++){
		    		var _name = config_f.parameter[i].name;
		    		var _value = config_f.parameter[i].value;
		    		var _type = config_f.parameter[i].type;
		    		_param[_name] = _type == 'datepicker' ? moment().add('days', _value).format('YYYY-MM-DD') : _value;
		    	}
		    }
		}
	});
	return _param;
}

// 获取新的预设参数
var __getPrefabParam = function(){
	var _param = {};
	$('div.report-mod[data-mtype="parameter"]').each(function(){
		var _parameter = $(this);
		_parameter.find('.form-control').each(function(){
			var _fc = $(this);
			var _name = _fc.data('parameter');
			if(_name){
				var _value = _fc.val() || '';
				var _value_f = $.trim(_value);
				var _value_f_reg = _value_f.replace(/select|update|delete|truncate|join|union|exec|inse rt|drop|count|'|"|;|>|<|%/ig, '');
    			_param[_name] = _value_f_reg;
    			_fc.val(_value_f_reg);
			}
		})
	});
	return _param;
}




