jQuery(document).ready(function ($) {
        //Разрешаем ввод только числе с точкой
        $('[name=cash] ').bind("change keyup input click", function() {
                    if (this.value.match(/[^0-9\.]/g)) 
                        {
                            this.value = this.value.replace(/[^0-9\.]/g, '');
                        }
                });
        //Разрешаем ввод только чисел     
        $('[name=dsp_width], [name=edge_size], [name=edge_width]').bind("change keyup input click", function() {
                    if (this.value.match(/[^0-9]/g)) 
                        {
                            this.value = this.value.replace(/[^0-9]/g, '');
                        }
                });    
        //Разрешаем ввод только hex чисел     
        $('[name=color_code]').bind("change keyup input click", function() {
                    if (this.value.match(/[^0-9  a-fA-F]/g)) 
                        {
                            this.value = this.value.replace(/[^0-9 a-fA-F]/g, '');
                        }
                });    
        $("#add-dsp-type").submit(function () {
            return true;
        })
    });
