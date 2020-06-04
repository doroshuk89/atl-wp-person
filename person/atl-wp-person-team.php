<?php
/*
Plugin Name: PersonTeam
Plugin URI:https://atlas-it.by/wordpress/plugins/person-team/ 
Description: Плагин создания PersonTeam 
Version:v1.0
Author: Atlas
Author URI: http://atlas-it.by
*/

/*Create Post type TeamPearson*/
require_once __DIR__.'/inc/atl-wp-create-post-type.php';
/*Create taxonomy Team*/
require_once __DIR__.'/inc/atl-wp-create-taxomony-team.php';
/*Class Create Metabox*/
require_once __DIR__.'/classes/CreateMetabox.php';

/*Add metadata Phone, Address, Email*/
$options = require_once __DIR__.'/config/metabox.php';
foreach ($options as $option) {
    new CreateMetabox($option);
}
?>
