// 配置解析器
var __MODS_PARSER = {
	empty: function(config, $target) {
		$target.parents('.panel-primary').css({
			'visibility': 'hidden'
		});
	},
	datepicker: function(config, $target) {
		var _timePicker = (config.dptimepick && Number(config.dptimepick) < 3) ? Number(config.dptimepick) : 0;
		var _format = 'yyyy-mm-dd', _format_m = 'YYYY-MM-DD';
		if(_timePicker == 1){_format = 'yyyy-mm'; _format_m = 'YYYY-MM'}else if(_timePicker == 2){_format = 'yyyy'; _format_m = 'YYYY'};
		var _sdom = '<div class="controls clearfix" style="padding:8px 8px"><div id="datepicker" class="input-group date pull-left" style="width:200px"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span><input type="text" class="form-control" name="start" value="'+moment(SUB_STATUS.cur.sel_start_date).format(_format_m)+'"></div><button type="button" class="btn btnfm btn-default pull-right" data-btntype="upDateIframe" onclick="__renderAjaxMods(999)" style="margin:0">查询</button></div>'
		var _ddom = '<div class="controls clearfix" style="padding:8px 8px"><div class="input-daterange input-group pull-left" id="datepicker"><input type="text" class="input form-control" name="start" value="'+moment(SUB_STATUS.cur.sel_start_date).format(_format_m)+'" style="width:120px" /><span class="input-group-addon">-</span><input type="text" class="input form-control" name="end" value="'+moment(SUB_STATUS.cur.sel_end_date).format(_format_m)+'" style="width:120px" /></div><button type="button" class="btn btnfm btn-default pull-right" data-btntype="upDateIframe" onclick="__renderAjaxMods(999)" style="margin:0">查询</button></div>';
		var _dom = (config.dpmethod && Number(config.dpmethod)>0) ? _sdom : _ddom;

		$target.html(_dom).find('#datepicker').datepicker({
			'autoclose':1,
			'orientation': "top auto",
			'format':_format,
			'keyboardNavigation':0,
			'language':'zh-CN',
			'minViewMode':_timePicker,
			'todayBtn':'linked',
			// 'startDate':SUB_STATUS.cur.sel_start_date,
			'endDate':SUB_STATUS.cur.sel_end_date
		}).on('changeDate', function(){
			var _this = $(this);
			var _start =  _this.find('input[name="start"]').val() || SUB_STATUS.cur.sel_start_date;
			var _end = _this.find('input[name="end"]').val() || SUB_STATUS.cur.sel_end_date;
			var _start_m = moment(_start).format('YYYY-MM-DD');
			var _end_m = moment(_end).format('YYYY-MM-DD');
			SUB_STATUS.cur.sel_start_date = _start_m;
			SUB_STATUS.cur.sel_end_date = _end_m;
		})
		
	},
	serverlist: function(config, $target) {
		var gameServer = SUB_STATUS.cur.game_server || [];
		var dsel = SUB_STATUS.cur.prefab_dsel;
		var dom = '',
			gameServerList = '',
			spn = '全',
			cls = 'btn-primary';
		if (gameServer.length > 0) {
			for (var i in gameServer) {
				if(dsel > 0 && dsel <= i){spn = '0'; cls = 'btn-default';}
				gameServerList += '<button type="button" class="btn btnfm '+cls+' pltSelBtn" data-btntype="serverAllSelect" data-plt="' + gameServer[i] + '">' + gameServer[i] + '(<span>'+spn+'</span>)</button>';
			}
			var dom = '<div id="selectListShow"><div class="controls" style="padding:8px 8px 0 8px"><div class="btn-group">' + gameServerList + '</div>&nbsp;&nbsp;&nbsp;&nbsp;<div class="btn-group"><button type="button" class="btn btnfm btn-default" data-btntype="platformAllSelect">全选</button><button type="button" class="btn btnfm btn-default" data-btntype="detailSelect">细选</button></div><button type="button" class="btn btnfm btn-default pull-right" data-btntype="upDateIframe" onclick="__renderAjaxMods(999)">查询</button></div></div>';
			$target.html(dom).on('click', 'button', function() {
				var _this = $(this);
				if (_this.data('btntype') == 'detailSelect') {
					SUB_STATUS.ope.serverListShow();
				} else if (_this.data('btntype') == 'serverAllSelect') {
					var plt = _this.data('plt');
					SUB_STATUS.ope.select_all_server(plt);
				} else if (_this.data('btntype') == 'platformAllSelect') {
					SUB_STATUS.ope.select_all_platform();
				}
			});
		} else {
			$target.html('<div id="selectListShow"><p style="text-align: center; line-height: 48px">没有服务器列表</p></div>')
		}
	},
	highchart: function(config, $target, data) {
		var _config = config,
			_data = data,
			xkey = _config.xkey || '';
		if (xkey) {
			_config.exporting = {enabled:false};
			_config.xAxis = [];
			_config.xAxis[0] = {
				categories: []
			};
			_config.xAxis[0].categories = __highchartPluck(data, xkey)
		}
		if (_config.series && _config.series.length > 0) {
			for (var i in _config.series) {
				var key = _config.series[i].key;
				_config.series[i].data = __highchartPluck(data, key);
			}

			__addExportButton($target, 'saveAsChart');
		
			$target.highcharts(_config);
		} else {
			$target.html('<p class="mod-error">数据异常</p>');
		}
	},
	highchartpie: function(config, $target, data) {
		var _config = config,
			_data = data,
			series_data = [];
		_config.exporting = {enabled:false};
		var keyArr = _config.series[0].key.split('|');
		var optionName = keyArr[0],
			optionData = keyArr[1];
		for (var itm in _data) {
			var sitm = [];
			sitm[0] = _data[itm][optionName] || '';
			sitm[1] = Number(_data[itm][optionData]) || 1;
			series_data.push(sitm);
		}
		if (series_data.length > 0 && series_data[0][0] != '' && series_data[0][1] != '') {
			_config.series[0].data = series_data;

			__addExportButton($target, 'saveAsChart');

			$target.highcharts(_config);
		} else {
			$target.html('<p class="mod-error">数据异常</p>');
		}
	},
	highchartgauge: function(config, $target, data) {
		var _config = config,
			_data = data,
			_completeKey = _config.series[0].completedkey || '',
			_complete = _data[0][_completeKey] || 0,
			_complete_f = Number(_complete),
			_totalkey = _config.series[0].totalkey || '',
			_total = _data[0][_totalkey] || 0,
			_total_f = Number(_total);

		_config.exporting = {enabled:false};
		var _gauge = Math.round(_complete_f / _total_f * 10000) / 100;
		if (_gauge > 0) {
			_config.yAxis.title.text = _total_f;
			_config.series[0].data[0] = _gauge;

			__addExportButton($target, 'saveAsChart');

			$target.css({width:'98%'}).highcharts(_config).find('g.highcharts-data-labels').css({'visibility':'visible'});
		} else {
			$target.html('<p class="mod-error">数据异常</p>');
		}
	},
	mmgrid: function(config, $target, data) {
		var _config = {}
		_config.height = $target.css("height");
		_config.cols = config.column;
		_config.pgInv = config.paging || 0;
		_config.items = data;

		__addExportButton($target, 'saveAsExcel');

		$target.html('<div class="temp"></div>');
		$target.find('.temp').mmGrid(_config);
	},
	mmgridspec: function(config, $target, data) {
		var colmsp =  config.column;

		__addExportButton($target, 'saveAsExcelzz');
		var height = $target.height();

		var _dom = __mmgridspecPluck(data, colmsp, height);
		
		$target.html(_dom);
	},
	parameter: function(config, $target){
		var _config = config;
		var _parameter = _config.parameter;
		var _parameterLen = _parameter.length;

		if(_parameterLen > 0){
			var _parameterDom = '<div style="padding:0 10px" class="row">'
			for(var i=0; i<_parameterLen+1; i++){
				if(i!=0 && i%4 == 0){
					_parameterDom += '</div><div style="padding:0 20px" class="row">';
				}
				if(i != _parameterLen){
					var pv =  _parameter[i].type == 'datepicker' ? moment().add('days', _parameter[i].value).format('YYYY-MM-DD') : _parameter[i].value;

					_parameterDom += '<div class="input-group col-md-3" style="padding-top:10px"><span class="input-group-addon">'+_parameter[i].title+'</span><input type="text" class="form-control pm-'+_parameter[i].type+'" value="'+pv+'" data-parameter="'+_parameter[i].name+'"></div>';
					
				}else{
					_parameterDom += '<button onclick="__renderAjaxMods(999)" data-btntype="upDateIframe" class="btn btnfm btn-default pull-right" type="button" style="margin:10px 13px">查询</button>';
				}
			}
			_parameterDom += '</div>';
			$target.html(_parameterDom).find('input.pm-datepicker').datepicker({format: 'yyyy-mm-dd','autoclose':1});
		}else{
			$target.html('<p class="mod-error">没有可用参数</p>');
		}
	}
}


// 数组提取属性
var __highchartPluck = function(collection, key) {
	var col = collection,
		k = key,
		res = [];
	for (var j in col) {
		var itm = col[j],
			itmn = Number(itm[k]);
		val = isNaN(itmn) ? itm[k] : itmn;
		res.push(val)
	}
	return res;
}

var __mmgridspecPluck = function(data, colmsp, height) {
	var _dom = {}; _data = [], _colm = [], _colmTmp = {};
	var _height = height || 400;
	var colmtmp = function(){};
	colmtmp.prototype = colmsp[1];
	var ydim = colmsp[0].name, xdim = colmsp[1].title, occur = colmsp[1].name;
	_colm[0] = colmsp[0].title, firstColm = colmsp[0].name;

	for(var i=0; i<data.length; i++){
		var ydimv = data[i][ydim];
		var xdimv = data[i][xdim];
		var occurv = data[i][occur];
		var notExist = 1;
		for(var j=0; j<_data.length; j++){
			if(_data[j][ydim] == ydimv){
				var n_occurv = Number(occurv);
				_data[j][xdimv] = isNaN(n_occurv) ? occurv : n_occurv;
				_colmTmp[ydimv].push(xdimv);
				notExist = 0;
				break;
			}
		}
		if(notExist){
			var tmp = {};
			tmp[ydim] = ydimv;
			var n_occurv = Number(occurv);
			tmp[xdimv] = isNaN(n_occurv) ? occurv : n_occurv;
			_data.push(tmp);
			_colmTmp[ydimv] = [];
			_colmTmp[ydimv].push(xdimv);
		}
		var inColm = 0;
		for(var k=0; k<_colm.length; k++){
			if(_colm[k] == xdimv){
				inColm = 1;
				break;
			}
		}
		if(!inColm) _colm.push(xdimv);
	}

	_dom = '<div class="responsive-default" style="height: '+_height+'px; overflow: auto;"><table class="table table-bordered">'+__setTabHeader(_colm) + __setTabBody(_data, _colm, firstColm);+'</table></div>';

	function __setTabHeader(harr){
		var hdata= harr, hstr = '';
		for(var i=0; i<hdata.length; i++){
			hstr += '<th>'+hdata[i]+'</th>';
		}
		return '<thead><tr>'+hstr+'</tr></thead>';
	}

	function __setTabBody(barr, harr, firstColm){
		var bdata= barr, hdata= harr, bstr = '';
		for(var i=0; i<bdata.length; i++){
			var row = bdata[i], rowStr = '<td>'+(row[firstColm] || '')+'</td>';
			for(var j=1; j<hdata.length; j++){
				rowStr += '<td>'+(row[hdata[j]] || '')+'</td>';
			}
			bstr += '<tr>'+rowStr+'</tr>';
		}
		return '<tbody>'+bstr+'</tbody>';
	}

	return _dom;
}


var __addExportButton = function(target, events){
	var $target = target;
	var _ptitle = $target.parents('.panel-primary').find('.panel-title');
	if(_ptitle.find('.saveexcel').length <= 0){
		var _pidx = _ptitle.data('ajaxmodsindex');
		var _saeb =  '<span onclick="__'+events+'('+_pidx+')" style="float:right;margin-right:16px" class="ctrl-icon glyphicon glyphicon-save saveexcel">';
		_ptitle.append(_saeb);
	}
}

var __feedTime = function(str){
	var str_len = str.length;
	if(str_len == 4){
		str += '-01-01';
	}else if(str_len == 7){
		str += '-01';
	}
	return str;
} 

