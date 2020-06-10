<?php get_header();?>
<?php the_post();?>
<div class="wrap wrap-person">
    <div class="row justify-content-center">
        <div class="col-md-8 ">
        <article id ="post-<?php the_ID();?>" class="center-person">
            <div class="container">
                        <div class="card">
                            <?php if ( has_post_thumbnail()): ?>
                                <div class="card-block-hover img-responsive img-thumbnail">
                                    <?php the_post_thumbnail();?>
                                </div>
                            <?php endif;?>
                            <div class="card-block">
                                <h1 class="mt-20"><strong><?php the_title();?></strong></h1>
                                <hr>
                                <div><h4>Отделы:</h4></div>
                                <?php $terms = get_the_terms(get_the_ID(), 'team');
                                    if ($terms):?>
                                     <ul class="left">
                                            <?php foreach($terms as $term ):?>
                                                <li><a href = "<?php echo get_term_link($term->term_id);?>"><?php echo $term->name;?></a>
                                                    </li>
                                            <?php endforeach;?>
                                     </ul>
                                 <?php endif; ?>


                                <hr>
                                <h3 class="mt-20 mb-0"><strong>Контактная информация:</strong></h3>
                                        <ul class="left">
                                            <li class="clearfix"><i class="icon-location22 icon-color icon-size-m icon-position-left"></i>
                                                <span>Адрес</span>
                                                <span class="right">
                                                    <?php
                                                    if ($address = get_post_meta(get_the_ID(),'Address_address', true  )){
                                                        echo $address;
                                                    }else
                                                        echo '-----';
                                                    ?>
                                                </span>
                                            </li>
                                            <li class="clearfix"><i class="icon-envelop icon-color icon-size-m icon-position-left"></i>
                                                <span>E-mail</span>
                                                <span class="right">
                                                    <?php if($email = get_post_meta(get_the_ID(),'Email_email', true  )) {
                                                        echo $email;
                                                    }else
                                                        echo '-----';
                                                    ?>
                                                </span>
                                            </li>
                                            <li class="clearfix"><i class="icon-phone2 icon-color icon-size-m icon-position-left"></i>
                                                <span>Телефон</span>
                                                <span class="right">
                                                    <?php if ($phone = get_post_meta(get_the_ID(),'Phone_phone', true  )){
                                                        echo $phone;
                                                    }else
                                                        echo '-----';
                                                        ?>
                                                </span>
                                            </li>
                                        </ul>
                                <hr>

                            </div>
                    </div>
                </div>
        </article>

            <?php
                    $max_comment_page = 10;
            if ( comments_open() || get_comments_number() ) :
                          comment_form();
                        // Получаем комментарии поста из базы данных
                  $comments = get_comments(array(
                            'post_id' => get_the_ID(),
                            'status' => 'approve' // комментарии прошедшие модерацию
                        ));
                        // Формируем вывод списка полученных комментариев
                        wp_list_comments(array(
                            'per_page' => $max_comment_page, // Пагинация комментариев - по 10 на страницу
                            'reverse_top_level' => false // Показываем последние комментарии в начале
                        ), $comments);
                    endif;
            ?>
            <hr>

            <?php
                    $max_comment =get_comments(array('post_id' => get_the_ID(), 'count' => true)); // возвращает только count
                            if (!$max_comment % $max_comment_page  == 0) {
                                $max_page = ($max_comment / $max_comment_page)+1;
                            }else {
                                $max_page = ($max_comment / $max_comment_page);
                            }
                            the_comments_pagination(
                                                        array(
                                                                'total'   => $max_page,
                                                                )
                                                    );
            ?>

</div>
    </div>

</div>

<?php get_footer();?>