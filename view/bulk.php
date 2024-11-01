<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Sending messages</h4>
			</div>
			<div class="modal-body">
				<div id="modal-message"><h4>Do not close this window until the script finishes. Otherwise the messages will not be sent to all customers.</h4></div><br />
				<div id="progressbar-parent" class="progress progress-striped active">
					<div class="progress-bar" id="progressbar" role="progressbar" style="width:0%"></div>
				</div>
				<div id="modal-message-sent"><h5>Last sent to: <span id="modal-telephone"> </span></h5></div>
				<div id="modal-message-senttotal"><h5>Sent messages: <span id="modal-telephone-total">0</span></h5></div>
				<div id="modal-message-errors"><h5>Errors: <span id="modal-telephone-errors">0</span></h5></div>
				<div id="modal-message-errorsAll" style="max-height: 150px;overflow: scroll;overflow-x: hidden; overflow-y: hidden; overflow: auto;"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" id="myModalClose" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
			
<table class="table no-border">
	<tbody>
		<tr>
			<td class="col-xs-3">
				<h5><strong>From:</strong></h5>
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;This field will be taken into account only if you are subscribed for the priority plan.<br />* Latin characters are supported only.</span>
			</td>
			<td class="col-xs-9">
				<div class="col-xs-4">
					<input type="text" class="regular_text" name="from" value="" />
				</div>
			</td>
		</tr>
		<tr>
			<td class="col-xs-3">
				<h5><strong>To:</strong></h5>
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Choose the customers that you would like to receive your message.</span>
			</td>
			<td class="col-xs-9">
				<div class="col-xs-4">
					<select name="message_to">
						<option value="customer_all">All users</option>
						<option value="customer">Specific users</option>
						<option value="phones">Specific phone numbers</option>
					</select>
				</div>
			</td>
		</tr>
		<tr id="adding_numbers" style="display:none;">
			<td class="col-xs-3">
				<label for="number">Phone number:</label>
			</td>
			<td class="col-xs-9">
				<div class="col-xs-4 specific_number_input">
					<div class="specific_number_prefix">
						<select name="specific_number_prefix" >
							<?php foreach ($countries as $country) { ?>
							<option data-country-code="<?php echo strtolower($country['d_code']); ?>" value="<?php echo strtolower($country['code']); ?>" <?php echo (!empty($country['code']) && $country['code'] == 'US') ? 'selected=selected' : '' ?>><?php echo $country['name'] ?> </option>
							<?php } ?>
						</select>
					</div>
					<div class="col-xs-2 clearPadding code">
						<input type="text"  id="input-specific_number_country_code" value="+1" />
					</div>
					<div class="col-xs-10 clearPadding number">
						<input name="number" type="text" value="" placeholder="+19876543210"/>
						<button class="button-primary"  id="addNumber"/><?php _e('Add', 'smsbump'); ?></button>
					</div>
				</div>
			</td>
		</tr>
		<tr id="added_numbers" style="display:none;">
			<td class="col-xs-3">
				
			</td>
			<td class="col-xs-9">
				<div class="col-xs-4">
					<div class="numbers_scrollbar">
						<ul>
						</ul>
					</div>
				</div>
			</td>
		</tr>
		<tr id="adding_users" style="display:none;">
			<td class="col-xs-3">
				<label for="users">Search:</label>
			</td>
			<td class="col-xs-9">
				<div class="col-xs-4">
					<input name="users" type="text" class="regular-text" value="" />
				</div>
			</td>
		</tr>
		<tr id="added_users" style="display:none;">
			<td class="col-xs-3">
				
			</td>
			<td class="col-xs-9">
				<div class="col-xs-4">
					<div class="numbers_scrollbar">
						<ul>
						</ul>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td class="col-xs-3">
				<h5><strong><span class="required">*</span> Message:</strong></h5>
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Usually one text is 160 characters. If your message contains more than 160 characters, your message will be divided in more than one SMSs. For example, if your message contains 1600 characters, a given customer will receive 10 SMSs (10*160).<br />* Non-latin characters <strong>are</strong> supported.</span>
			</td>
			<td class="col-xs-9">
				<div class="col-xs-4">
					<textarea name="message" cols="30" id="count_me" rows="4" class="regular-text"></textarea>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<p class="submit">
					<input type="submit" class="button-primary" id="sendMessage" value="<?php _e('Send', 'smsbump'); ?>" />
				</p>
			</td>
		</tr>
	</tbody>
</table>

<script>
 	jQuery(function ($) {
 		function formatSpecificNumberCountryPrefix (state) {
            if (!state.id) { return state.text; }

          var $state = $(
            '<span><img src="<?= plugin_dir_url(__FILE__) ?>/images/smsbump/country_flags/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span><span style="float:right;" class="dial_code">('+state.element.getAttribute('data-country-code').toLowerCase()+')</span>'
          );

          return $state;
        };

        $(document).ready(function() {
            $("select[name='specific_number_prefix']").select2({
              templateResult: formatSpecificNumberCountryPrefix,
              templateSelection: formatSpecificNumberCountryPrefix
            });

           $("select[name='specific_number_prefix']").on("select2:select", function(e) {
		        $('#input-specific_number_country_code').val(e.params.data.element.getAttribute('data-country-code'));

		    }); 
        });

		$('select[name="message_to"]').on('change', function() {
			if($(this).val()=="phones") {
				$('#adding_numbers').show();
				$('#added_numbers').show();
				$('#adding_users').hide();
				$('#added_users').hide();
			} else if($(this).val()=="customer") {
				$('#adding_users').show();
				$('#added_users').show();
				$('#adding_numbers').hide();
				$('#added_numbers').hide();
			} else {
				$('#adding_users').hide();
				$('#added_users').hide();
				$('#adding_numbers').hide();
				$('#added_numbers').hide();
			}
		});

		$('select[name="type"]').on('change', function() {
			if($(this).val()=="mms") {
				$('.media_upload').show();
			} else {
				$('.media_upload').hide();
			}
		});

		$('#addNumber').on('click', function(e) {
			 e.preventDefault();
       		 e.stopPropagation();
			if($(this).prev('input').val()) {
				
				var full_number = $('#input-specific_number_country_code').val() + $(this).prev('input').val();
		    	$(this).parents('#adding_numbers').next('#added_numbers').find('.numbers_scrollbar').find('ul').append('<li><span class="customer"><span class="phone_entry">'+full_number+'</span><i class="dashicons dashicons-no-alt"></i></span</li>');

		    	$('.customer').delegate('.dashicons-no-alt', 'click', function() {
				  	$(this).parent().remove();
				});
	    	}
	    	$(this).prev('input').val("");
		});
	
		var validate = function () {
			if(!($('textarea[name="message"]').val())) {
				return false;
			}
			return true;
		};

	    $('#sendMessage').on('click', function(e) {
	    	e.preventDefault();
       		e.stopPropagation();
	    	if(validate()) {
		    	var phones = [];
		    	var newPhones = [];
		    	switch($('select[name="message_to"]').val()) {
		    		case "customer_all": 
		    			phones = getAllUsersPhones(); 
		    			for(i = 0; i<phones.length; i++) {
		    				if(sendCheck(phones[i]) != false) {
		    					newPhones.push(sendCheck(phones[i]));
		    				}	    					
		    			}
		    			break;
		    		case "customer": 
		    			$('.numbers_scrollbar').find('.customer').each(function() { 
		    				phones.push($(this).attr('data-phone'));
		    			});

		    			for(i = 0; i<phones.length; i++) {
		    				if(sendCheck(phones[i]) != false) {
		    					newPhones.push(sendCheck(phones[i]));
		    				}	    					
		    			}
		    			break;
		    		case "phones": 
		    			$('.numbers_scrollbar').find('.phone_entry').each(function() { 
		    				newPhones.push($(this).html());
		    			});
		    			break;

		    		default: break;
		    	}

		    	$('#myModalClose').attr('disabled', true);
				$('#myModal').modal('show');
				var total = 0;
				var errors = 0;
		    	$.smsbump({
					apikey: '<?php echo (get_option('smsbump_apikey')!=false) ? get_option('smsbump_apikey') : 'test'; ?>',
					to: newPhones,
					type: 'sms',
					from: $('input[name="from"]').val(),
					media: $('#wpss_upload_image').val(),
					message: $('textarea[name="message"]').val(),
					success: function(resp) {
						total++;
						$('#progressbar').css('width', (total/newPhones.length)*100 + '%');
						$('#progressbar').html((total/newPhones.length)*100 + '%');
						$('#modal-telephone').html(resp['data']['to']);
						$('#modal-telephone-total').html(total);
						if (total==newPhones.length) {
							$('#progressbar-parent').removeClass('active');
							$('#myModalClose').attr('disabled', false);
							$('#modal-message').html('<h4>Great! The messages were sent successfully. You can now close the popup.</h4>');
						}
					},
					error: function(resp) {
						total++;
						errors++;
						$('#progressbar').css('width', (total/newPhones.length)*100 + '%');
						$('#progressbar').html((total/newPhones.length)*100 + '%');
						$('#progressbar').val(total);
						$('#modal-telephone-errors').html(errors);
						$('#modal-message-errorsAll').append(resp['to'] + ": " + resp['message'] + "<br />");
						if (total==newPhones.length) {
							$('#progressbar-parent').removeClass('active');
							$('#myModalClose').attr('disabled', false);
							$('#modal-message').html('<h4>The operation completed successfully. However, some of the messages were not sent.</h4>');
						}
						
					}
				});
			} else {
				alert("Please enter message!");
			}
		});

		$("#count_me").characterCounter({
			counterFormat: '%1 written characters.',
			counterWrapper: 'div',
		    counterCssClass: 'message_counter'
		});
		
	});

// function formatNumber(number) {
// 	<?php if( (get_option('smsbump_enabled') == 'yes') && (get_option('smsbump_NumberPrefix')) && (get_option('smsbump_PhoneNumberPrefix')=='yes')) { ?>
// 		var numberCheck = number.replace(/^\++/, '');
// 		var prefixCheck = '<?php get_option('smsbump_NumberPrefix'); ?>'.replace(/^\++/, '');
// 		var newNumber = '';
// 		<?php if (get_option('smsbump_PhoneRemoveZeros')=='yes') { ?>
// 			var numberCheck = numberCheck.replace(/^0+/, '');
// 		<?php } ?>
// 		var newNumber = numberCheck;
// 		if (numberCheck.indexOf(prefixCheck) !== 0) {
// 			var newNumber = '<?php get_option('smsbump_NumberPrefix'); ?>' + numberCheck;
// 		}
// 		return newNumber;	
// 	<?php } else { ?>
// 		return number;	
// 	<?php } ?>
// }
	
function sendCheck(phone) {
	
	<?php if( get_option('smsbump_PhoneNumberPrefix')=='yes') { ?>
		phone.replace(' ','');
		phone.replace('-','');
		phone.replace('(','');
		phone.replace(')','');
		var numberCheck = phone.replace(/^(\+|0)+/, '');
		var prefixCheck = '<?php get_option('smsbump_StrictNumberPrefix'); ?>'.replace(/^\++/, '');
		var formattedNumber = '';
		if(!isNaN(phone)){
		    if((phone.indexOf('+') === 0 || phone.indexOf('00') === 0) && numberCheck.indexOf(prefixCheck) === 0 ){
		        formatedNumber = '+' + numberCheck;
		    } else if ((phone.indexOf('+') === 0 || phone.indexOf('00') === 0) && numberCheck.indexOf(prefixCheck) !== 0){
		        formattedNumber = false;
		    } else if (numberCheck.indexOf(prefixCheck) === -1){
		        formattedNumber = prefix + numberCheck;
		    } else if (phone.indexOf('+') !== 0 && phone.indexOf('00') !== 0 && numberCheck.indexOf(prefixCheck) === 0 ){
		         formattedNumber = '+'+phone;
		    } else {
		        formattedNumber = false;
		    }		

		}
		return formattedNumber;
	<?php } ?>
	return phone;
}

function getAllUsersPhones() {
	var phones = [];
	<?php 
	$users = get_users();
	foreach ($users as $user ) { 
		$phone = get_user_meta($user->ID, "phone", true);
	?>
		phones.push('<?php echo $phone; ?>');
	<?php } ?>
	return phones;
}

function addFunds(amount) {
	var apikey = '<?php echo get_option('smsbump_apikey') ?>';
	
	jQuery(function ($) {
	    var parentUrl = (window.location != window.parent.location)
	                ? document.referrer
	                : document.location;
	     
	    $.ajax({
	        url: 'https://api.smsbump.com/recharge/'+apikey+'.json',
	        type: "GET",
	        data: {
	                amount: amount,
	                returnurl: parentUrl.href
	        },
	        success: function(json) {
	            if(json.status=='success') {
	                window.open(json.data.payment_link,"_top","",true);
	            } else {
	                alert("You need to register your API key in the administration before adding balance!");
	            }                   
	        }
	    });
	});
}

</script>
