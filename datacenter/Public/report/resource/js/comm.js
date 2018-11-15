var APP_STATUS = APP_STATUS || {};

APP_STATUS.sys = {};
APP_STATUS.sys.time = new Date();
APP_STATUS.sys.frame = window.parent.window.document.getElementById("reportCase") || {};
APP_STATUS.sys.notice = '';

APP_STATUS.url = {};
APP_STATUS.url.host = 'http://' + location.host;
APP_STATUS.url.request = APP_STATUS.url.host + '/index.php';
APP_STATUS.url.login = APP_STATUS.url.host + '/report/login.php';
APP_STATUS.url.home = APP_STATUS.url.host + '/report/home.php';
APP_STATUS.url.report = APP_STATUS.url.host + '/report/report.php';

APP_STATUS.cur = {};
APP_STATUS.cur.sel_game = '';
APP_STATUS.cur.sel_cat_ttl = '';
APP_STATUS.cur.sel_report_ttl = '';

APP_STATUS.cur.game_report = [];
APP_STATUS.cur.game_server = [];
APP_STATUS.cur.game_report_url = [];
APP_STATUS.cur.sel_server = {};
APP_STATUS.cur.all_server = {};
APP_STATUS.cur.sel_start_date = '';
APP_STATUS.cur.sel_end_date = '';
APP_STATUS.cur.prefab_param = {};
APP_STATUS.cur.prefab_dsel = 0;

/*****Initialization*****/
$(function() {
	// 当前游戏
	APP_STATUS.cur.sel_game = $('#GameList').data('curgame') || '';
	// 所有报表
	var _sideNav = $('#navCollapse .side-nav');
	var _agr = _sideNav.data('allgamereport') || '',
		_agrurl = _sideNav.data('allgamereporturl') || '';
	APP_STATUS.cur.game_report = _agr ? _agr.split(',') : [];
	APP_STATUS.cur.game_report_url = _agrurl ? _agrurl.split(',') : [];
	// 所有平台
	$('#serverGroup').find('.tab-pane').each(function() {
		var _plt = $(this), plt = _plt.data('plt');
		APP_STATUS.cur.game_server.push(plt);
		APP_STATUS.cur.sel_server['sid['+plt+']'] = '*';
	})
	
	APP_STATUS.cur.all_server = APP_STATUS.cur.sel_server;

	if ($.cookie) {
		var _appNotice = $.cookie('APP_NOTICE') || ''
		if (_appNotice) {
			var _appNoticeArr = _appNotice.split('|');
			var type = _appNoticeArr[0];
			var msg = _appNoticeArr[1];
			__showGeneralTips('APP_NOTICE', '#TopTips', type, msg, 3000);
			$.cookie('APP_NOTICE', '');
		}
	}
})
/*****Initialization end*****/



/*****Common method*****/
// 通用用户登出
var __userLogout = function() {
	$.ajax({
		url: APP_STATUS.url.request,
		type: 'POST',
		dataType: 'json',
		data: {
			controller: 'ajax',
			method: 'logout'
		},
		success: function(d) {
			if (d.code == 200) {
				$.cookie('APP_NOTICE', 'success|已成功退出登录');
				window.location = APP_STATUS.url.home;
			} else {
				__showGeneralTips('LO_tips', "#TopTips", 'danger', d.msg, 3000);
			}
		},
		error: function() {
			__showGeneralTips('LO_tips', "#TopTips", 'danger', '请求失败', 3000);
		}
	})
}

// 通用用户登录
var __userLogin = function () {
		var _username = $('#LP_username').val(),
			_password = $('#LP_password').val(),
			_keepstatus = $('#LP_keepstatus').is(':checked') ? 30 : null;
		$.ajax({
			url: APP_STATUS.url.request,
			type: 'POST',
			dataType: 'json',
			data: {
				controller: 'ajax',
				method: 'login',
				logname: _username,
				logpwd: _password,
				keepstatus: _keepstatus
			},
			success: function(d) {
				var _tipsType = '';
				if (d.code == 200) {
					$.cookie('APP_NOTICE', 'success|用户' + _username + '，登录成功');
					window.location = window.location;
				} else {
					__showGeneralTips('LI_tips', "#LoginTips", 'danger', d.msg, 3000);
				}
			},
			error: function() {
				__showGeneralTips('LI_tips', "#LoginTips", 'danger', '请求失败', 3000);
			}
		})
	}


	// 通用通知
var __showGeneralTips = function(tipsId, target, type, msg, timeout, scroll) {
	if ($('#' + tipsId).length > 0) {
		$('#' + tipsId).remove();
	}
	var _html = '<div id="' + tipsId + '" class="alert alert-' + type + ' alert-dismissable" style="display:none"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + msg + '</div>';
	var _scroll = scroll || 0;
	if (_scroll) {
		$('html, body').animate({
			scrollTop: 0
		});
	}
	$(_html).appendTo(target).fadeIn();
	if (timeout) {
		setTimeout(function() {
			$(target).find('#' + tipsId).fadeOut("normal", function() {
				$('#' + tipsId).remove()
			})
		}, timeout)
		// setTimeout('_hideTips("' + target + '")', timeout);
	}
}

// 回车提交
$('#loginPopups input').on('keydown', function(e) {
	var curKey = e.which;
	if (curKey == 13) {
		__userLogin();
	}
})

// 显示时间
$('#loginInfo').on('click', function() {
	var nowTime = new Date();
	var timeStr = nowTime.toLocaleString();
	$('#currentTime').html(timeStr);
})


/*****Common method end*****/