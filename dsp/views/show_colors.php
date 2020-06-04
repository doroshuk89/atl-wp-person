<div class ="container">
    <div class="row">
        <div class = "col-md-12 show_item">
            
                <table class  = "show-table">
                    <caption>Цвета кромки и дсп</caption>
                      <thead> 
                        <tr>
                            <th>Название цвета</th>
                            <th>Цвет</th>
                            <th>Код HEX</th>                        
                            <th>Редактирование</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            foreach ($colors as $d){
                                    echo '<tr>
                                            <td>'.$d->color_name.' </td>
                                            <td style="background-color:'.$d->color_code.';"></td>
                                            <td>'.$d->color_code.'</td>
                                            <td><a class = "delete-item" href = "?page=show_color&action=delete&id='.$d->id_color.'">Удалить</a></td>
                                         </tr>';  
                                }
                    ?>
                    </tbody>
                </table>
        </div>
    </div>   
</div>