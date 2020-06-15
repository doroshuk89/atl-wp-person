<?php

class ATL_PERSON_CARUSEL extends WP_Widget {

    public function __construct() {
        $args = array (
            'name'=>'PersonCarusel',
            'description'=>'Виджет вывода person в виде карусели'
        );
        parent::__construct ('atl_wp_person_team', '', $args);
    }

    public function form ($instance) {

        print_r($instance);
        $title = isset($instance['title'])?$instance['title']:'PersonTime';
        $time_autoscroll = isset($instance['time_autoscroll']) ? $instance['time_autoscroll']:'1000';
        ?>
        <p>
            <label for = "<?php echo $this->get_field_id('title');?>">Заголовок</label>
            <input class="widefat title" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" value="<?php echo $title;?>">
        </p>
        <p>
            <label for = "<?php echo $this->get_field_id('time_autoscroll');?>">Время автоскролла</label>
            <input class="widefat title" id="<?php echo $this->get_field_id('time_autoscroll');?>" name="<?php echo $this->get_field_name('time_autoscroll');?>" value="<?php echo $time_autoscroll;?>">
        </p>

        <p>
            <label>Выберите отделы</label><br/>
            <?php
            if ($terms = get_terms(
                                    [
                                        'taxonomy' => 'team'
                                    ]
            )) {
                    //print_r($terms);
                    foreach ($terms as $key=>$term) {
                        if(isset($instance['dep']) && is_array($instance['dep']) ) {
                            if(in_array($term->term_id, $instance['dep'])){
                                        echo '<input type="checkbox" id="'.$this->get_field_id('dep').$key.'" name="'.$this->get_field_name('dep').'[]" value ="'.$term->term_id.'" checked>
                                              <label for="'.$this->get_field_id('dep'). $key.'">'.$term->name.' ('.$term->count.')</label><br />';
                            }else {
                                        echo '<input type="checkbox" id="'.$this->get_field_id('dep').$key.'" name="'.$this->get_field_name('dep').'[]" value ="'.$term->term_id.'" >
                                              <label for="'.$this->get_field_id('dep'). $key.'">'.$term->name.' ('.$term->count.')</label><br />';
                                }
                        }else {
                                echo    '<input type="checkbox" id="'.$this->get_field_id('dep').$key.'" name="'.$this->get_field_name('dep').'[]" value ="'.$term->term_id.'" checked>
                                         <label for="'.$this->get_field_id('dep'). $key.'">'.$term->name.' ('.$term->count.')</label><br />';
                            }
                        }
                    }
            ?>
        </p>
    <?php
    }

    public function widget ($args, $instance) {

        /*add Styles and Scripts for view carusel in front*/
        if ( is_active_widget(false, false, $this->id_base, true) ) {
                wp_enqueue_script('truescript', ANBLOG_TEST_URL. 'truescript.js');
                wp_localize_script('truescript', 'carusel', array('time' => $instance['time_autoscroll']));
        }

        $params = [
                'post_type'=>'teamperson',
                'tax_query'=>   [
                                    [
                                        'taxonomy' => 'team',
                                        'field'    => 'id',
                                        'terms' => $instance['dep']
                                    ]
                                ]
                ];
        $PersonTeam = get_posts($params);
        //print_r($PersonTeam);
        /*Вывод списка дочерних страниц*/
        echo $args['before_widget'];
        echo $args['before_title'].$instance['title'].$args['after_title']; ?>
            <ul>
                <?php foreach ($PersonTeam as $item) { ?>
                        <li><a href="<?php echo get_permalink($item->ID);?>"> <?php echo $item->post_title; echo  get_the_post_thumbnail( $item->ID );?></a></li>
                   <?php } ?>
            </ul>
        <?php echo $args['after_widget'];
    }

    public function update ($new_instance, $old_instance) {
            $new_instance['title']=isset($new_instance['title']) && !empty($new_instance['title'])?strip_tags($new_instance['title']):'PersonTime';
            $new_instance['time_autoscroll']=isset($new_instance['time_autoscroll']) && !empty($new_instance['time_autoscroll'])?strip_tags($new_instance['time_autoscroll']):'1000';
            if (!isset($new_instance['dep']) && !is_array($new_instance['dep'])){
                $new_instance['dep'] = array();
            }
        return $new_instance;
    }
}
