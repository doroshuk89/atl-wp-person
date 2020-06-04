<div class="container">
    <div class="row">
        <form method="POST" action="?page=wp-cut-dsp/add_dsp_type.php&action=add" id="add-dsp-type">
                    <div class="form-group"> 
                       <label class="control-label" for ="name">Укажите название ДСП</label><br/>
                       <input type="text" class="form-control" id="name" name ="name" value="" placeholder="Название ДСП" required>
                    </div>
                    <div class="form-group"> 
                       <label class="control-label" for ="cash" >Укажите стоимость распила ДСП </label><br/>
                       <input type="text"  class="form-control" id="cash" name ="cash" value="" placeholder="Стоимость за 1м2" required>
                    </div>
                    <div class="form-group"> 
                       <label class="control-label" for ="width_dsp" >Укажите толщину ДСП </label><br/>
                       <select class="form-control selectpicker"  id = "width_dsp" name="width_dsp" required  data-live-search="true" title="Выберите толщину" data-style="btn-info" data-size="15">
                           <option selected></option>
                           <?php foreach ($width as $a) {
                               echo '<option value="'. $a->id_width.'">'.$a->width.'</option>';
                           }
                           ?>   
                    </select>
                    </div>
                    <div class="form-group"> 
                               <label class="control-label" for ="color_dsp" >Укажите цвет </label><br/>
                               <select  class="form-control selectpicker"  id = "color_dsp" name="color_dsp[]" required multiple  data-live-search="true" title="Выберите толщину" data-style="btn-info" data-size="15" data-actions-box="true" data-selected-text-format="count>5">
                                   <?php foreach ($color as $c) {
                                       echo '<option style="background:'.$c->color_code.'; color: #fff;" value="'. $c->id_color.'">'.$c->color_name.'</option>';
                                   }
                                   ?>   
                            </select>
                    </div>      
               <input type="submit" value="Добавить">
               <?php if($ERROR) {echo $ERROR;} ?>
        </form>
         </div>
    </div>
