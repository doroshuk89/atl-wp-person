<?php get_header();?>
    <?php the_post();?>
        <div class="wrap wrap-person">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <article id ="post-<?php the_ID();?>" class="center-person">
                                    <?php if ( has_post_thumbnail()): ?>
                                        <div class="item">
                                            <div class="res">
                                                <?php echo get_the_post_thumbnail();?>
                                            </div>
                                        </div>
                                    <?php endif;?>
                                    <div class="card-block">
                                        <h1 class="mt-20"><strong><?php the_title();?></strong></h1>
                                        <hr>
                                        <h3 class="mt-20 mb-0"><strong>Контактная информация:</strong></h3>
                                                <ul class="left">
                                                    <li>
                                                        <span>Адрес:</span>
                                                        <span class="right">
                                                            <?php
                                                            if ($address = get_post_meta(get_the_ID(),'Address', true  )){
                                                                echo $address;
                                                            }else
                                                                echo '-----';
                                                            ?>
                                                        </span>
                                                    </li>
                                                    <li >
                                                        <span>E-mail:</span>
                                                        <span class="right">
                                                            <?php if($email = get_post_meta(get_the_ID(),'Email', true  )) {
                                                                echo $email;
                                                            }else
                                                                echo '-----';
                                                            ?>
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <span>Телефон:</span>
                                                        <span class="right">
                                                            <?php if ($phone = get_post_meta(get_the_ID(),'Phone', true  )){
                                                                echo $phone;
                                                            }else
                                                                echo '-----';
                                                                ?>
                                                        </span>
                                                    </li>
                                                </ul>
                                        <hr>
                                        <?php if ($terms = get_the_terms(get_the_ID(), 'team')): ?>
                                            <div><h4>Отделы:</h4></div>
                                                <ul class="left">
                                                    <?php foreach($terms as $term ):?>
                                                        <li><a href = "<?php echo get_term_link($term->term_id);?>"><?php echo $term->name;?></a>
                                                        </li>
                                                    <?php endforeach;?>
                                                </ul>
                                            <hr>
                                        <?php endif;?>
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
                                endif;?>
                        <hr>

                            <?php
                                    $max_comment =get_comments(array('post_id' => get_the_ID(), 'count' => true)); // возвращает только count
                                            if (!$max_comment % $max_comment_page  > 0) {
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
        </div>
<?php get_footer();?>