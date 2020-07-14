jQuery(document).ready(function(){
    //Элемент появляется после загрузки страницы
    jQuery('body').on('click', "#btn_on", function() {
        jQuery('.form-widget-person input:checkbox').prop('checked', true).click();
        jQuery('.form-widget-person input:checkbox').click();
    })
    jQuery('body').on('click', "#btn_off", function() {
        jQuery('.form-widget-person input:checkbox').prop('checked', false).click();
        jQuery('.form-widget-person input:checkbox').click();
    })
})