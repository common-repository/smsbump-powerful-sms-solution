<table class="table no-border">
	<tbody>
		<tr>
			<td class="col-xs-3">
				<h5><strong>Send short messages only to specific country:</strong></h5>
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Enable this option if you want to send short messages only to specific country. <i>Note: Phone numbers which are not from the selected country will be omitted!</i></span>
			</td>
			<td class="col-xs-10">
				<div class="col-xs-4">
					<select name="smsbump_PhoneNumberPrefix" id="Check">
						<option value="yes" <?php if($smsbump_PhoneNumberPrefix && $smsbump_PhoneNumberPrefix == 'yes') echo 'selected=selected'; ?>>Enabled</option>
						<option value="no"  <?php if(!($smsbump_PhoneNumberPrefix) || $smsbump_PhoneNumberPrefix == 'no') echo 'selected=selected'; ?>>Disabled</option>
					</select>
					<div class="prefix">
						<select name="smsbump_SelectPhoneNumberPrefix">
							<?php foreach ($countries as $country) { ?>
							<option data-country-code="<?php echo strtolower($country['d_code']); ?>" value="<?php echo strtolower($country['code']); ?>" <?php echo (!empty($country['code']) && $country['code'] == 'US') ? 'selected=selected' : '' ?>><?php echo $country['name'] ?> </option>
							<?php } ?>
						</select>
						<input type="hidden" class="form-control" name="smsbump_NumberPrefix" value="<?php echo get_option('smsbump_NumberPrefix'); ?>" />
						<input type="hidden" class="form-control" name="smsbump_CountryCode" value="<?php echo get_option('smsbump_CountryCode'); ?>" />
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td class="col-xs-3">
				<h5><strong>Store owner phone numbers:</strong></h5>
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;The added phone numbers will be used for admin notifications.</span>
			</td>
			<td class="col-xs-9" id="storeOwnerInputs">
				<div class="col-xs-4">
					<div id="showHideOption">
						<div class="col-xs-12 clearPadding">
							<label ><input type="checkbox"  id="addCountryCodeToStoreOwnerNumber" >&nbsp;Uncheck this option, if you want to change the country code.</label>
						</div>
					</div>
					<div class="col-xs-2 clearPadding code">
						<input type="text"  id="input-store_owner_country_code" disabled="disabled" value="<?php echo get_option('smsbump_NumberPrefix'); ?>" />
					</div>
					<div class="col-xs-10 clearPadding number">
						<input type="text"  id="input-store_owner_phone" value="" />
						<button class="button-primary" type="button" id="addStoreOwner">Add</button>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td class="col-xs-3">
			</td>
			<td class="col-xs-9">
				<div class="col-xs-4">
					<div id="storeOwnerTelephone" class="numbers_scrollbar">
						<?php if(!empty($smsbump_StoreOwnerPhoneNumber)) { ?>
						<?php $i = 0 ?>
						<?php foreach($smsbump_StoreOwnerPhoneNumber as $store_owner_number) { ?>
						<div id="storeOwnerTelephone<?php echo $i ?>"><i class="fa fa-minus-circle"></i>&nbsp;<?php echo $store_owner_number ?><input type="hidden" name="smsbump_StoreOwnerPhoneNumber" value="<?php echo $store_owner_number ?>" /></div>
						<?php $i++; ?>
						<?php } ?>
						<?php } ?>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td class="col-xs-3">
				<h5><strong>From:</strong></h5>
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;This field will be taken into account only if you are subscribed for the <a href="http://smsbump.com/pages/pricing">priority plan.</a><br>*Latin characters are supported only.</span>
			</td>
			<td class="col-xs-9">
				<div class="col-xs-4">
					<input name="smsbump_From" type="text" class="regular-text" value="<?php echo get_option('smsbump_From'); ?>"/>
				</div>
			</th>
		</tr>
		<tr>
			<td class="col-xs-3"><label for="smsbump_published_comment">Receive SMS on published comment</label></td>
			<td class="col-xs-9">
				<div class="col-xs-4">
					<select name="smsbump_published_comment">
						<option value="yes" <?php if(get_option('smsbump_published_comment') == 'yes') echo 'selected=selected'; ?>>Enabled</option>
						<option value="no"  <?php if(!(get_option('smsbump_published_comment'))  == 'false' || get_option('smsbump_published_comment')  == 'no') echo 'selected=selected'; ?>>Disabled</option>
					</select>
				</div>
			</td>
		</tr>
		<tr class="published_comment_text" style="display:none;">
			<td class="col-xs-3">
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Shortcodes:<br />{author} - Author name<br />{post_title} - Post title</span>
			</td>
			<td class="col-xs-9">
				<div class="col-xs-4">
					<textarea name="smsbump_published_comment_text" cols="50" class="form-control" rows="4" class="regular-text"><?php if(get_option('smsbump_published_comment_text')) echo get_option('smsbump_published_comment_text'); else echo "Hello! The user {author} posted a new comment in {post_title}!"; ?></textarea>
				</div>
			</td>
		</tr>
		<tr>
			<td class="col-xs-3"><label for="smsbump_registered_user">Receive SMS on registered user</label></td>
			<td class="col-xs-9">
				<div class="col-xs-4">
					<select name="smsbump_registered_user">
						<option value="yes" <?php if(get_option('smsbump_registered_user') == 'yes') echo 'selected=selected'; ?>>Enabled</option>
						<option value="no"  <?php if(!(get_option('smsbump_registered_user')) || get_option('smsbump_registered_user')  == 'no') echo 'selected=selected'; ?>>Disabled</option>
					</select>
				</div>
			</td>
		</tr>
		<tr class="registered_user_text" style="display:none;">
			<td class="col-xs-3">
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Shortcodes:<br />{user_name} - User name</span>
			</td>
			<td class="col-xs-9">
				<div class="col-xs-4">
					<textarea name="smsbump_registered_user_text" cols="50" class="form-control" rows="4" class="regular-text"><?php if(get_option('registered_user_text')) echo get_option('registered_user_text'); else echo "Hello! The user {user_name} registered at your site!"; ?></textarea>
				</div>
			</td>
		</tr>
		<tr>
			<td class="col-xs-3"><label for="smsbump_success_registration_user">Send SMS to users on successful sign up</label></td>
			<td class="col-xs-9">
				<div class="col-xs-4">
					<select name="smsbump_success_registration_user">
						<option value="yes" <?php if(get_option('smsbump_success_registration_user') == 'yes') echo 'selected=selected'; ?>>Enabled</option>
						<option value="no"  <?php if(!(get_option('smsbump_success_registration_user')) || get_option('smsbump_success_registration_user')  == 'no') echo 'selected=selected'; ?>>Disabled</option>
					</select>
				</div>
			</td>
		</tr>
		<tr class="success_registration_user_text" style="display:none;">
			<td class="col-xs-3">
				<span class="help"><i class="fa fa-info-circle"></i>&nbsp;Shortcodes:<br />{user_name} - User name</span>
			</td>
			<td class="col-xs-9">
				<div class="col-xs-4">
					<textarea name="smsbump_success_registration_user_text" cols="50" class="form-control" rows="4" class="regular-text"><?php if(get_option('smsbump_success_registration_user_text')) echo get_option('smsbump_success_registration_user_text'); else echo "Hello, {user_name}! Thank you for registering. Enjoy our site!"; ?></textarea>
				</div>
			</td>
		</tr>
	</tbody>
</table>
<script>
	jQuery(function ($) {

		function formatStatePrefix (state) {
            if (!state.id) { return state.text; }

          var $state = $(
            '<span><img src="<?= plugin_dir_url(__FILE__) ?>/images/smsbump/country_flags/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span><span style="float:right;" class="dial_code">('+state.element.getAttribute('data-country-code').toLowerCase()+')</span>'
          );

          return $state;
        };

        $(document).ready(function() {
            $("select[name='smsbump_SelectPhoneNumberPrefix']").select2({
              templateResult: formatStatePrefix,
              templateSelection: formatStatePrefix
            });

            $("select[name='smsbump_SelectPhoneNumberPrefix']").on("select2:select", function(e) {
                $('input[name="smsbump_NumberPrefix"]').val(e.params.data.element.getAttribute('data-country-code'));
                $('input[name="smsbump_CountryCode"]').val(e.params.data.element.value);
            });
            var selected_country = "<?php echo $selected_country ?>";
            $("select[name='smsbump_SelectPhoneNumberPrefix']").select2('val', selected_country);

        });

    var owner_number = <?php echo(!empty($smsbump_StoreOwnerPhoneNumber) ? count($smsbump_StoreOwnerPhoneNumber): 0) ?>;


    $("#addStoreOwner").click(function(e) {
        e.preventDefault();
        e.stopPropagation();

        if ($('input[id=\'input-store_owner_country_code\']').val() && $('input[id=\'input-store_owner_phone\']').val()) {
            var full_phone_number = $('input[id=\'input-store_owner_country_code\']').val() + $('input[id=\'input-store_owner_phone\']').val();
            
            $('#storeOwnerTelephone').append('<div id="storeOwnerTelephone' + owner_number + '">' +  full_phone_number + '<input type="hidden" name="smsbump_StoreOwnerPhoneNumber[]" value="' + full_phone_number + '" /><i class="dashicons dashicons-no-alt"></div>');
            owner_number++;
            $('#storeOwnerTelephone div:odd').attr('class', 'odd');
            $('#storeOwnerTelephone div:even').attr('class', 'even');
    
            $('input[id=\'input-store_owner_phone\']').val('');
        } else {
            alert('Error: All fileds are required!');
        }
    });

    $('#storeOwnerTelephone').delegate('.dashicons-no-alt', 'click', function() {
        $(this).parent().remove();

        $('#storeOwnerTelephone div:odd').attr('class', 'odd');
        $('#storeOwnerTelephone div:even').attr('class', 'even'); 
    });

    //Store owner number formating
   
    $(function() {
	    var $typeSelector = $('#Check');
	    var $toggleArea = $('.prefix');
		 if ($typeSelector.val() === 'yes') {
	            $toggleArea.show(); 
	        }
	        else {
	            $toggleArea.hide(); 
	        }
	    $typeSelector.change(function(){
	        if ($typeSelector.val() === 'yes') {
	            $toggleArea.show(300); 
	        }
	        else {
	            $toggleArea.hide(300); 
	        }
	    });	
	});
	$(function() {
	    var $typeSelector = $('#CheckPrefix');
	    var $toggleArea = $('.strict-prefix');
		 if ($typeSelector.val() === 'yes') {
	            $toggleArea.show(); 
	        }
	        else {
	            $toggleArea.hide(); 
	        }
	    $typeSelector.change(function(){
	        if ($typeSelector.val() === 'yes') {
	            $toggleArea.show(300); 
	        }
	        else {
	            $toggleArea.hide(300); 
	        }
	    });	
	});

    $(function() {
        var $typeSelector = $('#Check');
        var $toggleArea = $('#addCountryCodeToStoreOwnerNumber');
        var $showHideOption = $('#showHideOption');
        var $toogleInput = $('#input-store_owner_country_code');
        if ($typeSelector.val() === 'yes') {
            $showHideOption.show();            
            $toggleArea.prop('checked', true); 
            $toogleInput.prop('disabled', true); 
        } else {
            $showHideOption.hide();
            $toggleArea.prop('checked', false);
            $toogleInput.prop('disabled', false);  
            $('#input-store_owner_country_code').val('+1')
        }
        $typeSelector.change(function(){
            if ($typeSelector.val() === 'yes') {
                $showHideOption.show(300);
               $toggleArea.prop('checked', true); 
               $toogleInput.prop('disabled', true);
            $('#input-store_owner_country_code').val($("select[name='smsbump_SelectPhoneNumberPrefix'] option:selected").attr('data-country-code'));
            
            }
            else {
                 $showHideOption.hide(300);
                $toggleArea.prop('checked', false);
                $toogleInput.prop('disabled', false); 
                $('#input-store_owner_country_code').val('+1')
            }
        }); 
    });

    $(function() {
        var $typeSelector = $('#addCountryCodeToStoreOwnerNumber');
        var $toggleArea = $('#input-store_owner_country_code');
         if ($typeSelector.prop('checked') === true) {
                $toggleArea.prop('disabled', true);
                $('#input-store_owner_country_code').val($("select[name='smsbump_SelectPhoneNumberPrefix'] option:selected").attr('data-country-code'));
            }
            else {
                $toggleArea.prop('disabled', false); 
                $('#input-store_owner_country_code').val('+1')
            }
        $typeSelector.change(function(){
            if ($typeSelector.prop('checked') === true) {
               $toggleArea.prop('disabled', true);
               $('#input-store_owner_country_code').val($("select[name='smsbump_SelectPhoneNumberPrefix'] option:selected").attr('data-country-code')); 
            }
            else {
                $toggleArea.prop('disabled', false);
                $('#input-store_owner_country_code').val('+1') 
            }
        }); 
    });

    $("select[name='smsbump_SelectPhoneNumberPrefix']").on("select2:select", function(e) {
        $('#input-store_owner_country_code').val(e.params.data.element.getAttribute('data-country-code'));
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