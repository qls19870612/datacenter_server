var SUB_STATUS = window.parent.APP_STATUS || {};
var HELF_MODS = [];

$(function(){

	// 初始化时间
	var _interval = Number($('#rpHeader').data('interval'));
	SUB_STATUS.cur.sel_start_date = moment().subtract('days', _interval-1).format('YYYY-MM-DD')+' 00:00:00';
	SUB_STATUS.cur.sel_end_date = moment().format('YYYY-MM-DD')+' 23:59:59';;

	// 初始化服务器列表
	SUB_STATUS.ope.init_all_platform();
	SUB_STATUS.cur.sel_server = SUB_STATUS.ope.serverCount();

	// 报表标题初始化
	if (SUB_STATUS.cur) {
		var sel_cat_ttl = SUB_STATUS.cur.sel_cat_ttl || '',
			sel_report_ttl = SUB_STATUS.cur.sel_report_ttl || '';

		var sct = sel_cat_ttl ? '<li>' + sel_cat_ttl + '</li>' : '';
		var lstr = sct + '<li>' + sel_report_ttl + '</li>';

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

		if (_loadtype == 'static'){
			var config_f = {};
			if(prop.configStr){
			    try{
			        config_f = JSON.parse(prop.configStr.replace(/\#\@/g, '"'));
			    }catch(e){}
			}
			__MODS_PARSER[prop.mtype](config_f, _reportMod);
		}
	})

	__renderAjaxMods(999);
	
})


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

