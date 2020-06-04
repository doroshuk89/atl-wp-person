<?php
/*Добаляем произвольный тип записи ПРОЕКТЫ*/
add_action('init', 'teamperson');
function teamperson()
{
    $labels = array(
        'name' => 'Team Person',
        'singular_name' => 'Person',
        'add_new' => 'Add Person',
        'add_new_item' => 'Добавить нового члена команды',
        'edit_item' => 'Редактировать участника',
        'new_item' => 'Новый член команды',
        'view_item' => 'Посмотреть участников',
        'search_items' => 'Найти участников',
        'not_found' =>  'Участников не найдено',
        'not_found_in_trash' => 'В корзине участников не найдено',
        'parent_item_colon' => '',
        'menu_name' => 'Team Person'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => false,
        'rewrite' => array('slug' =>'teams', 'with_front' => false ),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_icon' => get_stylesheet_directory_uri() .'/img/function_icon.png', // иконка в меню
        'menu_position' => 40, //позиция в меню
        'supports' => array('title','editor','thumbnail', 'comments', 'author', 'custom-fields'),
        'taxonomies' => array('team', 'post_tag', 'category')
    );
    register_post_type('teamperson', $args);
}


