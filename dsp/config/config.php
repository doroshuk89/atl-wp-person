<?php

global $wpdb;
/*Название таблицы видов ДСП*/
define('DSP_TYPE', $wpdb->get_blog_prefix() .  'cash_dsp_type');
/*Название таблицы толщины ДСП*/
define('DSP_WIDTH', $wpdb->get_blog_prefix() . 'cash_dsp_width');
/*Название таблицы видов кромки*/
define('EDGE_TYPE', $wpdb->get_blog_prefix() . 'cash_edge_type');
/*Название таблицы размеров кромки*/
define('EDGE_SIZE', $wpdb->get_blog_prefix() . 'cash_edge_size');
/*Название таблицы цветов*/
define('COLOR_ITEM',$wpdb->get_blog_prefix() . 'cash_color_dsp_edge');
/*Название кросстаблицы цветов и дсп*/
define('COLOR_CROSS_DSP', $wpdb->get_blog_prefix() . 'cash_dsp_color_cross');
/*Название кросстаблицы цветов и кромки*/
define('COLOR_CROSS_EDGE',$wpdb->get_blog_prefix() . 'cash_edge_color_cross');
/*Константа для ОШИБКИ*/
define('ERROR_MESSAGE', 'ОШИБКА!');
/*URL до папки с плагином*/
define('URL_ROOT_FOLDER', plugin_dir_url(dirname(__FILE__)));
/*Путь до папки плагина*/
define('ROOT_FOLDER', plugin_dir_path(dirname(__FILE__)));






