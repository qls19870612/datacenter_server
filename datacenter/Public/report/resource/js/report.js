$(function() {

  // 游戏选择控件初始化
  $('#selectGame').find('.selecter').popover({
    html: true,
    placement: 'bottom',
    trigger: 'click',
    title: '请选相应游戏的报表：',
    content: $('#selectGamePopover').html()
  });

  // 侧栏菜单控制
  (function _initSideNav(){
      var _sideNavWrap = $("#sideNavWrap");
      _sideNavWrap.on('click', 'a.option, label.nav-header', function(){
      var _this = $(this);
      if(_this.hasClass('nav-header')){
        $(this).parent().children('ul.tree').slideToggle(200);
      }else if(_this.hasClass('option')){
        _sideNavWrap.find('a.option').removeClass('active');
        _this.addClass('active');
        var rp_url = _this.data('pageurl'), rp_cid = _this.data('pagecode');
        APP_STATUS.cur.sel_report_ttl =  _this.text();
        APP_STATUS.cur.sel_cat_ttl = __findReportPath(_this);
        if(rp_url){
          __showReportOther(rp_url);
        }else{
          __showReportDetail(rp_cid);
        }
      }
    })
  })();


  // 区服选择控制
  $('#serverList').on('click', 'p.sitm, button.selCtrl', function() {
    var _this = $(this);
    if (_this.hasClass('sitm')) {
      _this.toggleClass('selected');
    } else if (_this.hasClass('selCtrl')) {
      var btntype = _this.data('btntype');
      var _items = $('#serverGroup').children('.active');
      switch (btntype) {
        case 'selectAll':
          var item = _items.find('p.sitm').length;
          var item_sel = _items.find('p.selected').length;
          if (item == item_sel) {
            _items.find('.sitm').removeClass('selected');
          } else {
            _items.find('.sitm').removeClass('selected').addClass('selected');
          }
          break;
        case 'antiElection':
          _items.find('.sitm').toggleClass('selected');
          break;
      }
    }
    __checkServerStatus();
  })


  $('#reportCase').on('load', function() {
    $('#iframeLoading').stop().slideUp();
  })


  // 路由报表详情页
  __reportCaseInit();

})




var __loadReportMenu = function(agr, agrurl) {
  var all_game_report = agr || [], all_game_report_url = agrurl || [];
  var gcode = APP_STATUS.cur.sel_game == '' ? $('#GameList').data('curgame') : APP_STATUS.cur.sel_game;
    $.ajax({
      url: APP_STATUS.url.request,
      type: 'POST',
      dataType: 'json',
      data: {
        controller: 'ajax',
        method: 'getfuncs',
        gamecode:gcode
      },
      beforeSend: function() {
        var errormsg = '<li class="dropdown open"><p class="menu-load-msg">正在加载菜单...</p></li>';
        $('#navCollapse .side-nav').html(errormsg);
      },
      success: function(d) {
        if (d.code == 200) {
          var list_dom = '';
          var def_open = 1;
          var functiongroup = d.functiongroup;
          var counter = {count:0};
          var list_dom = __getReportsMenu(functiongroup, counter);

          if (counter.count > 0) {
            var _sideNavWrap = $('#sideNavWrap .side-nav');
            _sideNavWrap.html(list_dom);
            _sideNavWrap.find('a.option:first').trigger('click');
          } else {
            _errorOp('该游戏没有报表');
            __showReportError('noreport');
          }
        } else {
          var errormsg = '加载失败[' + d.msg + ']';
          _errorOp(errormsg);
          __showReportError('requestFails');
        }
      },
      error: function() {
        _errorOp('加载失败[请求失败]');
        __showReportError('requestFails');
      }
    })
  function _errorOp(msg) {
    var errormsg = '<li class="dropdown"><p class="menu-load-msg">' + msg + '</p></li>';
    $('#navCollapse .side-nav').html(errormsg);
  }
}

var __reportCaseInit = function() {
  var nologin = $('#navbar').find('#loginBtn').length;
  var noselectgame = $('#navbar').find('#nosgtip').length;
  if (nologin > 0) {
    __showReportError('nologin');
  } else if (noselectgame > 0) {
    __showReportError('noselectgame');
  } else {
    __loadReportMenu(APP_STATUS.cur.game_report, APP_STATUS.cur.game_report_url);
  }
}


var __checkServerStatus = function() {
  $('#serverGroup').children('.tab-pane').each(function(idx) {
    var _this = $(this);
    var item = _this.find('p.sitm').length;
    var item_sel = _this.find('p.selected').length;
    var item_count = item == item_sel ? '全' : item_sel;
    $('#selectTab').find('li').eq(idx).find('span').text(item_count);
    APP_STATUS.sys.frame.contentWindow.__reFreshServerCtrl(idx, item_count);
  })
}


var __showReportDetail = function(rp_cid) {
  var src = 'rp.php?rp_cid=' + rp_cid;
  $('body,html').scrollTop(0);
  $('#iframeLoading').stop().slideDown();
  $('#reportCase').attr('src', src);
}

var __showReportError = function(etype) {
  var src = 'rp_error.php?et=' + etype;
  $('#iframeLoading').stop().slideDown();
  $('#reportCase').attr('src', src);
}

var __showReportOther = function(rp_url){
  var src_arr = rp_url.split('@@');
  $('body,html').scrollTop(0);
  $('#iframeLoading').stop().slideDown();
  if(src_arr.length > 1){
    window.location = src_arr[1];
  }else{
    $('#reportCase').attr('src', rp_url);
  }
}

var __getReportsMenu = function(d, counter){
  var data = d, html = '';
  for(var e in data){
    var group = ''
    , item = data[e]
    , groupname = item['groupname']
    , menu = item['menu'] || []
    , menu_len = menu.length
    , menu_str = ''
    , sub_group = item['sub_group'] || []
    , sub_group_len = sub_group.length
    , sub_group_str = '';
    var label = '<label class="tree-toggle nav-header">'+groupname+'</label>';
    if(menu_len > 0){
      for(var i=0; i<menu_len; i++){
        var m_title = menu[i]['rp_title'] || ''
        , m_code = menu[i]['rp_cid'] || ''
        , m_url = menu[i]['rp_url'] || '';
        menu_str += '<li><a class="option" href="#" data-pagecode="'+m_code+'" data-pageurl="'+m_url+'">'+m_title+'</a></li>';
        counter['count'] = counter['count'] ? counter['count'] + 1 : 1;
      }
    }
    if(sub_group_len > 0){
      sub_group_str += arguments.callee(sub_group, 1);
    }
    if(menu_len || sub_group_str){
      //  先目录后项目
      // group = '<li>'+label+'<ul class="nav nav-list tree" style="display:none">'+menu_str+sub_group_str+'</ul></li>';
      // 先项目后目录
      group = '<li>'+label+'<ul class="nav nav-list tree" style="display:none">'+sub_group_str+menu_str+'</ul></li>';
    }
    html += group;
  }
  return html;
}

var __findReportPath = function(target){
  var note = '';
  var parent = $(target).parent('li').parent('ul.tree');
  if(parent.length > 0){
    note = parent.prev('label.nav-header').text();
    note = arguments.callee(parent) + '<li>' + note + '</li>';
  }else{
    note = '';
  }
  return note
}




APP_STATUS.ope = {};


APP_STATUS.ope.init_all_platform = function() {
  // var item = $('#serverGroup').find('p.sitm').length;
  // var item_sel = $('#serverGroup').find('p.selected').length;
  var dsel = APP_STATUS.cur.prefab_dsel;
  $('#selectTab').find('span').text('0');
  $('#serverGroup').find('.sitm').removeClass('selected');
  if(dsel > 0){
    for(var i=0; i<dsel; i++){
      $('#selectTab').find('li:eq('+i+')').find('span').text('全');
      $('#serverGroup').find('.tab-pane:eq('+i+')').find('.sitm').addClass('selected');
    }
  }else{
    $('#selectTab').find('span').text('全');
    $('#serverGroup').find('.sitm').addClass('selected');
  }
  
};

APP_STATUS.ope.select_all_server = function(plt) {
  var item = $('#serverGroup').children('div[data-plt="' + plt + '"]').find('p.sitm').length;
  var item_sel = $('#serverGroup').children('div[data-plt="' + plt + '"]').find('p.selected').length;
  if (item == item_sel) {
    $('#serverGroup').children('div[data-plt="' + plt + '"]').find('.sitm').removeClass('selected');
  } else {
    $('#serverGroup').children('div[data-plt="' + plt + '"]').find('.sitm').removeClass('selected').addClass('selected');
  }
  __checkServerStatus();
};
APP_STATUS.ope.select_all_platform = function() {
  var item = $('#serverGroup').find('p.sitm').length;
  var item_sel = $('#serverGroup').find('p.selected').length;
  if (item == item_sel) {
    $('#serverGroup').find('.sitm').removeClass('selected');
  } else {
    $('#serverGroup').find('.sitm').removeClass('selected').addClass('selected');
  }
  __checkServerStatus();
};
APP_STATUS.ope.serverListShow = function() {
  $("#serverListShow").trigger('click');
};
APP_STATUS.ope.serverCount = function() {
  var sel_server = {};
  $('#serverGroup').children('.tab-pane').each(function() {
    var _this = $(this);
    var plt = _this.data('plt');
    var serverArr = [];
    var sitm_group = _this.find('p.sitm');
    var selected_group = _this.find('p.selected');
    if(sitm_group.length == selected_group.length){
        sel_server['sid[' + plt + ']'] = '*';
    }else{
      _this.find('p.selected').each(function() {
        var _itm = $(this);
        serverArr.push(_itm.data('val'));
      })
      if(serverArr.length > 0){
        sel_server['sid[' + plt + ']'] = serverArr.join(',');
      }
    }
  })
  return sel_server;
};
