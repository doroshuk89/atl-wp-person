<?php

class ATL_PERSON_CARUSEL extends WP_Widget {

    public $min_time = 1000;
    public $max_time = 10000;

    public function __construct() {
        $args = array (
            'name'=>'PersonCarusel',
            'description'=>'Виджет вывода person в виде карусели'
        );
        parent::__construct ('atl_wp_person_team', '', $args);
    }

    public function form ($instance) {

        if(is_admin()){
            wp_enqueue_script('widget-checked');
        }

        $title = isset($instance['title'])?$instance['title']:'PersonTeam';
        $time_autoscroll = isset($instance['time_autoscroll']) ? $instance['time_autoscroll']:'1000';
        ?>
        <div class="form-widget-person">
        <p>
            <label for = "<?php echo $this->get_field_id('title');?>">Заголовок</label>
            <input class="widefat title" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" value="<?php echo $title;?>">
        </p>
        <p>
            <label for = "<?php echo $this->get_field_id('time_autoscroll');?>">Время автоскролла (мс от 1000 - 10000)</label>
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
        <p>
            <button type="button" id="btn_on">Отметить все</button>
            <button type="button" id="btn_off">Снять все</button>
        </p>
        </div>

    <?php
    }

    public function widget ($args, $instance) {

        /*add Styles and Scripts for view carusel in front*/
        wp_enqueue_style('owl-carusel-theme');
        wp_enqueue_style('owl-carusel');
        wp_enqueue_style('owl-carusel-person');
        wp_enqueue_script('owl-carusel-js');
        wp_enqueue_script('atl-wp-carusel');
        wp_localize_script('atl-wp-carusel', 'carusel_widget', array('time_autoscroll' => $instance['time_autoscroll']));

        $params = [
                'post_type'=>'teamperson',
                'numberposts' => -1,
                'tax_query'=>   [
                                    [
                                        'taxonomy' => 'team',
                                        'field'    => 'id',
                                        'terms' => $instance['dep']
                                    ]
                                ],
                'orderby'  => 'menu_order',
                'order'   => 'DESC',
                ];
        $PersonTeam = get_posts($params);
        
        echo $args['before_widget'];
        echo $args['before_title'].$instance['title'].$args['after_title']; ?>
                    <div class="owl-carousel slide-two">
                        <?php foreach ($PersonTeam as $item) { ?>
                            <div class="item-carousel">
                                        <a href="<?php echo get_permalink($item->ID);?>">
                                            <?php echo $item->post_title; echo  get_the_post_thumbnail( $item->ID );?>
                                        </a>
                            </div>
                        <?php } ?>
                    </div>

        <?php echo $args['after_widget'];
    }

    public function update ($new_instance, $old_instance) {
        $new_instance['title']=isset($new_instance['title']) && !empty($new_instance['title'])?strip_tags($new_instance['title']):'PersonTeam';
        $new_instance['time_autoscroll']=isset($new_instance['time_autoscroll']) && !empty($new_instance['time_autoscroll'])?$this->range_time_scroll(strip_tags($new_instance['time_autoscroll'])):'1000';
                if (!isset($new_instance['dep']) && !is_array($new_instance['dep'])){
                    $new_instance['dep'] = array();
                }
        return $new_instance;
    }

    protected function range_time_scroll ($time) {
            if ($time < $this->min_time) {
                $time = $this->min_time;
            }elseif ($time > $this->max_time) {
                $time = $this->max_time;
            }
        return $time;
    }
}
