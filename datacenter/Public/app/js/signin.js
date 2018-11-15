$(function() {
	$("#submit").on('click', function() {
		$("#msgAlert").remove();
		$("#TopAlert").prepend('<div id="msgAlert" class="alert alert-dismissable alert-danger" ><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>帐号密码有误，请重新输入(测试通知栏)</div>')
	})
})