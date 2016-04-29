<div class="buttons">
    <?php echo $button_confirm; ?>
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
	$.ajax({
		beforeSend: function() {
                    $('#button-confirm').attr('disabled', false);
			//$('#button-confirm').button('loading');
		},
		complete: function() {
			//$('#button-confirm').button('reset');
                        $('#button-confirm').attr('disabled', false);
		},
		success: function() {
			location = '<?php echo 'index.php?route=payment/paysonCheckout2/confirm'; ?>';
		}
	});
});
//--></script>