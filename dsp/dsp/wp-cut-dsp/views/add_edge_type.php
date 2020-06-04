<div class="container">
    <div class="row">
        <form method="POST" action="?page=add_edge&action=add">
                    <div class="form-group"> 
                       <label class="control-label" for ="name">Укажите кромку</label><br/>
                       <input type="text" class="form-control" id="name" name ="name" value="" placeholder="Название ДСП" required>
                    </div>
                    <div class="form-group"> 
                       <label class="control-label" for ="cash" >Укажите стоимость оклейки </label><br/>
                       <input type="text" class="form-control" id="cash" name ="cash" value="" placeholder="Стоимость за 1м2" required>
                    </div>
                    <div class="form-group"> 
                       <label class="control-label" for ="edge_size" >Укажите размер </label><br/>
                       <select class="form-control selectpicker" id = "edge_size" name="edge_size" required data-live-search="true" title="Выберите размер" data-style="btn-info" data-size="15">
                           <option value="" disabled selected>Выбрать толщину...</option>
                           <?php foreach ($edge_size as $a) {
                               echo '<option value="'. $a->id_size.'">'.$a->size.' x '.$a->width.'</option>';
                           }
                           ?>   
                       </select>
                    </div>
            
                    <div class="form-group"> 
                               <label class="control-label" for ="color_dsp" >Укажите цвет </label><br/>
                            <select  class="form-control selectpicker"  id = "color_dsp" name="color_edge[]" required multiple  data-live-search="true" title="Выберите толщину" data-style="btn-info" data-size="15" data-actions-box="true" data-selected-text-format="count>5">
                                   <?php foreach ($color as $c) {
                                       echo '<option style="background:'.$c->color_code.'; color: #fff;" value="'. $c->id_color.'">'.$c->color_name.'</option>';
                                   }
                                   ?>   
                            </select>
                    </div>      
            
               <input type="submit" value="Добавить">
        </form>
    </div>
</div>