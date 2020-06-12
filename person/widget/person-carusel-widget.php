<?php

class ATL_PERSON_CARUSEL extends WP_Widget {

    public function __construct() {
        $args = array (
            'name'=>'PersonCarusel',
            'description'=>'Виджет вывода person в виде карусели'
        );
        parent::__construct ('atl_person_team', '', $args);
    }

    public function form ($instance) {
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
            <label for = "<?php echo $this->get_field_id('id_parent');?>">Выберите страницы</label>
            <select class = "widefat" id="<?php echo $this->get_field_id('id_parent');?>" name="<?php echo $this->get_field_name('id_parent');?>">
                <option></option>
                <?php
                $page_parent = get_posts(array(
                        'numberposts' => -1,
                        'post_status' => 'publish',
                        'post_type' => 'page',
                        'orderby' => 'title',
                        'order' => 'ASC'
                    )
                );
                foreach($page_parent as $pages) {
                    if ($pages->ID == $parent_id ) {echo '<option value ='.  $pages->ID.' selected="selected">'. $pages->post_title.'</option>';}
                    else {echo '<option value ='.$pages->ID.' >'. $pages->post_title.'</option>';}
                } ?>
            </select>
        </p>
        <?php

    }

    public function widget ($args, $instance) {
        $children_page = get_children( array(
            'numberposts' => -1,
            'post_type' => 'page',
            'post_status' => 'publish',
            'post_parent' => $instance['id_parent'],
            'orderby' => 'title ',
            'order' => 'ASC'
        ) );

        /*Вывод списка дочерних страниц*/
        echo $args['before_widget'];
        echo $args['before_title'].$instance['title'].$args['after_title'];
        ?>
        <ul>
            <?php  if ($children_page) {
                foreach ($children_page as $page) {  ?>
                    <li><a href="<?php echo get_permalink($page->ID);?>" ><?php echo $page->post_title; ?></a></li>
                <?php }}
            else  { ?>
                <li>Нет дочерних страниц</li>
            <?php }; ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }

    public function update ($new_instance, $old_instance) {
        $new_instance['id_parent'] = isset($new_instance['id_parent'])&&!empty($new_instance['id_parent']) ? $new_instance['id_parent']:1;
        $new_instance['title']=isset($new_instance['title']) && !empty($new_instance['title'])?strip_tags($new_instance['title']):'Каталог';
        return $new_instance;
    }
}
