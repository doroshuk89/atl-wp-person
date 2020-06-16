jQuery(document).ready(function(){
    jQuery(".slide-two").owlCarousel({
        loop:true, //Зацикливаем слайдер
        margin:10, //Отступ от элемента справа в 50px
        nav:false, //Отключение навигации
        autoplay:true, //Автозапуск слайдера
        center: true,
        autoHeight:true,
        smartSpeed:1000, //Время движения слайда
        autoplayTimeout:carusel_widget.time_autoscroll, //Время смены слайда
        responsive:{ //Адаптивность. Кол-во выводимых элементов при определенной ширине.
            0:{
                items: 1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });
});