<?php 
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*СКРИПТ ДОБАВЛЕНИЯ ТИПОВ ДСП В БД*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
        $ERROR='';
        $action = isset($_GET['action']) ? $_GET['action'] : null;  
        if ($action == 'add') {
            if(isset($_POST) && !empty($_POST)) { 
                        if ($_POST['name'])         { $name = trim($_POST['name']);}
                        if ($_POST['cash'])         { $cash = (int)(($_POST['cash']));}
                        if ($_POST['width_dsp'])    { $width_dsp = (int)(($_POST['width_dsp']));}
                        if ($_POST['color_dsp'])    {$color_dsp = $_POST['color_dsp'];}
                        $add_status = add_type_dsp_insert ($name, $cash, $width_dsp, $color_dsp);
                        if ($add_status) {
                            header("Location: admin.php?page=wp-cut-dsp/dsp.php");
                        }else $ERROR = "Ошибка добавления";
                }
            }
            $width=dsp_width();
            $color=show_color();
            include ('views/add_dsp_type.php'); 
?>