var __dfTimeout = 2;


var __turnBack = function(url, tipTarget, timeout) {
	var tot = timeout ? timeout : __dfTimeout;
	var tourl = url ? url : '';
	function goBackTips() {
		tot--
		if (tot < 0) {
			window.location = tourl;
		} else {
			$(tipTarget).text(tot);
		}
	}
	if(tourl) setInterval(goBackTips, 1000);
}

$(function(){
	var url = $('#goBack').data('url') || '';
	if($('#validTips').length > 0){
		$('#goBack').html('');
	}else{
		__turnBack(url, '#countDown');
	} 
})