<div class="wrap">
	<div id="smsbump-container">
		<div class="row">
			<div class="col-md-12">
				<div id="login-container">
			        <h3>Welcome to SMSBump for WordPress!</h3>
			        <p>This page will help you to connect your WordPress store with SMSBump in few steps.</p>
			        <img src="<?= plugin_dir_url(__FILE__) ?>/images/smsbumpwp.jpg" alt="SMSBump"/>
			        <hr />
			        <h3>Let's Get Started!</h3>
			        <p>In order to connect SMSBump with WordPress we need your email address and phone number for authorization. Once you provide email and phone, you have to validate your account. A validation code will be sent to your phone.</p>
			        <p>If you already have a SMSBump account use your registered email and phone to connect SMSBump with WordPress.</p>
			        <form class="form-default" id="login-form" action="" method="post">
			            <div id="submitdiv" class="postbox ">
			            	<h3>Welcome</h3>
                            <h2>Enter email address and phone number to start using SMSBump</h2>
                            <div class="alert alert-danger autoSlideUp" id="response_error">
                                <span id="error_message"></span>
                               <span data-toggle="tooltip" data-placement="bottom" title="Use this option in case you have entered wrong phone number during your initial registration."><a class="reset_account_button" href="javascript:void(0)">Reset account and start over</a></span>
                            </div>
			            	 <input name="login_email" type="email" class="form-control" placeholder="Email address">
                            <select name="country_code" class="form-control" >
                                 <?php foreach ($countries as $country) { ?>
                                    <option data-country-code="<?php echo strtolower($country['d_code']); ?>" value="<?php echo strtolower($country['code']); ?>" <?php echo (!empty($country['code']) && $country['code'] == 'US') ? 'selected=selected' : '' ?>><?php echo $country['name'] ?> </option>
                                  <?php } ?>
                            </select>
                             <div class="input-group">
                                    <span class="input-group-addon login_country_code">+1</span>
                                    <input name="login_country_code" type="hidden" value="+1"/>
			                		<input name="login_phone" type="text" class="form-control" placeholder="+1234567890"/>
                            </div>
                            <div class="e-submit">
                                <button type="submit" class="btn btn-primary" id="login-form-submit"  value="Log in">Verify my number</button>
                            </div>
                             <span data-toggle="tooltip" data-placement="bottom" title="Use this option in case you have entered wrong phone number during your initial registration."><a class="reset_account_button"  class="reset_" href="javascript:void(0)">Reset account and start over</a></span>
			                <div class="clearfix"></div>
			            </div>
			        </form>
			        <!-- confirm phone number modal -->
                    <div class="modal fade" id="confirm_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
                      <div class="modal-dialog " role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <img src="<?= plugin_dir_url(__FILE__) ?>/images/smsbumplogo.png" alt="SMSBump"/>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          </div>
                          <div class="modal-body">
                            <h4 class="modal-title"></h4>
                          </div>
                          <div class="modal-footer">
                            <button id="confirm_button" type="button" class="btn btn-success">Yes</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- reset account modal -->
                    <div class="modal fade" id="reset_account" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog " role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <img src="<?= plugin_dir_url(__FILE__) ?>/images/smsbumplogo.png" alt="SMSBump"/>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          </div>
                          <div class="modal-body">
                            <form>
                              <div class="form-group">
                                <div class="alert alert-danger autoSlideUp" id="reset_email_error">
                                    <span id="wrong_email"></span>
                                </div>
                                <label for="recipient-name" class="control-label">Please enter your email address</label>
                                <input type="text" class="form-control" id="reset_email">
                              </div>
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button id="reset_button" type="button" class="btn btn-primary">Reset account</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <form class="form-default" id="confirm-form" method="post" style="display:none;">
	                    <div class="postbox">
	                        <h3>Confirm</h3>
	                         <div id="verification_code" class="alert alert-success">
	                          	<span></span>
	                         </div>
	                        <input name="confirm_code" type="text" class="form-control" placeholder="Verification code"/>
	                        <div class="e e-submit">
	                         	<button type="submit"  class="btn btn-primary" id="confirm-form-submit" value="Confirm">Confirm my account</button>                </div>
	                        <div class="e-submit" >
	                           <button onclick="location.reload()" class="btn btn-default">Back</button>
	                        </div>
	                     </div>
	                    <input name="store_id" type="hidden" class="form-control" value="<?= $store_id ?>">
	                    <input name="login_email" type="hidden" class="form-control" value="<?= $email ?>">
	                    <input name="login_phone" type="hidden" class="form-control" value="<?= $phone ?>">
	                </form>
			       <!--  <form class="form-default" id="confirm-form" action="" method="post" style="display:none;">
			            <div id="submitdiv" class="postbox ">
			            	<h3 class="hndle ui-sortable-handle"><span>Confirm</span></h3>
			                	<div class="row">
			                			<span class="input-label"><strong>Confirmation code</strong></span>
				                		<input name="confirm_code" type="text" class="form-control" placeholder=""/>
			                	</div>
			                <button type="submit" class="btn btn-primary" id="confirm-form-submit" value="Confirm">Confirm</button>
			            </div>
			        </form> -->
			        <p>Email at <a href="mailto:sales@smsbump.com?subject=Questions on SMSBUMP">sales@smsbump.com</a>, if you have any problems, questions or you just want to thank us for the good service.</p>
			    </div>
			</div>
 		</div>
	 </div>

	 <script>
	 	(function($) {
		    var $ = jQuery;

		    function validateLogin() {
	            var error = "";
	            if($('[name="login_email"]').val().length < 1 || $('[name="login_phone"]').val().length < 1) {
	                error = "All fields must be filled!";
	                return error;
	            }

            	return error;
       		}
	        $('#login-form-submit').on('click', function(e) {
	            e.preventDefault();
	            e.stopPropagation();
	            $('#response_error').slideUp("slow");
	            var validate = validateLogin();
	            if(validate.length < 1) {

	            	 $('#confirm_modal').modal('show')
                     $('#confirm_modal').on('shown.bs.modal', function () {
                      var country_code = $('[name="login_country_code"]').val();
                      var number = $('[name="login_phone"]').val();
                      var modal = $(this);
                      modal.find('.modal-title').html('Are you sure that <strong>' + country_code +' '+ number + '</strong> is the correct number?')
                    })

                    $('#confirm_button').on('click', function(){
                    	$('#confirm_modal').modal('hide');
                    	var customer_phone = $('[name="login_country_code"]').val() + $('[name="login_phone"]').val();
	                $.ajax({
	                    url: '<?php echo htmlspecialchars_decode("https://api.smsbump.com/userlogon/1f8DSYextlR1.json") ?>',
	                    type: 'GET',
	                    data: { email: $('[name="login_email"]').val(),
	                            phone: customer_phone
	                          },
	                    success: function (response) {
	                        if(response.status == "success" && !response.data.user) {
	                           $('#confirm-form h2').html(response.data.message);
	                           $('#verification_code span').html(response.data.message);
	                           $('#login-form').slideUp();
	                           $('#confirm-form').slideDown();
	                           $('#confirm-form-submit').on('click', function (event) {
	                                event.preventDefault();
	                                event.stopPropagation();

	                                $.ajax({
	                                    url: '<?php echo htmlspecialchars_decode("https://api.smsbump.com/userlogon/1f8DSYextlR1.json") ?>',
	                                    type: 'GET',
	                                    data: { //store_id: $('[name="store_id"]').val(),
	                                            email: $('[name="login_email"]').val(),
	                                            phone: customer_phone,
	                                            code:  $('[name="confirm_code"]').val()
	                                          },
	                                    success: function(result) {
	                                        if(result.status == "success" && result.data.user.apps.apikey) {
	                                        	jQuery.post(
												    ajaxurl,
												    {
												        'action': 'smsbump_save_api_key',
												        'data':   result.data.user.apps.apikey
												    },
												    function(response){
												       window.location.reload();
												    }
												);
	                                        } else if(result.status == "error") {
	                                            alert(result.data.message);
	                                        }
	                                    }
	                                });
	                           });
	                        } else if(response.status == "success" && response.data.user.apps.apikey) {
	                        	jQuery.post(
								    ajaxurl,
								    {
								        'action': 'smsbump_save_api_key',
								        'data':   response.data.user.apps.apikey
								    },
								    function(response){
								       window.location.reload();
								    }
								);
	                        } else if(response.status == "error") {
	                        	$('#response_error #error_message').html(response.data.message);
                                $('#response_error').slideDown("slow");
                                //$('#response_error').slideDown("slow").delay(5000).slideUp("slow");
	                            // alert(response.data.message);
	                        }
	                    }
	                });
	            });
	            } else {
	                alert(validate);
	            }
	        });

	    function formatState (state) {
            if (!state.id) { return state.text; }

          var $state = $(
            '<span><img src="<?= plugin_dir_url(__FILE__) ?>/images/smsbump/country_flags/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span><span style="float:right;" class="dial_code">('+state.element.getAttribute('data-country-code').toLowerCase()+')</span>'
          );

          return $state;
        };

        $(document).ready(function() {
            $("select[name='country_code']").select2({
              templateResult: formatState,
              templateSelection: formatState
            });

            $("select[name='country_code']").on("select2:select", function(e) {
                $('.login_country_code').html(e.params.data.element.getAttribute('data-country-code'));
                $('input[name="login_country_code"]').val(e.params.data.element.getAttribute('data-country-code'));
            });
        });

	    function validateEmail(email){
            var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (pattern.test(email)) {
                return (true)
            }
            return (false)
        };

        $('.reset_account_button').on('click', function (e) {

             $('#reset_account').modal('show');
             $('#reset_account').on('shown.bs.modal', function () {

                $('#reset_button').click(function(e) {
                     $('#reset_email_error').slideUp("slow");
                    e.preventDefault();
                    e.stopPropagation();

                    if ( $('#reset_email').val().length > 1 && validateEmail($('#reset_email').val()))  {

                        $.ajax({
                            url: '<?php echo htmlspecialchars_decode("https://api.smsbump.com/userlogon/1f8DSYextlR1.json") ?>',
                            type: 'GET',
                            data: { email: $('#reset_email').val(),
                                    phone: '',
                                    reset: true
                            },
                            dataType: "json",
                            success: function(response){
                                if (response.status == 'error') {
                                    alert(response.data.message);
                                } else {
                                    alert(response.data.message);
                                     $('#reset_account').modal('hide');
                                }
                            }
                        });
                    } else {
                        $('#reset_email_error #wrong_email').html('Please enter a valid email address');
                        $('#reset_email_error').slideDown("slow");

                    }
                });
            });
        });

	 	$(document).ready(function() {
			$("body").tooltip({ selector: '[data-toggle=tooltip]' });
		});

		})(jQuery);


	 </script>
