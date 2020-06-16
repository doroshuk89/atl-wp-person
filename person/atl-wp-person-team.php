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

/*register widget*/
require_once ANBLOG_TEST_DIR.'widget/person-carusel-widget.php';
add_action('widgets_init', 'atl_wp_person_widget');
function atl_wp_person_widget ()
    {
        register_widget('ATL_PERSON_CARUSEL');
    }

/*add shortCode*/
add_shortcode( 'personteam', 'views_person_team_carousel' );
function views_person_team_carousel ($atts) {
    if(isset($atts['team'])) {
        $atts['team']=explode(',', $atts['team']);
    }

    if (isset($atts['time_autoscroll']) && !empty($atts['time_autoscroll'])) {
            if ($atts['time_autoscroll'] < 1000) {
                $atts['time_autoscroll'] = 1000;
            }elseif ($atts['time_autoscroll'] > 10000) {
                $atts['time_autoscroll'] = 10000;
            }
    }

    //All terms taxonomy
    $terms = get_terms(['taxonomy' => 'team']);
    foreach ($terms as $item_term) {
        $term[] = $item_term->slug;
    }
    $atts = shortcode_atts( array(
        'team' => $term,
        'count_item' => 1,
        'time_autoscroll' => 3000
    ), $atts );

    /*add JS carousel for content shortcode */
    wp_enqueue_script('atl-wp-carusel-shortcode', ANBLOG_TEST_URL . 'assets/js/atl-wp-carusel-shortcode.js', array('jquery'), null, true);
    wp_localize_script('atl-wp-carusel-shortcode', 'carusel_shortcode', array(
        'time_autoscroll' => (intval($atts['time_autoscroll'])),
        'count_item' => (intval($atts['count_item'])),
    ));

    if ( !is_active_widget(false, false, ATL_PERSON_CARUSEL, true) ) {
            $theme_version = wp_get_theme()->get('Version');
            wp_enqueue_style('owl-carusel-theme', ANBLOG_TEST_URL . 'assets/css/owl.theme.default.min.css', array(), $theme_version);
            wp_enqueue_style('owl-carusel', ANBLOG_TEST_URL . 'assets/css/owl.carousel.min.css', array(), $theme_version);
            wp_enqueue_style('owl-carusel-person', ANBLOG_TEST_URL . 'assets/css/owl-person.css', array(), $theme_version);
            wp_enqueue_script('owl-carusel-js', ANBLOG_TEST_URL . 'assets/js/owl.carousel.min.js', array('jquery'), null, true);
        }
    $params = [
        'post_type'=>'teamperson',
        'tax_query'=>   [
            [
                'taxonomy' => 'team',
                'field'    => 'slug',
                'terms' => $atts['team']
            ]
        ]
    ];
    $views = '<div class="owl-carousel slide-one">';
    $PersonTeam = get_posts($params);
    foreach ($PersonTeam as $item) {
        $views.='<div class="item-carousel-shortcode">';
            $views.= '<a  href ='.get_permalink($item->ID).'>'.$item->post_title. get_the_post_thumbnail( $item->ID ).'</a>';
        $views.='</div>';
    }
    $views.='</div>';
    return $views;
}
?>
