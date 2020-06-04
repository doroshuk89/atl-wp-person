<div class ="container">
    <div class="row">
        <div class = "col-md-12 show_item">
            <a class = "add-item" href ="?page=wp-cut-dsp/add_dsp_type.php" >Добавить дсп</a>
                <table class  = "show-table">
                     <caption>Стоимость распила ДСП</caption>
                    <thead>
                        <tr>
                            <th>Название типа ДСП</th>
                            <th>Стоимость распила 1м2, USD</th>
                            <th>Стоимость распила 1м2, BIN</th> 
                            <th>Толщина ДСП, мм</th>
                            <th>Цвет ДСП</th>
                            <th colspan="2">Редактирование</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php    
                    foreach ($dsp as $d){ 
                        $color = option_color_dsp_edge_type($d); 
                                    echo '<tr>
                                            <td>'.$d->type.'</td>
                                            <td>'.$d->cash.'</td>
                                            <td>'.round(($d->cash*$bin_usd),2).'</td>  
                                            <td>'.$d->width.'</td>
                                            <td>
                                                <select class="form-control selectpicker" title="Цвета ДСП" data-style="btn-info " data-size="15"  >'.$color.'</select>     
                                            </td>
                                            <td><a href = "'.$PathEdit.$d->id_dsp.'">Изменить</a></td>
                                            <td><a class = "delete-item" href = "'.$PathDelete.$d->id_dsp.'">Удалить</a></td>
                                    </tr>';  
                                }
                    ?>
                    </tbody>
                </table>
        </div>
    </div>   
</div> 