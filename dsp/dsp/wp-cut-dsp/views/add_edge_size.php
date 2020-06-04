<div class ="container">
    <div class="row">
        <div class = "col-md-12 show_item">
            <table class  = "show-table">
                 <thead>
                        <tr>
                            <th>Размеры кромки(ширина*толщина),мм</th>
                            <th colspan="2">Редактирование</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            foreach ($edge_size as $s){
                                            echo '<tr><td>'.$s->size.' x '.$s->width.' </td><td><a class = "delete-item" href = "?page=add_edge_size&action=delete_size&id='.$s->id_size.'">Удалить</a></td></tr>';  
                                        }
                            ?>
                    </tbody>
            </table>
        <form method="POST" action="?page=add_edge_size&action=add_size">
                    <div class="form-group"> 
                       <label class="control-label" for ="edge_size">Укажите размеры кромки (ширину на толщину, пример 22x2)</label><br/>
                       <input type="text" class="form-control" id="edge_size" name ="edge_size" value="" placeholder="Ширина" required>
                       <input type="text" class="form-control" id="edge_width" name ="edge_width" value="" placeholder="Толщина" required>
                    </div> 
               <input type="submit" value="Добавить">
              
        </form>
