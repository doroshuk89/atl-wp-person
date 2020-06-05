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
        'menu_icon' => ANBLOG_TEST_URL .'assets/img/plugins-icons.png', // иконка в меню
        'menu_position' => 40, //позиция в меню
        'supports' => array('title','editor','thumbnail', 'comments'),
        'taxonomies' => array('team')
    );
    register_post_type('teamperson', $args);

}

// Создаем новую таксономию для проектов
add_action( 'init', 'create_team_taxonomies', 0 );

function create_team_taxonomies(){
    $labels = array(
        'name' => 'Отделы',
        'singular_name' =>'Отделы',
        'menu_name' =>'Team',
        'search_items' =>'Найти отделы',
        'all_items' =>'Все отделы команды',
        'parent_item' =>'Родительская категория отдела',
        'parent_item_colon' => 'Родительская категория',
        'edit_item' => 'Родительская категория',
        'update_item' =>'Обновить отделы',
        'add_new_item' =>'Добавить новый отдел',
        'new_item_name' => 'Название нового отдела команды',

    );

    register_taxonomy('team', array('teamperson'),
        array(
            'labels' => $labels,
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => false,
            'rewrite' => array( 'slug' => 'team' )
        )
    );

}


