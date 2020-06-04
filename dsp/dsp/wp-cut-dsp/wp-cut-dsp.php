<?php
/*
Plugin Name: Cuts dsl cash
Description: Плагин рассчета стоимости распила ДСП
Version: 1.0
Author: Atlas-it
Author URI: http://atlas-it.by
*/
error_reporting(0);
/*Подключение файла конфигурации*/
require_once __DIR__.'/config/config.php';
/*Подключение файла функций*/
require_once __DIR__.'/functions/functions.php';
/*Хук срабатывания при активации плагина*/
register_activation_hook(__FILE__, 'wp_cuts_dsp_active');
/*Хук срабатывает при деактивации плагина*/
register_deactivation_hook  (__FILE__, 'wp_cuts_dsp_deactive');
/*Хук срабатывает при удалении плагина*/
register_uninstall_hook     (__FILE__, 'wp_cuts_dsp_unistall');
/*Добавление страниц плагина в админку WP*/
add_action('admin_menu', 'dsp_admin_menu'); 
/*Подключение скриптов и стилей для админки плагина*/
add_action('admin_enqueue_scripts', 'wp_admin_cuts_dsp_sctipts');

