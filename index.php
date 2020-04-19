<?php 

/**
 * Plugin Name: ACF to WP Rest API
 * Plugin URI: https://github.com/perlatsp/acftoapi
 * Description: Add Advanced Custom Fields to the Wordpress REST API for posts and custom post types
 * Author: Perlat Kociaj
 * Version: 0.0.8
 * Requires PHP:      7.2
 * Author URI: https://kociaj.com
*/

defined( 'ABSPATH' ) or die( 'Not today! :D ' );

include('class_ACFTOAPI.php');
include(__DIR__.'/options.php');

$ACFTOAPI= new ACFTOAPI();

//hook into rest_api_init function
$ACFTOAPI->register();
