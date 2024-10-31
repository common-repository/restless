<?php
/**
 * Plugin Name:     RESTless
 * Plugin URI:      https://burobjorn.nl/floss/wordpress-plugins/restless
 * Description:     RESTless disables REST API calls for non-authenticated users
 * Author:          Bj&ouml;rn Wijers <burobjorn@burobjorn.nl>
 * Author URI:      https://burobjorn.nl
 * Text Domain:     restless
 * Domain Path:     /languages
 * Version:         1.0
 *
 * @package         Restless
 */

/** 
 * Disable access to the REST API for non-authenticated users
 * 
 * This prevents the unwanted 'leaking' of internal WordPress data such as usernames
 * which may be useful for nefarious purposes to the general public. 
 * 
 * Note: 
 * The REST API is still accessible for all (via wp-admin) logged-in users
 *
 * Reference and thanks to: 
 * https://developer.wordpress.org/rest-api/using-the-rest-api/frequently-asked-questions/#require-authentication-for-all-requests
 *
 * @since WordPress 4.4 
 */
if( ! function_exists( 'restless_enable_authenticated_only_rest_api') ) {
  function restless_enable_authenticated_only_rest_api( $result ) {
    if ( is_wp_error($result) ) {
      return $result;
    }
    if ( ! is_user_logged_in() ) {
      return new WP_Error( 'rest_not_logged_in', __('You are not currently logged in.', 'restless'), array( 'status' => 401 ) );
    }
    return $result;
  }
  add_filter( 'rest_authentication_errors', 'restless_enable_authenticated_only_rest_api' ); 
}
