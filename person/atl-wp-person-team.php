<?php
/*
Plugin Name: PersonTeam
Plugin URI:https://atlas-it.by/wordpress/plugins/person-team/ 
Description: Плагин создания PersonTeam 
Version:v1.0
Author: Atlas
Author URI: http://atlas-it.by
*/

define('ANBLOG_TEST_DIR', plugin_dir_path(__FILE__));     //полный путь к корню папки плагина (от сервера)
define('ANBLOG_TEST_URL', plugin_dir_url(__FILE__));      //путь к корню папки плагина (лучше его использовать)

/*file functions*/
require_once __DIR__ . '/includes/functions.php';
/*Add metadata Phone, Address, Email*/
require_once __DIR__.'/classes/CreateMetabox.php';
    $options = require_once __DIR__.'/config/metabox.php';
        foreach ($options as $option)
            {
                new CreateMetabox($option);
            }
            
/*Create template for custom post type*/
add_filter( 'template_include', 'include_template_function', 1 );
function include_template_function( $template_path ) {
    if ( get_post_type() == 'teamperson' ) {
        if ( is_single() ) {
            if ( $theme_file = locate_template( array ( 'single-teamperson.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . 'templates/single-persons.php';
            }
        }
    }
    return $template_path;
}
?>
