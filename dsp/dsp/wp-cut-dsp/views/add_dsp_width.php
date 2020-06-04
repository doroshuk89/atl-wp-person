<div class ="container">
    <div class="row">
        <div class = "col-md-12 show_item">
            <table class  = "show-table">
                 <thead>
                        <tr>
                            <th>Толщина ДСП, мм</th>
                            <th colspan="2">Редактирование</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            foreach ($dsp_width as $d){
                                            echo '<tr><td>'.$d->width.'</td><td><a class = "delete-item" href = "?page=add_dsp_size&action=delete_width&id='.$d->id_width.'">Удалить</a></td></tr>';  
                                        }
                            ?>
                    </tbody>
            </table>  
            <form method="POST" action="?page=add_dsp_size&action=add_width">
                        <div class="form-group"> 
                           <label class="control-label" for ="dsp_width">Укажите толщину ДСП</label><br/>
                           <input type="text" class="form-control" id="dsp_width" name ="dsp_width" value="" placeholder="Толщина ДСП" required>
                        </div> 
                    <input type="submit" value="Добавить">  
                </form>
        </div>
    </div>
</div>