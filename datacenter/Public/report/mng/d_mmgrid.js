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
		if($('#setting').find('input.paging:checked').length>0){
			var pgNum = $('#setting').find('input.pageRows').val() || 0;
			pgNum = Number(pgNum);
			json.paging = pgNum;
		};
		var jsonStr = JSON.stringify(json);
		var jsonStr_f = jsonStr.replace(/\#\@/g, '').replace(/\"/g, '#@');
		$('#configStr').val(jsonStr_f);
		$('#configSql').val($('#sqlContent').val());
		$('#configSqlp').val($('#sqlContentp').val());
		$('#detailSettingSave').submit();
		// console.log(jsonStr_f)
	})

	// 表单操作
	$('#setting').on('click', 'button', function() {
		var _this = $(this);
		var target = _this.data('target') || '',
			optype = _this.data('optype') || '',
			dom = itemsDom(target);
		if (optype == 'add') {
			if (target == 'subColumn') {
				var _elm = _this.parent('fieldset.config-group');
			} else if (target == 'column' || target == 'collection') {
				var _elm = _this.parent('fieldset.config-wrap').find('.setting-wrap');
			}
			_elm.append(dom);
		} else if (optype == 'remove') {
			var _elm = _this.parent('fieldset');
			_elm.remove();
		} else if (optype == 'fmup'){
			var _elm = _this.parent('div').parent('fieldset'), _preElm;
			if(_elm.hasClass('config-group')){
				_preElm = _elm.prev('fieldset.config-group');
			}else{
				_preElm = _elm.prev('fieldset.config-children');
			}
			if(_preElm.length > 0){
				_preElm.before(_elm);
				_elm.hide().slideDown(400);
			}
		} else if (optype == 'fmdown'){
			var _elm = _this.parent('div').parent('fieldset'), _preElm;
			if(_elm.hasClass('config-group')){
				_preElm = _elm.next('fieldset.config-group');
			}else{
				_preElm = _elm.next('fieldset.config-children');
			}
			if(_preElm.length > 0){
				_preElm.after(_elm);
				_elm.hide().slideDown(400);
			}
		}
		renderAllNum();
	})

	
	// 恢复设置
	$('#refresh').on('click', function(){
		window.location = window.location;
	})

	
})

// 全局对象 
var DC_CHART_CONFIG;


var Option = function(name, type, def, option, func){
	this.name = name || '项目';
	this.type = type || 'text';
	this.def = def || '';
	this.option = option || [];
	this.func = func;
}


// 输出配置信息
var getHighchartColum = function() {
	var module = {
		column: []
	};
	var column = [];
	$('#column').find('fieldset.config-group').each(function() {
		var _configGroup = $(this),
			_type = _configGroup.data('type'),
			itm = {};
		if (_type == 'column') {
			itm = itemsRender(_configGroup);
		} else if (_type == 'collection') {
			var title = _configGroup.find('[cid="ftitle"]').val();
			var align = _configGroup.find('[cid="falign"]').val();
			itm.title = title;
			itm.align = align;
			itm.cols = [];
			_configGroup.find('fieldset.config-children').each(function() {
				var _children = $(this),
					itmm;
				itmm = itemsRender(_children);
				itm.cols.push(itmm)
			})
		}
		column.push(itm);
	})
	module.column = column;

	function itemsRender($obj) {
		var itmTmp = {}, _target = $obj;
		var title = _target.find('[cid="stitle"]').val();
		var sortable = _target.find('[cid="ssortable"]').val();
		var align = _target.find('[cid="salign"]').val();
		var name = _target.find('[cid="sname"]').val() || '';
		name = $.trim(name);
		var type = _target.find('[cid="stype"]').val();
		var srenderer = _target.find('[cid="srenderer"]:checked').val() || '';
		itmTmp.title = title;
		itmTmp.sortable = sortable;
		itmTmp.align = align;
		itmTmp.name = name;
		itmTmp.type = type;
		if(srenderer) itmTmp.renderer = srenderer;
		return itmTmp;
	}
	return module;
}

// 读取保存已信息配置信息
var fetchHighchartColum = function(configData) {
	if (!isEmpty(configData)) {
		var cg = configData.column || '',
			cg_len = cg.length,
			html = '',
			pg = configData.paging ? Number(configData.paging) : 0 ;
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

		var outPutItem = function(arr, idx) {
			var subCg = arr,
				subCg_len = subCg.length,
				subHtml = '';
			for (var j = 0; j < subCg_len; j++) {
				var itmm = subCg[j],
					tmpStr = ''
				var stitle = itmm.title || '',
					sname = itmm.name || '',
					ssortable = itmm.sortable || '',
					salign = itmm.align || '',
					stype = itmm.type || '',
					srenderer = itmm.renderer || '';
				var rendererChecked = srenderer ? 'checked="checked"' : '';
				tmpStr += '<fieldset class="config-children" data-type="subColumn"><legend><span class="cCount">' + idx + '</span>-<span class="sCount">' + (j + 1) + '</span></legend><div style="top: 0px; position: absolute; right: 40px;"><button class="fmupBtn" data-optype="fmup">上移</button>&nbsp<button class="fmdownBtn" data-optype="fmdown">下移</button></div><p class="config-itm">标题：<input class="emval" cid="stitle" type="text" value="' + stitle + '"></p><p class="config-itm">类型：<select class="emval" cid="stype">'+selector(selector_default.stype, stype)+'</select>&nbsp;&nbsp;百分比<input class="emval" cid="srenderer" type="checkbox" value="percentage" '+rendererChecked+'></p><p class="config-itm">可排序：<select class="emval" cid="ssortable">' + selector(selector_default.ssortable, ssortable) + '</select></p><p class="config-itm">对齐：<select class="emval" cid="salign">' + selector(selector_default.salign, salign) + '</select></p><p class="config-itm">键名：<input class="emval" cid="sname" type="text" value="' + sname + '"><span class="remark">用于关联数据</span></p><button class="removeBtn" data-optype="remove" data-target="subColumn">删除</button></fieldset>';
				subHtml += tmpStr;
			}
			return subHtml;
		}

		if(pg > 0){
			$('#setting').find('input.paging').trigger('click');
			$('#setting').find('input.pageRows').val(pg);
		}


		for (var i = 0; i < cg_len; i++) {
			var itm = cg[i],
				idx = i + 1,
				tmpStr = ''
			if (!itm.cols) {
				var stitle = itm.title || '',
					sname = itm.name || '',
					ssortable = itm.sortable || '',
					salign = itm.align || '',
					stype = itm.type || '',
					srenderer = itm.renderer || '';
				var rendererChecked = srenderer ? 'checked="checked"' : '';
				tmpStr += '<fieldset class="config-group" data-type="column"><legend>序号：<span class="count">' + idx + '</span></legend><div style="top: 0px; position: absolute; right: 40px;"><button class="fmupBtn" data-optype="fmup">上移</button>&nbsp<button class="fmdownBtn" data-optype="fmdown">下移</button></div><p class="config-itm">标题：<input class="emval" cid="stitle" type="text" value="' + stitle + '"></p><p class="config-itm">类型：<select class="emval" cid="stype">'+selector(selector_default.stype, stype)+'</select>&nbsp;&nbsp;百分比<input class="emval" cid="srenderer" type="checkbox" value="percentage" '+rendererChecked+'></p><p class="config-itm">可排序:<select class="emval" cid="ssortable">' + selector(selector_default.ssortable, ssortable) + '</select></p><p class="config-itm">对齐：<select class="emval" cid="salign">' + selector(selector_default.salign, salign) + '</select></p><p class="config-itm">键名：<input class="emval" cid="sname" type="text" value="' + sname + '"><span class="remark">用于关联数据</span></p><button class="removeBtn" data-optype="remove" data-target="column">删除</button></fieldset>';
			} else {
				var stitle = itm.title || '',
					salign = itm.align || '',
					scols = itm.cols || '';
				tmpStr += '<fieldset class="config-group" data-type="collection"><legend>序号:<span class="count">' + idx + '</span>(GROUP)</legend><div style="top: 0px; position: absolute; right: 40px;"><button class="fmupBtn" data-optype="fmup">上移</button>&nbsp<button class="fmdownBtn" data-optype="fmdown">下移</button></div><p class="config-itm">分组标题：<input class="emval" cid="ftitle" type="text" value="' + stitle + '"></p><p class="config-itm">分组对齐：<select class="emval" cid="falign">' + selector(selector_default.salign, salign) + '</select></p><button class="addBtn" data-optype="add" data-target="subColumn">组中增加列</button><button class="removeBtn" data-optype="remove" data-target="collection">删除组</button>';
				tmpStr += outPutItem(scols, idx);
				tmpStr += '</fieldset>';
			}
			html += tmpStr;
		}
		$('#setting').find('.setting-wrap').html(html);
	}
}


/* 操作类函数 */
// 选择要增加的元素DOM
var itemsDom = function(target) {
	var str = '';
	switch (target) {
		case 'column':
			str += '<fieldset class="config-group" data-type="column"><legend>序号：<span class="count"></span></legend><div style="top: 0px; position: absolute; right: 40px;"><button class="fmupBtn" data-optype="fmup">上移</button>&nbsp<button class="fmdownBtn" data-optype="fmdown">下移</button></div><p class="config-itm">标题：<input class="emval" cid="stitle" type="text" value="列标题"></p><p class="config-itm">类型:<select class="emval" cid="stype"><option value="number">数字</option><option value="0">非数字</option></select>&nbsp;&nbsp;百分比<input class="emval" cid="srenderer" type="checkbox" value="percentage"></p><p class="config-itm">可排序:<select class="emval" cid="ssortable"><option value="1">是</option><option value="0">否</option></select></p><p class="config-itm">对齐：<select class="emval" cid="salign"><option value="center">居中</option><option value="left">左对齐</option><option value="right">右对齐</option></select></p><p class="config-itm">键名：<input class="emval" cid="sname" type="text" value="key"><span class="remark">用于关联数据</span></p><button class="removeBtn" data-optype="remove" data-target="column">删除</button></fieldset>';
			break;
		case 'collection':
			str += '<fieldset class="config-group" data-type="collection"><legend>序号:<span class="count"></span>(GROUP)</legend><div style="top: 0px; position: absolute; right: 40px;"><button class="fmupBtn" data-optype="fmup">上移</button>&nbsp<button class="fmdownBtn" data-optype="fmdown">下移</button></div><p class="config-itm">分组标题：<input class="emval" cid="ftitle" type="text" value="分组标题"></p><p class="config-itm">分组对齐：<select class="emval" cid="falign"><option value="center">居中</option><option value="left">左对齐</option><option value="right">右对齐</option></select></p><button class="addBtn" data-optype="add" data-target="subColumn">组中增加列</button><button class="removeBtn" data-optype="remove" data-target="collection">删除组</button><fieldset class="config-children" data-type="subColumn"><legend><span class="cCount"></span>-<span class="sCount">1</span></legend><div style="top: 0px; position: absolute; right: 40px;"><button class="fmupBtn" data-optype="fmup">上移</button>&nbsp<button class="fmdownBtn" data-optype="fmdown">下移</button></div><p class="config-itm">标题：<input class="emval" cid="stitle" type="text" value="列标题"></p><p class="config-itm">类型:<select class="emval" cid="stype"><option value="number">数字</option><option value="0">非数字</option></select></p><p class="config-itm">可排序:<select class="emval" cid="ssortable"><option value="1">是</option><option value="0">否</option></select>&nbsp;&nbsp;百分比<input class="emval" cid="srenderer" type="checkbox" value="percentage"></p><p class="config-itm">对齐：<select class="emval" cid="salign"><option value="center">居中</option><option value="left">左对齐</option><option value="right">右对齐</option></select></p><p class="config-itm">键名：<input class="emval" cid="sname" type="text" value="key"><span class="remark">用于关联数据</span></p><button class="removeBtn" data-optype="remove" data-target="subColumn">删除</button></fieldset></fieldset>';
			break;
		case 'subColumn':
			str += '<fieldset class="config-children" data-type="subColumn"><legend><span class="cCount"></span>-<span class="sCount"></span></legend><div style="top: 0px; position: absolute; right: 40px;"><button class="fmupBtn" data-optype="fmup">上移</button>&nbsp<button class="fmdownBtn" data-optype="fmdown">下移</button></div><p class="config-itm">标题：<input class="emval" cid="stitle" type="text" value="列标题"></p><p class="config-itm">类型:<select class="emval" cid="stype"><option value="number">数字</option><option value="0">非数字</option></select></p><p class="config-itm">可排序:<select class="emval" cid="ssortable"><option value="1">是</option><option value="0">否</option></select>&nbsp;&nbsp;百分比<input class="emval" cid="srenderer" type="checkbox" value="percentage"></p><p class="config-itm">对齐：<select class="emval" cid="salign"><option value="center">居中</option><option value="left">左对齐</option><option value="right">右对齐</option></select></p><p class="config-itm">键名：<input class="emval" cid="sname" type="text" value="key"><span class="remark">用于关联数据</span></p><button class="removeBtn" data-optype="remove" data-target="subColumn">删除</button></fieldset>';
			break;
	}
	return str;
}
// 刷新序号
var renderAllNum = function(target) {
	if (jQuery) {
		var _setting = $('#setting'),
			count = 0;
		_setting.find('fieldset.config-group').each(function() {
			var _this = $(this),
				type = _this.data('type');
			count++
			_this.find('span.count').text(count);
			if (type == 'collection') {
				var scount = 0;
				_this.find('fieldset.config-children').each(function() {
					var _children = $(this);
					scount++;
					_children.find('span.cCount').text(count);
					_children.find('span.sCount').text(scount);
				});
			}
		})
	}
}

// 对象为空
var isEmpty = function(obj){ for (var name in obj) { return false; } return true; };
