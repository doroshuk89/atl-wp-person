<?php
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