<div class ="container">
    <div class="row">
        <div class = "col-md-12 show_item">
            <a class = "add-item" href ="?page=add_edge">Добавить кромку</a>
                <table class  = "show-table">
                    <caption>Стоимость оклейки кромки</caption>
                      <thead> 
                        <tr>
                            <th>Название кромки</th>
                            <th>Стоимость оклейки 1мп, USD</th>
                            <th>Стоимость оклейки 1мп, BIN</th>
                            <th>Размеры кромки, мм</th>
                            <th>Цвет ДСП</th>
                            <th colspan="2">Редактирование</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            foreach ($edge_type as $d){
                                $color = option_color_dsp_edge_type($d); 
                                    echo '<tr>
                                            <td>'.$d->type.' </td>
                                            <td>'.$d->cash.'</td>
                                            <td>'.round(($d->cash*$bin_usd),2).'</td>
                                            <td>'.$d->size.' x '.$d->width.'</td>
                                            <td>
                                                <select class="form-control selectpicker" title="Цвета Кромки" data-style="btn-info " data-size="15"  >'.$color.'</select>     
                                            </td>
                                            <td><a href = "?page=add_edge&action=edit&id='.$d->id_edge.'">Изменить</a></td>
                                            <td><a class = "delete-item" href = "?page=add_edge&action=delete&id='.$d->id_edge.'">Удалить</a></td>
                                         </tr>';  
                                }
                    ?>
                    </tbody>
                </table>
        </div>
    </div>   
</div>