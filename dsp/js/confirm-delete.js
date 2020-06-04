jQuery(document).ready(function ($) {
    $(".delete-item").click(function () {
      if(!confirm("Подтвердите удаление")){
          return false;
      }else return true;
    })
});


