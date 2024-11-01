<div class="wrap">
	<div id="smsbump-container">
		<div id="heading">
			<h2>SMSBump Settings</h2>&nbsp;&nbsp;<span class="fa fa-refresh fa-spin"></span><span id="status"></span>
		</div>
		
		<form method="post" action="options.php" name="form">
			<?php settings_fields( 'smsbump_settings' ); ?>
			<?php do_settings_sections( 'smsbump_settings' ); ?>
			<?php $enabled = get_option('smsbump_enabled'); ?>
			<?php $smsbump_PhoneNumberPrefix = get_option('smsbump_PhoneNumberPrefix'); ?>
			<?php $strictPrefix = get_option('smsbump_StrictPrefix'); ?>
			<?php $published_comment = get_option('smsbump_published_comment'); ?>
			<?php $registered_user = get_option('smsbump_registered_user'); ?>
			<?php $success_registration_user = get_option('smsbump_success_registration_user'); ?>
			<?php $smsbump_woo_on_checkout = get_option('smsbump_woo_on_checkout'); ?>
			<?php $smsbump_woo_on_checkout_user = get_option('smsbump_woo_on_checkout_user'); ?>
			<?php $smsbump_woo_on_order_status = get_option('smsbump_woo_on_order_status'); ?>
			<?php $smsbump_SelectPhoneNumberPrefix = get_option('smsbump_SelectPhoneNumberPrefix'); ?>
			<?php $smsbump_NumberPrefix = get_option('smsbump_NumberPrefix'); ?>
			<?php $smsbump_CountryCode = get_option('smsbump_CountryCode'); ?>
			<?php $smsbump_StoreOwnerPhoneNumber = get_option('smsbump_StoreOwnerPhoneNumber'); ?>
			
			<ul class="nav nav-tabs nav-tab-wrapper">
				<li><a class="nav-tab" href="#app" data-toggle="tab">General</a></li>
				<li><a class="nav-tab" href="#bulk" data-toggle="tab">Bulk</a></li>
				<?php if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) { ?>
				<li><a class="nav-tab" href="#woocommerce" data-toggle="tab">WooCommerce</a></li>
				<?php } ?>
				<li><a class="nav-tab" href="#settings" data-toggle="tab">Settings</a></li>
				<li><a class="nav-tab" href="#help" data-toggle="tab">Help</a></li>
			</ul>		
			<div class="tab-content">
				<div id="app" class="tab-pane fade in active">
					<?php require_once "app.php"; ?>
				</div>
				<div id="bulk" class="tab-pane fade">
					<?php require_once "bulk.php"; ?>
				</div>
				<?php if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) { ?>
				<div id="woocommerce" class="tab-pane fade">
					<?php require_once "woocommerce.php"; ?>
				</div>
				<?php } ?>
				<div id="settings" class="tab-pane fade in active">
					<?php require_once "settings.php"; ?>
				</div>
				<div id="help" class="tab-pane fade">
					<?php require_once "help.php"; ?>
				</div>
			</div>
			<tr>
				<td>
					<?php submit_button(); ?>
				</td>
			</tr>
		</form>
	</div>
</div>
	<script>
	 
	(function($) {
		var $ = jQuery;
		    
		<?php if($status) { ?>  
		   $('.fa-spin').css('display','inline-block'); 
		<?php } else { ?>   
		    $('.fa-spin').css('display','none');
		    $(window).load(function(){
		       $('#app_info').parent().click();
		    });
		<?php } ?>

	$(function() {
    $('.mainMenuTabs a:first').tab('show'); // Select first tab
     $('.mainMenuTabs a:first').click();
    if (window.localStorage && window.localStorage['currentTab']) {
        $('.mainMenuTabs a[href="'+window.localStorage['currentTab']+'"]').tab('show');
    }
    if (window.localStorage && window.localStorage['currentSubTab']) {
        $('a[href="'+window.localStorage['currentSubTab']+'"]').tab('show');
    }
    $('.fadeInOnLoad').css('visibility','visible');
    $('.mainMenuTabs a[data-toggle="tab"]').click(function() {
        if (window.localStorage) {
            window.localStorage['currentTab'] = $(this).attr('href');
        }
    });
    $('a[data-toggle="tab"]:not(.mainMenuTabs a[data-toggle="tab"], #app_info a[data-toggle="tab"])').click(function() {
        if (window.localStorage) {
            window.localStorage['currentSubTab'] = $(this).attr('href');
        }
    });
});
})(jQuery);
</script>