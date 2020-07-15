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
        'has_archive' => false,
        'hierarchical' => false,
        'menu_icon' => ANBLOG_TEST_URL .'assets/img/plugins-icon.png', // иконка в меню
        'menu_position' => 40, //позиция в меню
        'supports' => array('title','editor','thumbnail', 'comments', 'page-attributes'),
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
    global $post;
	if ( $column_name === 'id' ) {
		the_ID();
	}
	if ( $column_name === 'thumb' && has_post_thumbnail() ) {?>
		<a href="<?php echo get_edit_post_link(); ?>">
			<?php the_post_thumbnail( 'thumbnail' ); ?>
		</a>
		<?php
	}
	if ($column_name == 'sort') {
	    echo $post->menu_order;
	}
});
// добавляем возможность сортировать колонку
add_filter('manage_'.'edit-teamperson'.'_sortable_columns', 'add_views_sortable_column');
function add_views_sortable_column( $sortable_columns ){
	$sortable_columns['sort'] = [ 'menu_order', true ];
            // false = asc (по умолчанию)
            // true  = desc
	return $sortable_columns;
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

/*Register all Styles and Scripts*/
add_action('wp_enqueue_scripts', 'register_my_scripts');
function register_my_scripts () {
    wp_register_script( 'atl-wp-carusel-shortcode', ANBLOG_TEST_URL . 'assets/js/atl-wp-carusel-shortcode.js', array('jquery'), null, true);
    wp_register_script('owl-carusel-js', ANBLOG_TEST_URL . 'assets/js/owl.carousel.min.js', array('jquery'), null, true);
    wp_register_script('atl-wp-carusel',     ANBLOG_TEST_URL. 'assets/js/atl-wp-carusel.js', array('jquery'), null, true);
}
/*Styles for Widget Admin panel*/
add_action('admin_enqueue_scripts', 'register_my_scripts_admin');
function register_my_scripts_admin () {
    wp_register_script('widget-checked',     ANBLOG_TEST_URL. 'assets/js/atl-wp-widget-checked.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'register_my_styles');
function register_my_styles () {
    $theme_version = wp_get_theme()->get('Version');
    wp_register_style('owl-carusel-theme', ANBLOG_TEST_URL . 'assets/css/owl.theme.default.min.css', array(), $theme_version);
    wp_register_style('owl-carusel', ANBLOG_TEST_URL . 'assets/css/owl.carousel.min.css', array(), $theme_version);
    wp_register_style('owl-carusel-person', ANBLOG_TEST_URL . 'assets/css/owl-person.css', array(), $theme_version);
    wp_register_style('bootstrap-person', ANBLOG_TEST_URL.'assets/css/person-bootstrap-grid.min.css' ,array(),null);
    wp_register_style('person', ANBLOG_TEST_URL.'assets/css/person.css' ,array(),null);
}

/*include styles*/
add_action( 'wp_enqueue_scripts', 'person_register_styles' );
function person_register_styles () {
    if (is_single() && (get_post_type() =='teamperson'))
        {
            wp_enqueue_style('bootstrap-person');
            wp_enqueue_style('person');
        }
}

/*create metabox address, email, phone for teamperson type post*/
add_action( 'admin_menu', 'create_meta_boxes' );
function create_meta_boxes () {
    add_meta_box ('Custom_data','Контактные данные','create_meta_boxes_data','teamperson', 'normal', 'high');
}
add_action('save_post_teamperson', 'save_custom_post_data');

function create_meta_boxes_data ($post) {
    wp_nonce_field( ANBLOG_TEST_DIR, 'custom_meta_box_nonce', true, true );
    $prefix = 'Custom_data_'; ?>
   <table class="form-table">
       <tbody>
        <tr>
            <th scope="row"><label for="<?php echo $prefix;?>address">Адрес</label></th>
                <td>
                    <input name="<?php echo $prefix;?>address" type="text" id="<?php echo $prefix;?>address" value="<?php echo get_post_meta($post->ID, 'Address', true);?>" placeholder="Адрес" class="regular-text"/><br/>
                    <span class="description">Адрес участика команды</span>
                </td>
        </tr>
        <tr>
            <th scope="row"><label for="<?php echo $prefix;?>phone">Телефон</label></th>
                <td>
                    <input name="<?php echo $prefix;?>phone" type="text" id="<?php echo $prefix;?>phone" value="<?php echo get_post_meta($post->ID, 'Phone', true);?>" placeholder="Номер телефона" class="regular-text"/><br/>
                    <span class="description">Номер телефонаучастика команды</span>
                </td>
        </tr>
        <tr>
            <th scope="row"><label for="<?php echo $prefix;?>email">Email</label></th>
                <td>
                    <input name="<?php echo $prefix;?>email" type="text" id="<?php echo $prefix;?>email" value="<?php echo get_post_meta($post->ID, 'Email', true);?>" placeholder="Email адрес" class="regular-text"/><br/>
                    <span class="description">Email адрес участика команды</span>
                </td>
        </tr>
       </tbody>
   </table>
   <?php 
}

function save_custom_post_data ($post_id) {
    // проверяем, пришёл ли запрос со страницы с метабоксом
    if ( !isset( $_POST['custom_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['custom_meta_box_nonce'], ANBLOG_TEST_DIR ) )
        return $post_id;
    // проверяем, является ли запрос автосохранением
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
	return $post_id;
    // проверяем, права пользователя, может ли он редактировать записи
    if ( !current_user_can( 'edit_post', $post_id ) )
	return $post_id;
	// теперь также проверим тип записи	
	$post = get_post($post_id);
	if ($post->post_type == 'teamperson') { // укажите собственный
	    $prefix = 'Custom_data_';
            update_post_meta($post_id, 'Address', $_POST[$prefix.'address']);
            update_post_meta($post_id, 'Phone',   $_POST[$prefix.'phone']);
            update_post_meta($post_id, 'Email',   $_POST[$prefix.'email']);
	}
	return $post_id;
}

//Redirect in first page for pagination comments
add_filter( 'get_comment_link', 'change_redirect_link', 10, 4 );
function change_redirect_link( $link, $comment, $args, $cpage ){
    if( false !== strpos($_SERVER['REQUEST_URI'], 'wp-comments-post.php') ){
        // изменяем номер страницы комментариев
            $link = str_replace( "comment-page-$cpage", "comment-page-1", $link);
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
        'count_item' => 2,
        'time_autoscroll' => 3000
    ), $atts );

    /*add JS carousel for content shortcode */
    wp_enqueue_style('owl-carusel-theme');
    wp_enqueue_style('owl-carusel');
    wp_enqueue_style('owl-carusel-person');
    wp_enqueue_script('owl-carusel-js');
    wp_enqueue_script('atl-wp-carusel-shortcode');
    wp_localize_script('atl-wp-carusel-shortcode', 'carusel_shortcode', array(
        'time_autoscroll' => (intval($atts['time_autoscroll'])),
        'count_item' => (intval($atts['count_item'])),
    ));
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
        'orderby'  => 'menu_order',
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


