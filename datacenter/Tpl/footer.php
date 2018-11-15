<script>
$(function(){
	$("input[type='text'],input[type='password']").each(function() {
		$(this).addClass("input_text");
	});
	$("input[type='button'],input[type='reset'],input[type='submit']").each(function() {
		$(this).addClass("input_button");
	});
	$("select").each(function() {
		$(this).addClass("input_select");
	});

})
</script>
</body>
</html>