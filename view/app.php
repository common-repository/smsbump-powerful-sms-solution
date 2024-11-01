<table class="table no-border">
	<tbody>
		<tr>
			<td class="col-xs-3"><label for="smsbump_enabled">Status</label></td>
			<td class="col-xs-9">
				<div class="col-xs-4">
					<select name="smsbump_enabled" id="module_status">
						<option value="yes" <?php if($enabled == 'yes') echo 'selected=selected'; ?>>Enabled</option>
						<option value="no"  <?php if(!($enabled) || $enabled == 'no') echo 'selected=selected'; ?>>Disabled</option>
					</select>
				</div>
			</td>
		</tr>
		<tr>
			<td class="col-xs-3">
				<h5><strong>Account Balance:</strong></h5>
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;The field displays your current account balance. You can load funds at any time by pressing on the <i class="fa fa-plus"></i> sign. <a href="http://smsbump.com/pages/pricing">View country pricing.</a></span>
			</td>
			<td class="col-xs-9">
				<!--span id="balance">Insufficient funds on balance. Please recharge.</span-->
				<div class="col-xs-4">
					<div class="btn-group">
						<button type="button" class="btn btn-success text button_custom"><span id="balance">0.00 USD</span></button>
						<button type="button" class="btn btn-success balance-plus dropdown-toggle button_custom" data-toggle="dropdown" aria-expanded="false" id="addFundsDropdown">
						<span class="fa fa-plus" aria-hidden="true"></span>
						</button>
						<ul class="dropdown-menu" role="menu" aria-labelledby="addFundsDropdown">
							<li role="amount"><a role="menuitem" tabindex="-1" onClick="addFunds('20.00');">$ 20.00</a></li>
							<li role="amount"><a role="menuitem" tabindex="-1" onClick="addFunds('50.00');">$ 50.00</a></li>
							<li role="amount"><a role="menuitem" tabindex="-1" onClick="addFunds('100.00');">$ 100.00</a></li>
							<li role="amount"><a role="menuitem" tabindex="-1" onClick="addFunds('200.00');">$ 200.00</a></li>
							<li role="amount"><a role="menuitem" tabindex="-1" onClick="addFunds('500.00');">$ 500.00</a></li>
							<li role="amount"><a role="menuitem" tabindex="-1" onClick="addFunds('1000.00');">$ 1000.00</a></li>
						</ul>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td class="col-xs-3">
				<label for="smsbump_apikey">API Key</label>
				<br/>
				<span class="help"><i class="fa fa-info-circle"></i> Get your API key from <a href="http://smsbump.com">http://smsbump.com</a>.</span>
			</td>
			<td class="col-xs-9">
				<div class="col-xs-4">
					<input type="text" name="smsbump_apikey"  value="<?php echo get_option('smsbump_apikey'); ?>"/>
				</div>
			</td>
		</tr>
	</tbody>
</table>
<?php $apikey = get_option("smsbump_apikey"); ?>
<script>
	jQuery(function ($) {

		$.ajax({
		  url: '//api.smsbump.com/balance/<?php echo $apikey; ?>.json',
		  type: "GET",
		  async: true,
		  success: function(result) {   
		  	//result = result || 0; 

		  	if (result.data){
		  		$('.fa-spin').css('display','none');
		  		var balance = parseFloat(result.data.balance).toFixed(2);
		    	$('#balance').html(parseFloat(result.data.balance).toFixed(2) + ' <span style="text-transform:uppercase;">' + result.data.currency + '</span>');

		    	if (balance > 0) {
		            $(function() {
		                var $typeSelector = $('#module_status');
		                var $toggleArea = $('#status');

		                 if ($typeSelector.val() === 'yes') {
		                        $toggleArea.removeClass('label label-danger')
		                        $toggleArea.css('display','inline-block');
		                        $toggleArea.addClass('label label-success') ;
		                        $toggleArea.html('Enabled');
		                       
		                    }
		                    else {
		                        $toggleArea.removeClass('label label-success');
		                        $toggleArea.css('display','inline-block');
		                        $toggleArea.addClass('label label-danger'); 
		                        $toggleArea.html('Disabled');
		                        

		                    }
		                $typeSelector.change(function(){
		                    if ($typeSelector.val() === 'yes') {
		                        $toggleArea.removeClass('label label-danger')
		                        $toggleArea.css('display','inline-block');
		                        $toggleArea.addClass('label label-success') ;
		                        $toggleArea.html('Enabled');
		                        
		                    }
		                    else {
		                        $toggleArea.removeClass('label label-success')
		                        $toggleArea.css('display','inline-block')
		                        $toggleArea.addClass('label label-danger')  
		                        $toggleArea.html('Disabled');
		                       
		                    }
		                }); 
		            });
		        } else if (balance <= 0) {

		            $('#status').removeClass('label label-success');
		            $('#status').removeClass('label label-danger');
		            $('#status').css('display','inline')
		            $('#status').addClass('label label-warning') 
		            $('#status').html('Low credit'); 

		        } 
		  	}else if (result.status == "error"){
		  		$('#status').css('display','inline-block')
	            $('.fa-spin').css('display','none');
	            error = result.message;
				$('#status').removeClass('label label-success');
				 $('#status').addClass('label label-danger');

				if(error.indexOf('Missing API') > -1) {
					$('#status').html("Missing API key"); 
				} else if(error.indexOf('This app is stopped') > -1) {
					$('#status').html("Incorrect API key"); 
				} else {
				$('#status').html("Disabled"); 
				}	
        	}
        	}
		});

		var phoneNumberPrefix = '<?php echo $phoneNumberPrefix ?>';
		if(phoneNumberPrefix == "yes") {
			$('.NumberPrefix').show();
			$('.PhoneRemoveZeros').show();
		} else {
			$('.NumberPrefix').hide();
			$('.PhoneRemoveZeros').hide();
		}

		$('select[name="smsbump_PhoneNumberPrefix"]').on('change', function() {
			if($(this).val()=="yes") {
				$('.PhoneRemoveZeros').show();
				$('.NumberPrefix').show();
			} else {
				$('.NumberPrefix').hide();
				$('.PhoneRemoveZeros').hide();
			}
		});

		var strictPrefix = '<?php echo $strictPrefix ?>';
		if(strictPrefix == "yes") {
			$('.StrictNumberPrefix').show();
		} else {
			$('.StrictNumberPrefix').hide();
		}

		$('select[name="smsbump_StrictPrefix"]').on('change', function() {
			if($(this).val()=="yes") {
				$('.StrictNumberPrefix').show();
			} else {
				$('.StrictNumberPrefix').hide();
			}
		});

		var smsbump_published_comment = '<?php echo $published_comment; ?>';
		
		if(smsbump_published_comment == "yes") {
			$('.published_comment_text').show();
		} else {
			$('.published_comment_text').hide();
		}

		$('select[name="smsbump_published_comment"]').on('change', function() {
			if($(this).val()=="yes") {
				$('.published_comment_text').show();
			} else {
				$('.published_comment_text').hide();
			}
		});

		var smsbump_registered_user = '<?php echo $registered_user; ?>';
		
		if(smsbump_registered_user == "yes") {
			$('.registered_user_text').show();
		} else {
			$('.registered_user_text').hide();
		}

		$('select[name="smsbump_registered_user"]').on('change', function() {
			if($(this).val()=="yes") {
				$('.registered_user_text').show();
			} else {
				$('.registered_user_text').hide();
			}
		});

		var smsbump_success_registration_user = '<?php echo $success_registration_user; ?>';
		
		if(smsbump_success_registration_user == "yes") {
			$('.success_registration_user_text').show();
		} else {
			$('.success_registration_user_text').hide();
		}

		$('select[name="smsbump_success_registration_user"]').on('change', function() {
			if($(this).val()=="yes") {
				$('.success_registration_user_text').show();
			} else {
				$('.success_registration_user_text').hide();
			}
		});

	});
	
</script>