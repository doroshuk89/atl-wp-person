jQuery(document).ready(function(){
    jQuery(".slide-one").owlCarousel({
        loop:true, //Зацикливаем слайдер
        margin:10, //Отступ от элемента справа в 50px
        nav:false, //Отключение навигации
        autoplay:true, //Автозапуск слайдера
        center: false,
        autoHeight:true,
        smartSpeed:1000, //Время движения слайда
        autoplayTimeout:carusel_shortcode.time_autoscroll, //Время смены слайда
        responsive:{ //Адаптивность. Кол-во выводимых элементов при определенной ширине.
            0:{
                items: 1
            },
            600:{
                items:carusel_shortcode.count_item
            },
            1000:{
                items:carusel_shortcode.count_item
            }
        }
    });
});