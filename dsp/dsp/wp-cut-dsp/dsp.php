<?php 
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*СКРИПТ РЕДАКТИРОВАНИЯ И УДАЛЕНИЯ ТИПОВ ДСП ИЗ БД*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') { 
            $url_type = 'https://';
        } else 
            $url_type = 'http://';
      
    $PathEdit=$url_type.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'].'&action=edit&id=';
    $PathDelete=$url_type.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'].'&action=delete&id=';
   
    $action = isset($_GET['action']) ? $_GET['action'] : null;
    $id_dsp_type = isset($_GET['id']) ? $_GET['id'] : null;
    switch ($action) {
        case 'edit': 
                        if($_GET['id']) {$id_dsp = (int)$_GET['id'];}
                        if (isset($_POST) && !empty($_POST)) {
                            if ($_POST['name'])         { $name = trim($_POST['name']);}
                            if ($_POST['cash'])         { $cash = (int)($_POST['cash']);}
                            if ($_POST['width_dsp'])    { $width_dsp = (int)($_POST['width_dsp']);}
                            if ($_POST['color_dsp'])    {$color_dsp = $_POST['color_dsp'];}                 
                            dsp_edit_type($name, $cash, $width_dsp, $id_dsp);
                                if(color_dsp_cross_edit($id_dsp, $color_dsp, COLOR_CROSS_DSP))
                                    {
                                        header("Location: admin.php?page=wp-cut-dsp/dsp.php");
                                        break;        
                                    }               
                        }else {
                            $width=dsp_width();
                            $dsp_show = show_dsp_id($id_dsp);      
                            $color=show_color();
                            include ('views/edit_dsp.php'); break;                        
                        } 
        case 'delete': 
                        if($_GET['id']) {$id_dsp = (int)$_GET['id'];}
                        if(dsp_type_delete($id_dsp) == true)
                            {
                               header("Location: admin.php?page=wp-cut-dsp/dsp.php"); break;
                             
                            }else {echo ERROR_MESSAGE;break;}
        default:
                    $dsp=select_data();
                    $bin_usd = bin_usd();
                        include ('views/show_dsp_type.php');
                  
    }
    

?>