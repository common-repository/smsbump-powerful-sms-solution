<?php
/*
Plugin Name: SMSBump
Plugin URI: https://isenselabs.com/products/view/smsbump-for-wordpress-simple-sms-solution-for-wordpress/
Description: Simple SMS solution for WordPress.
Version: 1.5
Author: iSenseLabs
Author URI: https://isenselabs.com/
*/

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

function sms_bump_admin_panel() {
    if (function_exists('add_options_page')) {
        add_menu_page(__('SMSBump', 'smsbump'), __('SMSBump', 'smsbump'), 'manage_options', __FILE__, 'smsbump_setting_page',plugins_url('/view/images/smsbump_icon.png', __FILE__));
    }

    add_action('admin_init', 'register_smsbump_settings');
    add_action('admin_init', 'register_smsbump_woo_settings');
}

function register_smsbump_settings() {
    //register our settings
    register_setting( 'smsbump_settings', 'smsbump_apikey' );
    register_setting( 'smsbump_settings', 'smsbump_enabled' );
    register_setting( 'smsbump_settings', 'smsbump_PhoneNumberPrefix' );
    register_setting( 'smsbump_settings', 'smsbump_NumberPrefix' );
    register_setting( 'smsbump_settings', 'smsbump_PhoneRemoveZeros' );
    register_setting( 'smsbump_settings', 'smsbump_StrictPrefix' );
    register_setting( 'smsbump_settings', 'smsbump_StrictNumberPrefix' );
    register_setting( 'smsbump_settings', 'smsbump_StoreOwnerPhoneNumber' );
    register_setting( 'smsbump_settings', 'smsbump_From' );
    register_setting( 'smsbump_settings', 'smsbump_published_comment' );
    register_setting( 'smsbump_settings', 'smsbump_published_comment_text' );
    register_setting( 'smsbump_settings', 'smsbump_registered_user' );
    register_setting( 'smsbump_settings', 'smsbump_registered_user_text' );
    register_setting( 'smsbump_settings', 'smsbump_success_registration_user' );
    register_setting( 'smsbump_settings', 'smsbump_success_registration_user_text' );
    register_setting( 'smsbump_settings', 'smsbump_SelectPhoneNumberPrefix' );
    register_setting( 'smsbump_settings', 'smsbump_NumberPrefix' );
    register_setting( 'smsbump_settings', 'smsbump_CountryCode' );
}

function register_smsbump_woo_settings() {
    //register our settings
    register_setting( 'smsbump_settings', 'smsbump_woo_on_checkout' );
    register_setting( 'smsbump_settings', 'smsbump_woo_on_checkout_text' );
    register_setting( 'smsbump_settings', 'smsbump_woo_on_checkout_user' );
    register_setting( 'smsbump_settings', 'smsbump_woo_on_checkout_user_text' );
    register_setting( 'smsbump_settings', 'smsbump_woo_on_order_status' );
    register_setting( 'smsbump_settings', 'smsbump_woo_on_order_status_text' );
}

add_action('admin_menu', 'sms_bump_admin_panel');

function smsbump_setting_page() {
    wp_enqueue_style('smsbump_bootstrap_css', plugin_dir_url(__FILE__) . 'view/stylesheet/bootstrap.min.css');
    wp_enqueue_style('smsbump_css', plugin_dir_url(__FILE__) . 'view/stylesheet/smsbump.css');
    wp_enqueue_style('smsbump_select2_css', plugin_dir_url(__FILE__) . 'view/stylesheet/select2.css', true);
    wp_enqueue_style('smsbump_font-awesome_css', plugin_dir_url(__FILE__) . 'view/stylesheet/fontawesome/font-awesome.min.css', true);
    wp_enqueue_style( 'thickbox' );
    wp_enqueue_script('smsbump_char_counter_js', plugin_dir_url(__FILE__) . 'view/javascript/charactercounter.js', false);
    wp_enqueue_script('smsbump_bootstrap_js', plugin_dir_url(__FILE__) . 'view/javascript/bootstrap.min.js', true);
    wp_enqueue_script('smsbump_js', plugin_dir_url(__FILE__) . 'view/javascript/smsbump.js', true);
    wp_enqueue_script('smsbump_select2_js', plugin_dir_url(__FILE__) . 'view/javascript/select2.min.js', true);
    wp_enqueue_script( 'thickbox' );

    $smsbump_status = get_option('smsbump_apikey');
    $countries = getCountries();
    $selected_country = get_option('smsbump_CountryCode');
    if(!empty($smsbump_status)) {
        $status = true;
        include_once dirname( __FILE__ ) . "/view/load.php";
    }else{
        $status = true;
        include_once dirname( __FILE__ ) . "/view/login.php";
    }
}


/**
 * Add additional custom field
 */

add_action ( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action ( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields ( $user )
{
?>
    <h3>Extra profile information</h3>
    <table class="form-table">
        <tr>
            <th><label for="phone">Phone number</label></th>
            <td>
                <input type="text" name="phone" placeholder="+1234567890" id="phone" value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description">Please enter your phone number.</span>
            </td>
        </tr>
    </table>
<?php
}

add_action ( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action ( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id )
{
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
    /* Copy and paste this line for additional fields. Make sure to change 'phone' to the field ID. */
    update_usermeta( $user_id, 'phone', $_POST['phone'] );
}

/**
 * Add custom field to registration form
 */

add_action('register_form','show_first_name_field');
add_action('register_post','check_fields',10,3);
add_action('user_register', 'register_extra_fields');

function show_first_name_field()
{
?>
    <p>
    <label>Phone number<br/>
    <input id="phone" type="text" placeholder="+1234567890" tabindex="30" size="25" value="<?php echo $_POST['phone']; ?>" name="phone" />
    </label>
    </p>
<?php
}

function check_fields ( $login, $email, $errors )
{
    global $phone;
    if ( $_POST['phone'] == '' )
    {
        $errors->add( 'empty_realname', "<strong>ERROR</strong>: Please Enter your phone number" );
    }
    else
    {
        $phone = $_POST['phone'];
    }
}

function register_extra_fields ( $user_id, $password = "", $meta = array() )
{
    update_user_meta( $user_id, 'phone', $_POST['phone'] );
}

require_once ("search_autocomplete.php");

function search_ac_init() {
    wp_enqueue_script( 'search_ac', plugin_dir_url(__FILE__) . 'view/javascript/search_ac.js', array('jquery','jquery-ui-autocomplete'),null,true);
    wp_localize_script( 'search_ac', 'MyAcSearch', array('url' => admin_url( 'admin-ajax.php' )));
}
add_action( 'init', 'search_ac_init' );

function wp_comment_inserted($comment_id) {
    if(get_option('smsbump_enabled') == 'yes' && get_option('smsbump_published_comment') == 'yes' && !empty($comment_id)) {
        $comment = get_comment($comment_id);
        $post_title = get_the_title($comment->comment_post_ID);
        $author = $comment->comment_author;

        $message = get_option('smsbump_published_comment_text');
        $message = str_replace('{author}', $author, $message);
        $message = str_replace('{post_title}', $post_title, $message);

        if (!class_exists('SmsBump'))
            include dirname( __FILE__ ) . "/vendors/SmsBump.php";
        $adminNumbers = get_option('smsbump_StoreOwnerPhoneNumber');
        foreach ($adminNumbers as $adminNumber) {
            if(!empty($adminNumber)) {
                SmsBump::sendMessage(array(
                    'APIKey' => get_option('smsbump_apikey'),
                    'to' => $adminNumber,
                    'from' => get_option('smsbump_From'),
                    'message' => $message
                ));
            }
        }
    }
}

add_action('wp_insert_comment','wp_comment_inserted');

function wp_user_registered($user_id) {
    if(get_option('smsbump_enabled') == 'yes') {
        $user = get_user_by( 'id', $user_id );
        $username = $user->user_login;

        $message_to_admin = get_option('smsbump_registered_user_text');
        $message_to_admin = str_replace('{user_name}', $username, $message_to_admin);
        $message_to_user = get_option('smsbump_success_registration_user_text');
        $message_to_user = str_replace('{user_name}', $username, $message_to_user);

        if (!class_exists('SmsBump'))
            include dirname( __FILE__ ) . "/vendors/SmsBump.php";
        if(get_option('smsbump_registered_user') == 'yes') {
            $adminNumbers = get_option('smsbump_StoreOwnerPhoneNumber');
            foreach ($adminNumbers as $adminNumber) {
                if(!empty($adminNumber)) {
                    SmsBump::sendMessage(array(
                        'APIKey' => get_option('smsbump_apikey'),
                        'to' => $adminNumber,
                        'from' => get_option('smsbump_From'),
                        'message' => $message_to_admin
                    ));
                }
            }
        }

        if(get_option('smsbump_success_registration_user') == 'yes') {
            $phone = get_user_meta($user_id, "phone", true);
            $sendCheck = sendCheck($phone);
            if ($sendCheck) {
                SmsBump::sendMessage(array(
                    'APIKey' => get_option('smsbump_apikey'),
                    'to' => $sendCheck,
                    'from' => get_option('smsbump_From'),
                    'message' => $message_to_user
                ));
            }
        }

    }
}

add_action('user_register','wp_user_registered');

function sendCheck($number) {

    $number = str_replace(' ', '', $number);
    $number = str_replace('-', '', $number);
    $number = str_replace('(', '', $number);
    $number = str_replace(')', '', $number);

    if (get_option('smsbump_PhoneNumberPrefix') == 'yes'){
        $prefix = get_option('smsbump_NumberPrefix');

        $numberCheck = ltrim($number, '+');
        $numberCheck = ltrim($numberCheck, '0');
        $prefixCheck = ltrim($prefix, '+');

        $formattedNumber = false;

        if(is_numeric($number)) {
            if ((strpos($number,'+') === 0 || strpos($number, '00') === 0) && strpos($numberCheck,$prefixCheck) === 0) {
                $formattedNumber = '+'.$numberCheck;
            } else if ((strpos($number,'+') === 0 || strpos($number, '00') === 0) && strpos($numberCheck,$prefixCheck) !== 0){
                $formattedNumber = false;
            } else if (strpos($numberCheck, $prefixCheck) !== 0) {
                $formattedNumber = $prefix.$numberCheck;
            } else if((strpos($number,'+') !== 0) && (strpos($number,'00') !== 0) && strpos($numberCheck,$prefixCheck) === 0) {
                $formattedNumber = '+'.$number;
            } else {
                $formattedNumber = false;
            }
        }
        return $formattedNumber;
    }
    return $number;
}

function wpss_admin_js() {
     $siteurl = get_option('siteurl');
     $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/view/javascript/media_uploader.js';
     echo "<script type='text/javascript' src='$url'></script>";
}
add_action('admin_head', 'wpss_admin_js');


/*register_activation_hook(__FILE__, 'my_plugin_activation');
function my_plugin_activation() {
  $notices= get_option('my_plugin_deferred_admin_notices', array());
  $notices[]= "<span style='font-size: 14px;'><a href='admin.php?page=smsbump/smsbump.php&tab=settings' class='button-primary' style='margin-right: 7px;'>Enter API key</a> In order to use the <strong>SMSBump</strong> extension, you have to enter your API key.</span>";
  update_option('my_plugin_deferred_admin_notices', $notices);
}*/

add_action('admin_notices', 'my_plugin_admin_notices');
function my_plugin_admin_notices() {

  if ($notices= get_option('my_plugin_deferred_admin_notices')) {
    foreach ($notices as $notice) {
      echo "<div class='updated'><p>$notice</p></div>";
    }
    delete_option('my_plugin_deferred_admin_notices');
  }

  /*if(!$notices && !get_option('smsbump_apikey')) {
         echo "<div class='updated'><p><span style='font-size: 14px;'><a href='admin.php?page=smsbump/smsbump.php&tab=settings' class='button-primary' style='margin-right: 7px;'>Enter API key</a> In order to use the <strong>SMSBump</strong> extension, you have to enter your API key.</span></p></div>";
    }*/
}

add_action('wp_ajax_smsbump_save_api_key', 'saveApiKey');

function saveApiKey() {
    if(!empty($_POST['data'])) {
        update_option('smsbump_apikey', $_POST['data']);
    }
}


// WooCommerce START

add_action( 'woocommerce_thankyou', 'onWooCheckout' );
function onWooCheckout( $order_id ) {
    if(get_option('smsbump_woo_on_checkout') == 'yes') {
        if (!class_exists('SmsBump'))
            include dirname( __FILE__ ) . "/vendors/SmsBump.php";

        $message = get_option('smsbump_woo_on_checkout_text');
        $message = str_replace('{OrderID}', $order_id, $message);

        $phone = get_option('smsbump_StoreOwnerPhoneNumber');
        $sendCheck = sendCheck($phone);

        if($sendCheck) {
            SmsBump::sendMessage(array(
                'APIKey' => get_option('smsbump_apikey'),
                'to' => $sendCheck,
                'from' => get_option('smsbump_From'),
                'message' => $message
            ));
        }

    }

if(get_option('smsbump_woo_on_checkout_user') == 'yes') {
        if (!class_exists('SmsBump'))
            include dirname( __FILE__ ) . "/vendors/SmsBump.php";
        $order = new WC_Order( $order_id );
        $phone = get_post_meta($order_id, '_billing_phone', true);
        $siteName = get_bloginfo('name');

        $message_to_customer = get_option('smsbump_woo_on_checkout_user_text');
        $message_to_customer = str_replace('{OrderID}', $order_id, $message_to_customer);
        $message_to_customer = str_replace('{SiteName}', $siteName, $message_to_customer);

        $sendCheck = sendCheck($phone);

        if($sendCheck) {
            SmsBump::sendMessage(array(
                'APIKey' => get_option('smsbump_apikey'),
                'to' => $sendCheck,
                'from' => get_option('smsbump_From'),
                'message' => $message_to_customer
            ));
        }
    }
}

add_action('woocommerce_order_status_completed', 'onWooStatusChanged');

function onWooStatusChanged($order_id) {

    if(get_option('smsbump_woo_on_order_status') == 'yes') {
        if (!class_exists('SmsBump'))
            include dirname( __FILE__ ) . "/vendors/SmsBump.php";

        $order = new WC_Order( $order_id );
        $phone = get_post_meta($order_id, '_billing_phone', true);
        $siteName = get_bloginfo('name');

        $message = get_option('smsbump_woo_on_order_status_text');
        $message = str_replace('{OrderID}', $order_id, $message);
        $message = str_replace('{SiteName}', $siteName, $message);

        $sendCheck = sendCheck($phone);

        if($sendCheck) {
            SmsBump::sendMessage(array(
                'APIKey' => get_option('smsbump_apikey'),
                'to' => $sendCheck,
                'from' => get_option('smsbump_From'),
                'message' => $message
            ));
        }
    }
}

// WooCommerce END

function getCountries(){
    $countries = array();
    $countries[] = array("code"=>"AF","name"=>"Afghanistan","d_code"=>"+93");
    $countries[] = array("code"=>"AL","name"=>"Albania","d_code"=>"+355");
    $countries[] = array("code"=>"DZ","name"=>"Algeria","d_code"=>"+213");
    $countries[] = array("code"=>"AS","name"=>"American Samoa","d_code"=>"+1");
    $countries[] = array("code"=>"AD","name"=>"Andorra","d_code"=>"+376");
    $countries[] = array("code"=>"AO","name"=>"Angola","d_code"=>"+244");
    $countries[] = array("code"=>"AI","name"=>"Anguilla","d_code"=>"+1");
    $countries[] = array("code"=>"AG","name"=>"Antigua","d_code"=>"+1");
    $countries[] = array("code"=>"AR","name"=>"Argentina","d_code"=>"+54");
    $countries[] = array("code"=>"AM","name"=>"Armenia","d_code"=>"+374");
    $countries[] = array("code"=>"AW","name"=>"Aruba","d_code"=>"+297");
    $countries[] = array("code"=>"AU","name"=>"Australia","d_code"=>"+61");
    $countries[] = array("code"=>"AT","name"=>"Austria","d_code"=>"+43");
    $countries[] = array("code"=>"AZ","name"=>"Azerbaijan","d_code"=>"+994");
    $countries[] = array("code"=>"BH","name"=>"Bahrain","d_code"=>"+973");
    $countries[] = array("code"=>"BD","name"=>"Bangladesh","d_code"=>"+880");
    $countries[] = array("code"=>"BB","name"=>"Barbados","d_code"=>"+1");
    $countries[] = array("code"=>"BY","name"=>"Belarus","d_code"=>"+375");
    $countries[] = array("code"=>"BE","name"=>"Belgium","d_code"=>"+32");
    $countries[] = array("code"=>"BZ","name"=>"Belize","d_code"=>"+501");
    $countries[] = array("code"=>"BJ","name"=>"Benin","d_code"=>"+229");
    $countries[] = array("code"=>"BM","name"=>"Bermuda","d_code"=>"+1");
    $countries[] = array("code"=>"BT","name"=>"Bhutan","d_code"=>"+975");
    $countries[] = array("code"=>"BO","name"=>"Bolivia","d_code"=>"+591");
    $countries[] = array("code"=>"BA","name"=>"Bosnia and Herzegovina","d_code"=>"+387");
    $countries[] = array("code"=>"BW","name"=>"Botswana","d_code"=>"+267");
    $countries[] = array("code"=>"BR","name"=>"Brazil","d_code"=>"+55");
    $countries[] = array("code"=>"IO","name"=>"British Indian Ocean Territory","d_code"=>"+246");
    $countries[] = array("code"=>"VG","name"=>"British Virgin Islands","d_code"=>"+1");
    $countries[] = array("code"=>"BN","name"=>"Brunei","d_code"=>"+673");
    $countries[] = array("code"=>"BG","name"=>"Bulgaria","d_code"=>"+359");
    $countries[] = array("code"=>"BF","name"=>"Burkina Faso","d_code"=>"+226");
    $countries[] = array("code"=>"MM","name"=>"Burma Myanmar" ,"d_code"=>"+95");
    $countries[] = array("code"=>"BI","name"=>"Burundi","d_code"=>"+257");
    $countries[] = array("code"=>"KH","name"=>"Cambodia","d_code"=>"+855");
    $countries[] = array("code"=>"CM","name"=>"Cameroon","d_code"=>"+237");
    $countries[] = array("code"=>"CA","name"=>"Canada","d_code"=>"+1");
    $countries[] = array("code"=>"CV","name"=>"Cape Verde","d_code"=>"+238");
    $countries[] = array("code"=>"KY","name"=>"Cayman Islands","d_code"=>"+1");
    $countries[] = array("code"=>"CF","name"=>"Central African Republic","d_code"=>"+236");
    $countries[] = array("code"=>"TD","name"=>"Chad","d_code"=>"+235");
    $countries[] = array("code"=>"CL","name"=>"Chile","d_code"=>"+56");
    $countries[] = array("code"=>"CN","name"=>"China","d_code"=>"+86");
    $countries[] = array("code"=>"CO","name"=>"Colombia","d_code"=>"+57");
    $countries[] = array("code"=>"KM","name"=>"Comoros","d_code"=>"+269");
    $countries[] = array("code"=>"CK","name"=>"Cook Islands","d_code"=>"+682");
    $countries[] = array("code"=>"CR","name"=>"Costa Rica","d_code"=>"+506");
    $countries[] = array("code"=>"CI","name"=>"Côte d'Ivoire" ,"d_code"=>"+225");
    $countries[] = array("code"=>"HR","name"=>"Croatia","d_code"=>"+385");
    $countries[] = array("code"=>"CU","name"=>"Cuba","d_code"=>"+53");
    $countries[] = array("code"=>"CY","name"=>"Cyprus","d_code"=>"+357");
    $countries[] = array("code"=>"CZ","name"=>"Czech Republic","d_code"=>"+420");
    $countries[] = array("code"=>"CD","name"=>"Democratic Republic of Congo","d_code"=>"+243");
    $countries[] = array("code"=>"DK","name"=>"Denmark","d_code"=>"+45");
    $countries[] = array("code"=>"DJ","name"=>"Djibouti","d_code"=>"+253");
    $countries[] = array("code"=>"DM","name"=>"Dominica","d_code"=>"+1");
    $countries[] = array("code"=>"DO","name"=>"Dominican Republic","d_code"=>"+1");
    $countries[] = array("code"=>"EC","name"=>"Ecuador","d_code"=>"+593");
    $countries[] = array("code"=>"EG","name"=>"Egypt","d_code"=>"+20");
    $countries[] = array("code"=>"SV","name"=>"El Salvador","d_code"=>"+503");
    $countries[] = array("code"=>"GQ","name"=>"Equatorial Guinea","d_code"=>"+240");
    $countries[] = array("code"=>"ER","name"=>"Eritrea","d_code"=>"+291");
    $countries[] = array("code"=>"EE","name"=>"Estonia","d_code"=>"+372");
    $countries[] = array("code"=>"ET","name"=>"Ethiopia","d_code"=>"+251");
    $countries[] = array("code"=>"FK","name"=>"Falkland Islands","d_code"=>"+500");
    $countries[] = array("code"=>"FO","name"=>"Faroe Islands","d_code"=>"+298");
    $countries[] = array("code"=>"FM","name"=>"Federated States of Micronesia","d_code"=>"+691");
    $countries[] = array("code"=>"FJ","name"=>"Fiji","d_code"=>"+679");
    $countries[] = array("code"=>"FI","name"=>"Finland","d_code"=>"+358");
    $countries[] = array("code"=>"FR","name"=>"France","d_code"=>"+33");
    $countries[] = array("code"=>"GF","name"=>"French Guiana","d_code"=>"+594");
    $countries[] = array("code"=>"PF","name"=>"French Polynesia","d_code"=>"+689");
    $countries[] = array("code"=>"GA","name"=>"Gabon","d_code"=>"+241");
    $countries[] = array("code"=>"GE","name"=>"Georgia","d_code"=>"+995");
    $countries[] = array("code"=>"DE","name"=>"Germany","d_code"=>"+49");
    $countries[] = array("code"=>"GH","name"=>"Ghana","d_code"=>"+233");
    $countries[] = array("code"=>"GI","name"=>"Gibraltar","d_code"=>"+350");
    $countries[] = array("code"=>"GR","name"=>"Greece","d_code"=>"+30");
    $countries[] = array("code"=>"GL","name"=>"Greenland","d_code"=>"+299");
    $countries[] = array("code"=>"GD","name"=>"Grenada","d_code"=>"+1");
    $countries[] = array("code"=>"GP","name"=>"Guadeloupe","d_code"=>"+590");
    $countries[] = array("code"=>"GU","name"=>"Guam","d_code"=>"+1");
    $countries[] = array("code"=>"GT","name"=>"Guatemala","d_code"=>"+502");
    $countries[] = array("code"=>"GN","name"=>"Guinea","d_code"=>"+224");
    $countries[] = array("code"=>"GW","name"=>"Guinea-Bissau","d_code"=>"+245");
    $countries[] = array("code"=>"GY","name"=>"Guyana","d_code"=>"+592");
    $countries[] = array("code"=>"HT","name"=>"Haiti","d_code"=>"+509");
    $countries[] = array("code"=>"HN","name"=>"Honduras","d_code"=>"+504");
    $countries[] = array("code"=>"HK","name"=>"Hong Kong","d_code"=>"+852");
    $countries[] = array("code"=>"HU","name"=>"Hungary","d_code"=>"+36");
    $countries[] = array("code"=>"IS","name"=>"Iceland","d_code"=>"+354");
    $countries[] = array("code"=>"IN","name"=>"India","d_code"=>"+91");
    $countries[] = array("code"=>"ID","name"=>"Indonesia","d_code"=>"+62");
    $countries[] = array("code"=>"IR","name"=>"Iran","d_code"=>"+98");
    $countries[] = array("code"=>"IQ","name"=>"Iraq","d_code"=>"+964");
    $countries[] = array("code"=>"IE","name"=>"Ireland","d_code"=>"+353");
    $countries[] = array("code"=>"IL","name"=>"Israel","d_code"=>"+972");
    $countries[] = array("code"=>"IT","name"=>"Italy","d_code"=>"+39");
    $countries[] = array("code"=>"JM","name"=>"Jamaica","d_code"=>"+1");
    $countries[] = array("code"=>"JP","name"=>"Japan","d_code"=>"+81");
    $countries[] = array("code"=>"JO","name"=>"Jordan","d_code"=>"+962");
    $countries[] = array("code"=>"KZ","name"=>"Kazakhstan","d_code"=>"+7");
    $countries[] = array("code"=>"KE","name"=>"Kenya","d_code"=>"+254");
    $countries[] = array("code"=>"KI","name"=>"Kiribati","d_code"=>"+686");
    //$countries[] = array("code"=>"XK","name"=>"Kosovo","d_code"=>"+381");
    $countries[] = array("code"=>"KW","name"=>"Kuwait","d_code"=>"+965");
    $countries[] = array("code"=>"KG","name"=>"Kyrgyzstan","d_code"=>"+996");
    $countries[] = array("code"=>"LA","name"=>"Laos","d_code"=>"+856");
    $countries[] = array("code"=>"LV","name"=>"Latvia","d_code"=>"+371");
    $countries[] = array("code"=>"LB","name"=>"Lebanon","d_code"=>"+961");
    $countries[] = array("code"=>"LS","name"=>"Lesotho","d_code"=>"+266");
    $countries[] = array("code"=>"LR","name"=>"Liberia","d_code"=>"+231");
    $countries[] = array("code"=>"LY","name"=>"Libya","d_code"=>"+218");
    $countries[] = array("code"=>"LI","name"=>"Liechtenstein","d_code"=>"+423");
    $countries[] = array("code"=>"LT","name"=>"Lithuania","d_code"=>"+370");
    $countries[] = array("code"=>"LU","name"=>"Luxembourg","d_code"=>"+352");
    $countries[] = array("code"=>"MO","name"=>"Macau","d_code"=>"+853");
    $countries[] = array("code"=>"MK","name"=>"Macedonia","d_code"=>"+389");
    $countries[] = array("code"=>"MG","name"=>"Madagascar","d_code"=>"+261");
    $countries[] = array("code"=>"MW","name"=>"Malawi","d_code"=>"+265");
    $countries[] = array("code"=>"MY","name"=>"Malaysia","d_code"=>"+60");
    $countries[] = array("code"=>"MV","name"=>"Maldives","d_code"=>"+960");
    $countries[] = array("code"=>"ML","name"=>"Mali","d_code"=>"+223");
    $countries[] = array("code"=>"MT","name"=>"Malta","d_code"=>"+356");
    $countries[] = array("code"=>"MH","name"=>"Marshall Islands","d_code"=>"+692");
    $countries[] = array("code"=>"MQ","name"=>"Martinique","d_code"=>"+596");
    $countries[] = array("code"=>"MR","name"=>"Mauritania","d_code"=>"+222");
    $countries[] = array("code"=>"MU","name"=>"Mauritius","d_code"=>"+230");
    $countries[] = array("code"=>"YT","name"=>"Mayotte","d_code"=>"+262");
    $countries[] = array("code"=>"MX","name"=>"Mexico","d_code"=>"+52");
    $countries[] = array("code"=>"MD","name"=>"Moldova","d_code"=>"+373");
    $countries[] = array("code"=>"MC","name"=>"Monaco","d_code"=>"+377");
    $countries[] = array("code"=>"MN","name"=>"Mongolia","d_code"=>"+976");
    $countries[] = array("code"=>"ME","name"=>"Montenegro","d_code"=>"+382");
    $countries[] = array("code"=>"MS","name"=>"Montserrat","d_code"=>"+1");
    $countries[] = array("code"=>"MA","name"=>"Morocco","d_code"=>"+212");
    $countries[] = array("code"=>"MZ","name"=>"Mozambique","d_code"=>"+258");
    $countries[] = array("code"=>"NA","name"=>"Namibia","d_code"=>"+264");
    $countries[] = array("code"=>"NR","name"=>"Nauru","d_code"=>"+674");
    $countries[] = array("code"=>"NP","name"=>"Nepal","d_code"=>"+977");
    $countries[] = array("code"=>"NL","name"=>"Netherlands","d_code"=>"+31");
    $countries[] = array("code"=>"AN","name"=>"Netherlands Antilles","d_code"=>"+599");
    $countries[] = array("code"=>"NC","name"=>"New Caledonia","d_code"=>"+687");
    $countries[] = array("code"=>"NZ","name"=>"New Zealand","d_code"=>"+64");
    $countries[] = array("code"=>"NI","name"=>"Nicaragua","d_code"=>"+505");
    $countries[] = array("code"=>"NE","name"=>"Niger","d_code"=>"+227");
    $countries[] = array("code"=>"NG","name"=>"Nigeria","d_code"=>"+234");
    $countries[] = array("code"=>"NU","name"=>"Niue","d_code"=>"+683");
    $countries[] = array("code"=>"NF","name"=>"Norfolk Island","d_code"=>"+672");
    $countries[] = array("code"=>"KP","name"=>"North Korea","d_code"=>"+850");
    $countries[] = array("code"=>"MP","name"=>"Northern Mariana Islands","d_code"=>"+1");
    $countries[] = array("code"=>"NO","name"=>"Norway","d_code"=>"+47");
    $countries[] = array("code"=>"OM","name"=>"Oman","d_code"=>"+968");
    $countries[] = array("code"=>"PK","name"=>"Pakistan","d_code"=>"+92");
    $countries[] = array("code"=>"PW","name"=>"Palau","d_code"=>"+680");
    $countries[] = array("code"=>"PS","name"=>"Palestine","d_code"=>"+970");
    $countries[] = array("code"=>"PA","name"=>"Panama","d_code"=>"+507");
    $countries[] = array("code"=>"PG","name"=>"Papua New Guinea","d_code"=>"+675");
    $countries[] = array("code"=>"PY","name"=>"Paraguay","d_code"=>"+595");
    $countries[] = array("code"=>"PE","name"=>"Peru","d_code"=>"+51");
    $countries[] = array("code"=>"PH","name"=>"Philippines","d_code"=>"+63");
    $countries[] = array("code"=>"PL","name"=>"Poland","d_code"=>"+48");
    $countries[] = array("code"=>"PT","name"=>"Portugal","d_code"=>"+351");
    $countries[] = array("code"=>"PR","name"=>"Puerto Rico","d_code"=>"+1");
    $countries[] = array("code"=>"QA","name"=>"Qatar","d_code"=>"+974");
    $countries[] = array("code"=>"CG","name"=>"Republic of the Congo","d_code"=>"+242");
    $countries[] = array("code"=>"RE","name"=>"Réunion" ,"d_code"=>"+262");
    $countries[] = array("code"=>"RO","name"=>"Romania","d_code"=>"+40");
    $countries[] = array("code"=>"RU","name"=>"Russia","d_code"=>"+7");
    $countries[] = array("code"=>"RW","name"=>"Rwanda","d_code"=>"+250");
    //$countries[] = array("code"=>"BL","name"=>"Saint Barthélemy" ,"d_code"=>"+590");
    $countries[] = array("code"=>"SH","name"=>"Saint Helena","d_code"=>"+290");
    $countries[] = array("code"=>"KN","name"=>"Saint Kitts and Nevis","d_code"=>"+1");
    //$countries[] = array("code"=>"MF","name"=>"Saint Martin","d_code"=>"+590");
    $countries[] = array("code"=>"PM","name"=>"Saint Pierre and Miquelon","d_code"=>"+508");
    $countries[] = array("code"=>"VC","name"=>"Saint Vincent and the Grenadines","d_code"=>"+1");
    $countries[] = array("code"=>"WS","name"=>"Samoa","d_code"=>"+685");
    $countries[] = array("code"=>"SM","name"=>"San Marino","d_code"=>"+378");
    $countries[] = array("code"=>"ST","name"=>"São Tomé and Príncipe" ,"d_code"=>"+239");
    $countries[] = array("code"=>"SA","name"=>"Saudi Arabia","d_code"=>"+966");
    $countries[] = array("code"=>"SN","name"=>"Senegal","d_code"=>"+221");
    $countries[] = array("code"=>"RS","name"=>"Serbia","d_code"=>"+381");
    $countries[] = array("code"=>"SC","name"=>"Seychelles","d_code"=>"+248");
    $countries[] = array("code"=>"SL","name"=>"Sierra Leone","d_code"=>"+232");
    $countries[] = array("code"=>"SG","name"=>"Singapore","d_code"=>"+65");
    $countries[] = array("code"=>"SK","name"=>"Slovakia","d_code"=>"+421");
    $countries[] = array("code"=>"SI","name"=>"Slovenia","d_code"=>"+386");
    $countries[] = array("code"=>"SB","name"=>"Solomon Islands","d_code"=>"+677");
    $countries[] = array("code"=>"SO","name"=>"Somalia","d_code"=>"+252");
    $countries[] = array("code"=>"ZA","name"=>"South Africa","d_code"=>"+27");
    $countries[] = array("code"=>"KR","name"=>"South Korea","d_code"=>"+82");
    $countries[] = array("code"=>"ES","name"=>"Spain","d_code"=>"+34");
    $countries[] = array("code"=>"LK","name"=>"Sri Lanka","d_code"=>"+94");
    $countries[] = array("code"=>"LC","name"=>"St. Lucia","d_code"=>"+1");
    $countries[] = array("code"=>"SD","name"=>"Sudan","d_code"=>"+249");
    $countries[] = array("code"=>"SR","name"=>"Suriname","d_code"=>"+597");
    $countries[] = array("code"=>"SZ","name"=>"Swaziland","d_code"=>"+268");
    $countries[] = array("code"=>"SE","name"=>"Sweden","d_code"=>"+46");
    $countries[] = array("code"=>"CH","name"=>"Switzerland","d_code"=>"+41");
    $countries[] = array("code"=>"SY","name"=>"Syria","d_code"=>"+963");
    $countries[] = array("code"=>"TW","name"=>"Taiwan","d_code"=>"+886");
    $countries[] = array("code"=>"TJ","name"=>"Tajikistan","d_code"=>"+992");
    $countries[] = array("code"=>"TZ","name"=>"Tanzania","d_code"=>"+255");
    $countries[] = array("code"=>"TH","name"=>"Thailand","d_code"=>"+66");
    $countries[] = array("code"=>"BS","name"=>"The Bahamas","d_code"=>"+1");
    $countries[] = array("code"=>"GM","name"=>"The Gambia","d_code"=>"+220");
    $countries[] = array("code"=>"TL","name"=>"Timor-Leste","d_code"=>"+670");
    $countries[] = array("code"=>"TG","name"=>"Togo","d_code"=>"+228");
    $countries[] = array("code"=>"TK","name"=>"Tokelau","d_code"=>"+690");
    $countries[] = array("code"=>"TO","name"=>"Tonga","d_code"=>"+676");
    $countries[] = array("code"=>"TT","name"=>"Trinidad and Tobago","d_code"=>"+1");
    $countries[] = array("code"=>"TN","name"=>"Tunisia","d_code"=>"+216");
    $countries[] = array("code"=>"TR","name"=>"Turkey","d_code"=>"+90");
    $countries[] = array("code"=>"TM","name"=>"Turkmenistan","d_code"=>"+993");
    $countries[] = array("code"=>"TC","name"=>"Turks and Caicos Islands","d_code"=>"+1");
    $countries[] = array("code"=>"TV","name"=>"Tuvalu","d_code"=>"+688");
    $countries[] = array("code"=>"UG","name"=>"Uganda","d_code"=>"+256");
    $countries[] = array("code"=>"UA","name"=>"Ukraine","d_code"=>"+380");
    $countries[] = array("code"=>"AE","name"=>"United Arab Emirates","d_code"=>"+971");
    $countries[] = array("code"=>"GB","name"=>"United Kingdom","d_code"=>"+44");
    $countries[] = array("code"=>"US","name"=>"United States","d_code"=>"+1");
    $countries[] = array("code"=>"UY","name"=>"Uruguay","d_code"=>"+598");
    $countries[] = array("code"=>"VI","name"=>"US Virgin Islands","d_code"=>"+1");
    $countries[] = array("code"=>"UZ","name"=>"Uzbekistan","d_code"=>"+998");
    $countries[] = array("code"=>"VU","name"=>"Vanuatu","d_code"=>"+678");
    $countries[] = array("code"=>"VA","name"=>"Vatican City","d_code"=>"+39");
    $countries[] = array("code"=>"VE","name"=>"Venezuela","d_code"=>"+58");
    $countries[] = array("code"=>"VN","name"=>"Vietnam","d_code"=>"+84");
    $countries[] = array("code"=>"WF","name"=>"Wallis and Futuna","d_code"=>"+681");
    $countries[] = array("code"=>"YE","name"=>"Yemen","d_code"=>"+967");
    $countries[] = array("code"=>"ZM","name"=>"Zambia","d_code"=>"+260");
    $countries[] = array("code"=>"ZW","name"=>"Zimbabwe","d_code"=>"+263");

    return $countries;
}
