<?php

/*Добаляем произвольный тип записи teamperson*/
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
        'rewrite' => array('slug' =>'person', 'with_front' => false ),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_icon' => ANBLOG_TEST_URL .'assets/img/plugins-icon.png', // иконка в меню
        'menu_position' => 40, //позиция в меню
        'supports' => array('title','editor','thumbnail', 'comments'),
        'taxonomies' => array('team')
    );
    register_post_type('teamperson', $args);

}

//add new colums for custom type post "teamperson"
add_filter( 'manage_teamperson_posts_columns', function ( $columns ) {
	$my_columns = [
		'id'    => 'ID',
		'thumb' => 'Миниатюра'
	];
        $sort = ['sort'  => 'Сортировка'];
    return array_slice( $columns, 0, 1 ) +$my_columns + array_slice( $columns, 1, 2 ) +$sort + array_slice( $columns, 3 );
} );
// Выводим контент для каждой из зарегистрированных нами колонок. Обязательно.
add_action( 'manage_teamperson_posts_custom_column', function ( $column_name ) {
	if ( $column_name === 'id' ) {
		the_ID();
	}

	if ( $column_name === 'thumb' && has_post_thumbnail() ) {?>
		<a href="<?php echo get_edit_post_link(); ?>">
			<?php the_post_thumbnail( 'thumbnail' ); ?>
		</a>
		<?php
	}
        if ($column_name == 'sort' && get_post_meta(get_the_ID(),'Order_order', true  )) {
            echo get_post_meta(get_the_ID(),'Order_order', true  );
        }
} );

// добавляем возможность сортировать колонку
add_filter( 'manage_'.'edit-teamperson'.'_sortable_columns', 'add_views_sortable_column' );
function add_views_sortable_column( $sortable_columns ){
	$sortable_columns['sort'] = [ 'Order_order', true ]; 
            // false = asc (по умолчанию)
            // true  = desc
	return $sortable_columns;
}
add_action( 'pre_get_posts', 'my_person_orderby' );
function my_person_orderby( $query ) {
        if( ! is_admin() )
        return;

        $orderby = $query->get( 'orderby');
        if( 'Order_order' == $orderby ) {
                $query->set('meta_key','Order_order');
                $query->set('orderby','meta_value_num');
        }

}

// Создаем новую таксономию для teampearson
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
/*include styles*/
add_action( 'wp_enqueue_scripts', 'person_register_styles' );
function person_register_styles () {
    if (is_single() && (get_post_type() =='teamperson'))
        {
            wp_enqueue_style('bootstrap-person', ANBLOG_TEST_URL.'assets/css/person-bootstrap-grid.min.css' ,array(),null);
            wp_enqueue_style('person', ANBLOG_TEST_URL.'assets/css/person.css' ,array(),null);
        }
}
/*delete input website from commetns form*/
add_filter( 'comment_form_default_fields', 'comment_form_default_add_my_fields' );
function comment_form_default_add_my_fields( $fields ) {
        unset( $fields['url'] );
    return $fields;
}
// apply_filters( 'get_comment_link', $link, $comment, $args, $cpage );
add_filter( 'get_comment_link', 'change_redirect_link', 10, 4 );
function change_redirect_link( $link, $comment, $args, $cpage ){
    if( false !== strpos($_SERVER['REQUEST_URI'], 'wp-comments-post.php') ){
        // изменяем номер страницы комментариев
        $link = str_replace( "comment-page-$cpage", "comment-page-1", $link );
    }
    return $link;
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
        'numberposts' => -1,
        'tax_query'=>   [
            [
                'taxonomy' => 'team',
                'field'    => 'slug',
                'terms' => $atts['team']
            ]
        ],
        'meta_key' => 'Order_order',
        'orderby'  => 'meta_value_num',
        'order'   => 'DESC',
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


