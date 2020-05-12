<script>
	function regNewsletter()
	{
		var emailpattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		var email = $('#txtemail').val();
		if(email != "")
		{
			if(!emailpattern.test(email))
			{
				$("#text-danger-newsletter").remove();
				$("#form-newsletter-error").removeClass("has-error");
				$("#newsletter-email").append('<div class="text-danger" id="text-danger-newsletter"><?php echo $error_news_email_invalid; ?></div>');
				$("#form-newsletter-error").addClass("has-error");

				return false;
			}
			else
			{
				$.ajax({
					url: 'index.php?route=extension/module/newsletters/add',
					type: 'post',
					data: 'email=' + $('#txtemail').val(),
					dataType: 'json',
					async:false,

					success: function(json) {

						if (json.message == true) {
							alert('<?php echo $error_newsletter_sent; ?>');
							window.location= "index.php";
						}
						else {
							$("#text-danger-newsletter").remove();
							$("#form-newsletter-error").removeClass("has-error");
							$("#newsletter-email").append(json.message);
							$("#form-newsletter-error").addClass("has-error");
						}
					}
				});
				return false;
			}
		}
		else
		{

			$("#text-danger-newsletter").remove();
			$("#form-newsletter-error").removeClass("has-error");
			$("#newsletter-email").append('<div class="text-danger" id="text-danger-newsletter"><?php echo $error_news_email_required; ?></div>');
			$("#form-newsletter-error").addClass("has-error");

			return false;
		}
	}
</script>
<!--<div class="row">
	<form action="" method="post" class="form-horizontal">
		<div class="form-group" id="form-newsletter-error">
			<label for="input-firstname" class="control-label col-xs-2"><?php echo strtoupper($text_email); ?></label>
			<div class="col-xs-6" id="newsletter-email">
				<input type="email" name="txtemail" id="txtemail" value="" placeholder="" class="form-control"  />
			</div>
			<span class="col-xs-2">
				<button type="submit" class="btn btn-secondary" onclick="return regNewsletter();">Enviar</i></button> 
			</span> 
		</div>
	</form>
</div>-->


<div class="row">
	<form action="" method="post" class="form-horizontal">
		<div class="input-group">
			<input type="email" class="form-control" size="50" placeholder="Email" required="">
			<div class="input-group-btn">
				<button type="button" class="btn btn-danger"><i class="fa fa-envelope"></i></button>
			</div>
		</div>
	</form>
</div>


