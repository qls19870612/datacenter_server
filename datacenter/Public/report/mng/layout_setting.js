$(function() {
	// 初始化
	initLayout();
	
	$('#layoutPreview').on('click', '.report-remove, .report-setting', function() {
		var _this = $(this);
		if(_this.hasClass('report-remove')){
			if(!_this.attr('disabled')){
				var _parent = _this.parents('.colm');
				_parent.remove();
			}
		}else if(_this.hasClass('report-setting')){
			var _pa = _this.parents('.colm');
			var suid = _pa.data('suid');
			var mtype = _pa.data('mtype');
			var rp_title= $('#layoutPreview').data('title') || '';
			var mtitle = _pa.find('.report-title').val() || '';
			window.location = __detal_setting_url+'?sql_key='+__cid+'&suid='+suid+'&mtype='+mtype+'&mtitle='+mtitle+'&rp_title='+rp_title;
		}
	}).on('change', '.report-area', function() {
		renderAllAera();
	})

	$('#contorler').on('click', 'button', function(){
		var _this = $(this);
		var _id = _this.attr('id');
		switch(_id){
			case 'addgrid':
				addGrid();
			break
			case 'losBtn':
				saveLayoutConfig();
			break
			case 'lodBtn':
				window.location = window.location;
			break
			case 'changeModeBtn':
				changeModel();
			break
		}
	}).on('change', '#mtypeSelect', function(){
		var _this = $(this);
		var mtype = _this.val();
		var def_area = moduleBoxType[mtype].s_area;
		if(def_area > 0){
			$('#colSelect').val(def_area).attr('disabled', 'disabled');
		}else{
			$('#colSelect').removeAttr('disabled');
		}
	})
	$('#mtypeSelect').trigger('change');
})



var moduleBoxType = {
	"empty" : {
		"s_area":0,
		"height":400,
		"loadtype":"static",
		"title":"空"
	},
    "datepicker" :{
		"s_area":4,
		"height":50,
		"loadtype":"static",
		"title":"日期选择"
	},
    "serverlist" :{
		"s_area":4,
		"height":50,
		"loadtype":"static",
		"title":"服务器选择"
	},
    "parameter" :{
		"s_area":4,
		"height":50,
		"loadtype":"static",
		"title":"参数筛选"
	},
    "mmgrid" :{
		"s_area":0,
		"height":400,
		"loadtype":"ajax",
		"title":"普通表"
	},
    "highchart" :{
		"s_area":0,
		"height":400,
		"loadtype":"ajax",
		"title":"线柱图"
	},
	"highchartpie" :{
		"s_area":0,
		"height":400,
		"loadtype":"ajax",
		"title":"饼形图"
	},
	"highchartgauge" :{
		"s_area":0,
		"height":400,
		"loadtype":"ajax",
		"title":"仪表盘"
	},
	"mmgridspec" :{
		"s_area":0,
		"height":400,
		"loadtype":"ajax",
		"title":"转置表"
	}
}


// 测试
var __cid = $('#layoutPreview').data('cid') || '';
var __title = $('#layoutPreview').data('title') || '';
var __detal_setting_url = location.href.substring(0,location.href.lastIndexOf('/')) + '/detail_setting.php';


var moduleBox =  function(prop, active){
	var modbox = moduleBoxType[prop.mtype],
	_class = active ? '' : 'colm-fixed',
	_remove = active ? '' : 'style="display:none"',
	_setting = active ? 'style="display:none"' : '',
	_edit = active ? '' : 'disabled="disabled"';
	_height = prop.height || modbox.height;
	_title = prop.title || modbox.title;

	if(modbox.s_area > 0){
		return '<div data-mtype="'+prop.mtype+'" data-height="'+modbox.height+'" data-defaultarea="'+modbox.s_area+'" data-suid="'+prop.suid+'" class="colm '+_class+' col4-'+modbox.s_area+' col-sh" style="height:50px"><div class="colWrap-l"><p>控件标题：<input type="text" value="'+_title+'" class="report-title" '+_edit+'><span class="gray">控件类型：'+modbox.title+'</span><input type="hidden" class="report-area" value="4"><input type="hidden" value="50" class="report-height">&nbsp;&nbsp;<button class="report-setting" '+_setting+'>&nbsp;设置&nbsp;</button><button class="report-remove" '+_remove+'>删除</button></p></div></div>';
	}else{
		return '<div data-mtype="'+prop.mtype+'" data-height="'+modbox.height+'" data-defaultarea="'+prop.area+'" data-suid="'+prop.suid+'" class="colm '+_class+' col4-'+prop.area+'"><div class="colWrap"><p>控件标题：<input type="text" value="'+_title+'" class="report-title" '+_edit+'><span class="gray">'+modbox.title+'</span></p><p>宽度：<select class="report-area" '+_edit+'><option value="1">1网格</option><option value="2">2网格</option><option value="3">3网格</option><option value="4">4网格</option></select>&nbsp;&nbsp;&nbsp;&nbsp;高度：<input type="text" value="'+_height+'" class="report-height" '+_edit+' style="width:60px"></p><p><button class="report-setting" '+_setting+'>&nbsp;设置&nbsp;</button><button class="report-remove" '+_remove+'>删除</button></p></div></div>';
	}

}


// suid生成   
var newSuid = function () 
{   
	function S4() 
	{   
	   return (((1+Math.random())*0x10000)|0).toString(16).substring(1);   
	} 
	return (S4()+"-"+S4()+S4()); 
}
// 初始化布局
var initLayout = function(){
	var _layout = $('#layoutPreview').data('layout') || '';
	if($.trim(_layout)){
		var groupArr = _layout.split('%'), html = '', prop = {};
		for(var i=0; i<groupArr.length; i++){
			var itemArr = groupArr[i].split('|');
			prop.area = itemArr[0] || '';
			prop.height = itemArr[1] || '';
			prop.mtype = itemArr[2] || '';
			prop.title = itemArr[3] || ''; 
			prop.suid = itemArr[4] || '';
			html += moduleBox(prop, 0);
		}
		$('#layoutPreview').html(html);
		$('#layoutPreview').find('.colm').each(function() {
			var _this = $(this);
			var d_area = _this.data('defaultarea') || '';
			_this.find('select.report-area').val(d_area);
		});
	}
}

// 增加控件
var addGrid = function(){
	var _this = $(this);
	if(!_this.attr('disabled')){
		var cVal = $('#colSelect').val(), html='', prop = {};

		prop.area = cVal || 1;
		prop.height = '';
		prop.title = '';
		prop.mtype = $('#mtypeSelect').val();
		prop.suid = newSuid();		

		html += moduleBox(prop, 1);
		
		$(html).appendTo('#layoutPreview').find('select.report-area').val(cVal);
	}
}

// 刷新网格视图
var renderAllAera = function(){
	$('#layoutPreview').children('div.colm').each(function(){
		var _colm = $(this);
		var cur = _colm.find('.report-area').val();
		if(cur){
			var newArea = 'col4-' + cur;
			_colm.removeClass('col4-1 col4-2 col4-3 col4-4').addClass(newArea);
		}
		
	})
}

// 切换类型
var changeModel = function(){
	var _layoutPreview = $('#layoutPreview'), _contorler = $('#contorler');
	_layoutPreview.find('.colm').removeClass('colm-fixed');
	_layoutPreview.find('.report-title').removeAttr('disabled');
	_layoutPreview.find('.report-area').removeAttr('disabled');
	_layoutPreview.find('.report-height').removeAttr('disabled');
	_layoutPreview.find('.report-setting').hide();
	_layoutPreview.find('.report-remove').show();
	_layoutPreview.sortable({ connectWith: "div.colm" });
	_contorler.find('.layoutCWrap').show();
	_contorler.find('.detailCWrap').hide();
	$('#reportProp').find('span.rpspn').hide();
	$('#reportProp').find('input.rpipt').show();
}

// 保存布局
var saveLayoutConfig = function(){
	var _layoutPreview = $('#layoutPreview'), configArr=[], suidArr=[], configStr, suidStr;
	_layoutPreview.find('div.colm').each(function(){
		var _colm = $(this);
		var area = _colm.find('.report-area').val() || ''
		, height_tmp = Number(_colm.find('.report-height').val()) || 0
		, mtype = _colm.data('mtype') || ''
		, title = _colm.find('input.report-title').val() || ''
		, suid = _colm.data('suid') || ''
		, loadtype = moduleBoxType[mtype].loadtype;
		height = (!isNaN(height_tmp) && height_tmp >= 50) ? parseInt(height_tmp) : 400;
		var tmp = area+'|'+height+'|'+mtype+'|'+title+'|'+suid+'|'+loadtype;
		configArr.push(tmp);
		suidArr.push(suid);
	})
	configStr = configArr.join('%');
	suidStr = suidArr.join('%');
	$('#formConfig').val(configStr);
	$('#formRm').val(suidStr);

	var rp_title = $('#reportProp').find('input.report-ttl').val();
	var rp_interval = $('#reportProp').find('input.report-itv').val();
	var rp_start = $('#reportProp').find('input.report-str').val();
	var rp_list = $('#reportProp').find('input.report-slt').val();
	$('#formTitle').val(rp_title);
	$('#formInterval').val(rp_interval);
	$('#formStart').val(rp_start);
	$('#formServerList').val(rp_list);


	$('#saveForm').submit();
}

