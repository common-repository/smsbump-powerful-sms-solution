<?php

add_action( 'wp_ajax_search_autocomplete', 'search_autocomplete' );  
add_action( 'wp_ajax_nopriv_search_autocomplete', 'search_autocomplete' ); 

function search_autocomplete(){  
  
    $users = get_users( array(  
        'search' =>$_REQUEST['term']."*",  
    ) );   

    $suggestions=array();   
    foreach ($users as $user) {
        $suggestion = array();  
        $suggestion['name'] = $user->display_name;  
        $suggestion['ID'] = $user->ID; 
        $suggestion['phone'] = get_user_meta($user->ID, "phone", true);
        $suggestions[]= $suggestion;
   } 
    $response = $suggestions;
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;  
}  

?>