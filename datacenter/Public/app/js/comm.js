$(function(){
    /* initialize */
    //选择游戏项
    $('#selectGame .selecter').popover({
      html:true,
      placement:'bottom',
      trigger:'click',
      title:'请选相应游戏的报表：',
      content:$('#selectGamePopover').html()
    })
    //模拟登录按钮
    $("#testSignIn").on('click', function(){
      $('#signInPrompt').modal('hide');
      $('#signBtn').hide();
      $('#userInfo').show();
    })

    $('.dropdown_option').on('click', function(){
      var _this = $(this);
      _this.parents('li').toggleClass('open');
    })
    //日期控件初始化
    
    //平台服务期选择
    
    //结果格式化
    // $("#result-table table").tablesorter();

    /* initialize end */

    /* test */
    
    $('.rp_option').on('click', function(){
      var _this = $(this);
      Controler.render(_this.attr('data-pid'));
    })
    /* test end */


    /* 检测浏览器版本号 */
    var _userAgent = navigator.userAgent.toLowerCase(), s, o = {};
    var _browser = {
      version: (_userAgent.match(/(?:firefox|opera|safari|chrome|msie)[\/: ]([\d.]+)/))[1],
      safari: /version.+safari/.test(_userAgent),
      chrome: /chrome/.test(_userAgent),
      firefox: /firefox/.test(_userAgent),
      ie: /msie/.test(_userAgent),
      opera: /opera/.test(_userAgent)
    } /* 获得浏览器的名称及版本信息 */

    if (_browser.ie && _browser.version < 9) {
        var _html = '<div class="alert alert-warning alert-dismissable" style="display:none"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 检测到你所使用的浏览器是 IE '+_browser.version+'，推荐使用<a class="alert-link" href="http://windows.microsoft.com/zh-cn/internet-explorer/download-ie">IE 9</a>及以上浏览器或<a class="alert-link" href="http://www.google.cn/intl/zh-CN/chrome/">Chrome</a>，<a class="alert-link" href="http://www.firefox.com.cn">Firefox</a>，<a class="alert-link" href="https://www.apple.com/cn/safari">Safari</a>等浏览器已获得更好的使用体验。</div>';
        $(_html).appendTo('#TopTips').show();
    } 
})



var _showTips = function(tipsId, target, type, msg, timeout){
  if($('#'+tipsId).length > 0){ $('#'+tipsId).remove(); }
  var _html = '<div id="'+tipsId+'" class="alert alert-'+type+' alert-dismissable" style="display:none"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+msg+'</div>';
  $(_html).appendTo(target).fadeIn();
  if(timeout){
    setTimeout('_tipsHide("'+target+'")', timeout);
  }
}
var _tipsHide = function(target){$(target).find('div.alert').fadeOut("normal", function(){$(this).remove()})};