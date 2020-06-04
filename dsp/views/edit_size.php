<div class="container">
    <div class="row">
         <?php foreach ($edge_show as $e) { 
             $colors_array_id = colors_array_id($e);?>
        <form method="POST" action="?page=add_edge&action=edit&id=<?=$e->id_edge;?>">
                    <div class="form-group"> 
                       <label class="control-label" for ="name">Укажите кромку</label><br/>
                       <input type="text" class="form-control" id="name" name ="name" value="<?=$e->type;?>" placeholder="Название ДСП" required>
                    </div>
                    <div class="form-group"> 
                       <label class="control-label" for ="cash" >Укажите стоимость оклейки </label><br/>
                       <input type="text" class="form-control" id="cash" name ="cash" value="<?=$e->cash;?>" placeholder="Стоимость за 1м2" required>
                    </div>
                    <div class="form-group"> 
                       <label class="control-label" for ="edge_size" >Укажите размер </label><br/>
                       <select class="form-control selectpicker" id = "edge_size" name="edge_size" required data-live-search="true" title="Выберите цвет" data-style="btn-info" data-size="15" data-actions-box="true" data-selected-text-format="count>5">
                           
                           <?php foreach ($edge_size as $a) {
                               if(($e->width == $a->width) && ($e->size ==$a->size))
                                    {
                                            echo '<option selected value="'. $a->id_size.'">'.$a->size.' x '.$a->width.'</option>';
                                    }
                               else    {
                                            echo '<option value="'. $a->id_size.'">'.$a->size.' x '.$a->width.'</option>';
                                        }
                           }
                           ?>   
                       </select>
                   </div>
            
            <div class="form-group"> 
                               <label class="control-label" for ="color_edge" >Укажите цвет </label><br/>
                               <select  class="form-control selectpicker"  id = "color_edge" name="color_edge[]" required multiple  data-live-search="true" title="Выберите цвет" data-style="btn-info" data-size="15" data-actions-box="true" data-selected-text-format="count>5">
                                   <?php foreach ($color as $c) {
                                       if(in_array($c->id_color, $colors_array_id))
                                               {
                                                    echo '<option selected style="background:'.$c->color_code.'; color: #fff;" value="'. $c->id_color.'">'.$c->color_name.'</option>';           
                                               }else 
                                                {
                                                    echo '<option style="background:'.$c->color_code.'; color: #fff;" value="'. $c->id_color.'">'.$c->color_name.'</option>';
                                                }
                                   }
                                   ?>   
                               </select>
                    </div>      
               <input type="submit" value="Изменить">
        </form>
        <?php }; ?>
    </div>
</div>