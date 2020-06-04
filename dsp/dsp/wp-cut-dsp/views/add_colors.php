<div class ="container">
    <div class="row">
        <div class = "col-md-12 show_item">
            <form method="POST" action="?page=add_color">
                        <div class="form-group"> 
                           <label class="control-label" for ="color_name">Укажите название цвета</label><br/>
                           <input type="text" class="form-control" id="color_name" name ="color_name" value="" placeholder="Укажите название цвета" required>
                        </div>
                        <label class="control-label" for ="color_code">Укажите код (HEX) цвета (пример, ff0000)</label><br/>
                         <div id="color" class="input-group colorpicker-component"  title="Using input value"> 
                            <input type="text" class="form-control " id="color_code" name ="color_code" value="fff000" placeholder="Укажите код (HEX) цвета" required maxlength="6" minlength="3">
                            <span class="input-group-addon"><i></i></span>
                        </div> 
                   <input type="submit" value="Добавить">
            </form> 
        </div>
    </div>
</div>

