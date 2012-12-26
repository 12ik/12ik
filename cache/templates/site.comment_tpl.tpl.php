<style>
.op-lnks {text-align: right;}
#link-report .report { text-align: right; font-size: 12px; visibility: hidden; display:block}
#link-report .report a { color: #BBB; }
#link-report .report a:hover { color: #FFF; background-color: #BBB; }
#comments .comment-report { float: right; margin-left: 10px; }
#comments .comment-report { font-size: 12px; visibility: hidden; }
#comments .comment-report a { color: #BBB; border: none; }
#comments .comment-report a:hover { color: #FFF; background-color: #BBB; }
</style>
<script>
IK = (typeof IK === 'undefined') ? $ : IK;
IK(function(){
		var reportDiv = "#link-report".concat("");
		$("body").delegate(reportDiv, 'mouseenter mouseleave', function(e){
		switch (e.type) {
		  case "mouseenter":
			$(this).find(".report").css('visibility', 'visible');
			break;
		  case "mouseleave":
			$(this).find(".report").css('visibility', 'hidden');
			break;
		}
		});
		//
		$("#comments").delegate(".comment-item", 'mouseenter mouseleave', function (e) {
		  switch (e.type) {
			case "mouseenter":
			  $(this).find(".op-lnks").css('visibility', 'visible');
			  $(this).find(".comment-report").css('visibility', 'visible');
			  break;
			case "mouseleave":
			  $(this).find(".op-lnks").css('visibility', 'hidden');
			  $(this).find(".comment-report").css('visibility', 'hidden');
			  break;
		  }
		});	  
});
</script>   