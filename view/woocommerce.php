<table class="table no-border">
	<tbody>
		<tr>
			<td class="col-xs-3">
				<h5><strong>Receive SMS on checkout</strong></h5>
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Enable this option if you want to receive SMS on successful checkout</span>
			</td>
			<td class="col-xs-9">
				<select name="smsbump_woo_on_checkout">
					<option value="yes" <?php if(get_option('smsbump_woo_on_checkout') == 'yes') echo 'selected=smsbump_woo_on_checkout'; ?>>Enabled</option>
					<option value="no"  <?php if(get_option('smsbump_woo_on_checkout')  == '' || get_option('smsbump_woo_on_checkout')  == 'no') echo 'selected=selected'; ?>>Disabled</option>
				</select>
			</td>
		</tr>
		<tr class="smsbump_woo_on_checkout_text" style="display:none;">
			<td class="col-xs-3">
				<span class="help">Shortcodes:<br />{OrderID} - Order id</span>
			</td>
			<td class="col-xs-9">
				<textarea name="smsbump_woo_on_checkout_text" cols="50" class="form-control" rows="4" class="regular-text"><?php if(get_option('smsbump_woo_on_checkout_text')) echo get_option('smsbump_woo_on_checkout_text'); else echo "Someone ordered something from your store. The order ID is: {OrderID}."; ?></textarea>
			</td>
		</tr>
		<tr>
			<td class="col-xs-3">
				<h5><strong>Send SMS on checkout</strong></h5>
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Enable this option if you want to send SMS to your customers that their order has been succesfully made.</span>
			</td>
			<td class="col-xs-9">
				<select name="smsbump_woo_on_checkout_user">
					<option value="yes" <?php if(get_option('smsbump_woo_on_checkout_user') == 'yes') echo 'selected=smsbump_woo_on_checkout_user'; ?>>Enabled</option>
					<option value="no"  <?php if(get_option('smsbump_woo_on_checkout_user')  == '' || get_option('smsbump_woo_on_checkout_user')  == 'no') echo 'selected=selected'; ?>>Disabled</option>
				</select>
			</td>
		</tr>
		<tr class="smsbump_woo_on_checkout_user_text" style="display:none;">
			<td class="col-xs-3">
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Shortcodes:<br />{SiteName} - Site name<br />{OrderID} - Order id</span>
			</td>
			<td class="col-xs-9">
				<textarea name="smsbump_woo_on_checkout_user_text" cols="50" class="form-control" rows="4" class="regular-text"><?php if(get_option('smsbump_woo_on_checkout_user_text')) echo get_option('smsbump_woo_on_checkout_user_text'); else echo "Thank you for ordering from {SiteName}. Your order ID is: {OrderID}."; ?></textarea>
			</td>
		</tr>
		<tr>
			<td class="col-xs-3">
				<h5><strong>Send SMS on completed order</strong></h5>
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Enable this option if you want to send SMS to your customers when the order status is changed to Completed.</span>
			</td>
			<td class="col-xs-9">
				<select name="smsbump_woo_on_order_status">
					<option value="yes" <?php if(get_option('smsbump_woo_on_order_status') == 'yes') echo 'selected=selected'; ?>>Enabled</option>
					<option value="no"  <?php if(get_option('smsbump_woo_on_order_status')  == '' || get_option('smsbump_woo_on_order_status')  == 'no') echo 'selected=selected'; ?>>Disabled</option>
				</select>
			</td>
		</tr>
		<tr class="smsbump_woo_on_order_status_text" style="display:none;">
			<td class="col-xs-3">
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Shortcodes:<br />{OrderID} - Order id<br />{SiteName} - Site name</span>
			</td>
			<td class="col-xs-9">
				<textarea name="smsbump_woo_on_order_status_text" cols="50" class="form-control" rows="4" class="regular-text"><?php if(get_option('smsbump_woo_on_order_status_text')) echo get_option('smsbump_woo_on_order_status_text'); else echo "Your order ({OrderID}) at {SiteName} has been completed."; ?></textarea>
			</td>
		</tr>
	</tbody>
</table>
<script>
	jQuery(function ($) {
		var smsbump_woo_on_checkout = '<?php echo $smsbump_woo_on_checkout ?>';
		
		if(smsbump_woo_on_checkout == "yes") {
			$('.smsbump_woo_on_checkout_text').show();
		} else {
			$('.smsbump_woo_on_checkout_text').hide();
		}

		$('select[name="smsbump_woo_on_checkout"]').on('change', function() {
			if($(this).val()=="yes") {
				$('.smsbump_woo_on_checkout_text').show();
			} else {
				$('.smsbump_woo_on_checkout_text').hide();
			}
		});

		var smsbump_woo_on_checkout_user = '<?php echo $smsbump_woo_on_checkout_user ?>';
		
		if(smsbump_woo_on_checkout_user == "yes") {
			$('.smsbump_woo_on_checkout_user_text').show();
		} else {
			$('.smsbump_woo_on_checkout_user_text').hide();
		}

		$('select[name="smsbump_woo_on_checkout_user"]').on('change', function() {
			if($(this).val()=="yes") {
				$('.smsbump_woo_on_checkout_user_text').show();
			} else {
				$('.smsbump_woo_on_checkout_user_text').hide();
			}
		});

		var smsbump_woo_on_order_status = '<?php echo $smsbump_woo_on_order_status ?>';
		
		if(smsbump_woo_on_order_status == "yes") {
			$('.smsbump_woo_on_order_status_text').show();
		} else {
			$('.smsbump_woo_on_order_status_text').hide();
		}

		$('select[name="smsbump_woo_on_order_status"]').on('change', function() {
			if($(this).val()=="yes") {
				$('.smsbump_woo_on_order_status_text').show();
			} else {
				$('.smsbump_woo_on_order_status_text').hide();
			}
		});		

	});
	
</script>