<?php

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*ФУНКЦИЯ ВЫЗЫВАЕТСЯ ПРИ АКТИВАЦИИ ПЛАГИНА*/
function wp_cuts_dsp_active (){
    wp_cuts_dsp_add_tables();
    wp_cuts_dsp_add_tables_data();
}

/*ФУНКЦИЯ ВЫЗЫВАЕТСЯ ПРИ ДЕАКТИВАЦИИ ПЛАГИНА*/
function wp_cuts_dsp_deactive () {    
}

/*ФУНКЦИЯ ВЫЗЫВАЕТСЯ ПРИ УДАЛЕНИИ ПЛАГИНА*/
function wp_cuts_dsp_unistall () {
    wp_cuts_dsp_del_tables();
}

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*ФУНКЦИИ СОЗДАНИЕ ТАБЛИЦ ПЛАГИНА В БД ПРИ АКТИВАЦИИ ПЛАГИНА*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*Функция создания таблиц в базе данных для плагина*/
function wp_cuts_dsp_add_tables () {
    global $wpdb;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   
/*Создание таблицы размеров ДСП*/    
    if($wpdb->get_var("SHOW TABLES LIKE '".DSP_WIDTH."'") != DSP_WIDTH) {
        
        $sql = "CREATE TABLE " . DSP_WIDTH . " (
        id_width TINYINT NOT NULL AUTO_INCREMENT,
        width TINYINT NOT NULL,
	       PRIMARY KEY (id_width)
	)ENGINE=InnoDB CHARACTER SET=UTF8;";
        dbDelta($sql);
    }   
/*Создание таблицы типов ДСП*/      
    if($wpdb->get_var("SHOW TABLES LIKE '".DSP_TYPE."'") != DSP_TYPE) {
        $sql = "CREATE TABLE " . DSP_TYPE . " (
              id_dsp INT NOT NULL AUTO_INCREMENT,
              type VARCHAR(100) NOT NULL,
              cash MEDIUMINT NOT NULL,
              id_width TINYINT NULL,
              PRIMARY KEY (id_dsp),
              CONSTRAINT fk_dsp_type_width FOREIGN KEY (id_width) REFERENCES ".DSP_WIDTH." (id_width) ON DELETE SET NULL ON UPDATE SET NULL
            );";
        dbDelta($sql);
    }
    
/*Создание таблицы размеров кромки*/ 
     if($wpdb->get_var("SHOW TABLES LIKE '".EDGE_SIZE."'") != EDGE_SIZE) {
        
        $sql = "CREATE TABLE " . EDGE_SIZE . " (
                id_size TINYINT NOT NULL AUTO_INCREMENT,
                width TINYINT NOT NULL,
                size TINYINT  NOT NULL,
	            PRIMARY KEY (id_size)
	   )ENGINE=InnoDB CHARACTER SET=UTF8;";
        dbDelta($sql);
    }
/*Создание таблицы типов кромки*/ 
    if($wpdb->get_var("SHOW TABLES LIKE '".EDGE_TYPE."'") != EDGE_TYPE) {
        
        $sql = "CREATE TABLE " . EDGE_TYPE . " (
                id_edge INT NOT NULL AUTO_INCREMENT,
                cash MEDIUMINT NOT NULL,
                type VARCHAR(100) NOT NULL,
                id_size TINYINT NULL, 
                PRIMARY KEY (id_edge),
                CONSTRAINT fk_edge_type_width FOREIGN KEY (id_size) REFERENCES ".EDGE_SIZE." (id_size) ON DELETE SET NULL ON UPDATE SET NULL
	)ENGINE=InnoDB CHARACTER SET=UTF8;";
        dbDelta($sql);
    }
/*Создание таблицы цветов*/ 
    if($wpdb->get_var("SHOW TABLES LIKE '".COLOR_ITEM."'") != COLOR_ITEM) {
        
        $sql = "CREATE TABLE " . COLOR_ITEM . " (
	       id_color INT NOT NULL AUTO_INCREMENT,
           color_name VARCHAR(100) NOT NULL,
           color_code VARCHAR(100) NOT NULL,
	   PRIMARY KEY (id_color)
	)ENGINE=InnoDB CHARACTER SET=UTF8;";
        dbDelta($sql);
    }   
    
/*Создание кросстаблицы  ДСП и цветов*/      
    if($wpdb->get_var("SHOW TABLES LIKE '".COLOR_CROSS_DSP."'") != COLOR_CROSS_DSP) {
        $sql = "CREATE TABLE " . COLOR_CROSS_DSP . " (
              id INT NOT NULL AUTO_INCREMENT,
              id_type INT NOT NULL,
              id_color INT NOT NULL,
              PRIMARY KEY (id),
              CONSTRAINT fk_dsp_type FOREIGN KEY (id_type) REFERENCES ".DSP_TYPE." (id_dsp) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT fk_dsp_color FOREIGN KEY (id_color) REFERENCES ".COLOR_ITEM." (id_color) ON DELETE CASCADE ON UPDATE CASCADE
            )ENGINE=InnoDB CHARACTER SET=UTF8;";
        dbDelta($sql);
    }
/*Создание кросстаблицы  КРОМКИ и цветов*/      
    if($wpdb->get_var("SHOW TABLES LIKE '".COLOR_CROSS_EDGE."'") != COLOR_CROSS_EDGE) {
        $sql = "CREATE TABLE " . COLOR_CROSS_EDGE . " (
              id INT NOT NULL AUTO_INCREMENT,
              id_type INT NOT NULL,
              id_color INT NOT NULL,
              PRIMARY KEY (id),
              CONSTRAINT fk_edge_type FOREIGN KEY (id_type) REFERENCES ".EDGE_TYPE." (id_edge) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT fk_edge_color FOREIGN KEY (id_color) REFERENCES ".COLOR_ITEM." (id_color) ON DELETE CASCADE ON UPDATE CASCADE 
            )ENGINE=InnoDB CHARACTER SET=UTF8;";
        dbDelta($sql);
    }
 
}
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*ФУНКЦИЯ ДОБАЛЕНИЯ ПРЕДУСТАНОВЛЕНННЫХ ДАННЫХ ИЗ ФАЙЛА В ТАБЛИЦЫ ПЛАГИНА ПРИ АКТИВАЦИИ ПЛАГИНА*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function wp_cuts_dsp_add_tables_data () {
    global $wpdb;
    if($wpdb->get_var("SELECT COUNT(*) FROM ".DSP_WIDTH."") == 0) {
        if (file_exists(ROOT_FOLDER.'config/width-dsp.ini') && is_readable(ROOT_FOLDER.'config/width-dsp.ini')){
            $file=array_unique(file(ROOT_FOLDER.'config/width-dsp.ini', FILE_SKIP_EMPTY_LINES));
                foreach ($file as $width) {
                    $width=trim($width);
                    if(!empty($width) && $width[0] != "#") {
                        $width=(int)$width;
                        if ((is_int($width)) && ($width > 0)) 
                            {  
                                $wpdb->insert(DSP_WIDTH, array
                                          (
                                              'width'=>$width
                                          ), array('%d') 
                                              );   
                            } 
                    }
             }
        }
    }
    if($wpdb->get_var("SELECT COUNT(*) FROM ".EDGE_SIZE."") == 0) {
        if (file_exists(ROOT_FOLDER.'config/size-edge.ini') && is_readable(ROOT_FOLDER.'config/size-edge.ini')){
            $size_edge = array_unique(file(ROOT_FOLDER.'config/size-edge.ini', FILE_SKIP_EMPTY_LINES));
            foreach ($size_edge as $size){
                $size = trim($size);
                if(!empty($size) && $size[0] != "#") {
                    $size_array = explode ('x', $size);
                        $size = (int)$size_array[0];
                        $width = (int)$size_array[1];
                        if (((is_int($width)) && ($width > 0)) && ((is_int($size)) && ($size>0))){
                           $wpdb->insert(EDGE_SIZE, array
                                          (
                                              'width'=>$width,
                                              'size' =>$size
                                          ), array('%d', '%d') 
                                              );   
                       }  
                    }
            }
            }
        }
    
    if($wpdb->get_var("SELECT COUNT(*) FROM ".COLOR_ITEM."") == 0) {
        if (file_exists(ROOT_FOLDER.'config/colors.ini') && is_readable(ROOT_FOLDER.'config/colors.ini')){
            $colors = array_unique(file(ROOT_FOLDER.'config/colors.ini', FILE_SKIP_EMPTY_LINES));
            foreach ($colors as $color){
                $color = trim($color);
                if(isset($color) && !empty($color) && ($color[0] != '#')){
                    $color_array = explode (':', $color);
                        if(is_string($color_array[0])) $color_name = trim($color_array[0]);
                        if(is_string($color_array[1])) $color_code = trim($color_array[1]);   
                        //Добаляем в базу данных
                        $wpdb->insert(COLOR_ITEM, array
                                      (
                                          'color_name'=>$color_name,
                                          'color_code' =>$color_code
                                      ), array('%s', '%s') 
                                          );   
                           }
            }
        }   
 
     }
}

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*ФУНКЦИИ УДАЛЕНИЯ ТАБЛИЦ ПЛАГИНА В БД ПРИ УДАЛЕНИИ ПЛАГИНА*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*Функция удаления таблиц при удалении плагина*/
function wp_cuts_dsp_del_tables () {
	global $wpdb;
		$wpdb->query("set foreign_key_checks=0");
		$wpdb->query("DROP TABLE IF EXISTS  ".DSP_TYPE."");
		$wpdb->query("DROP TABLE IF EXISTS  ".DSP_WIDTH."");
		$wpdb->query("DROP TABLE IF EXISTS  ".EDGE_TYPE."");
		$wpdb->query("DROP TABLE IF EXISTS  ".EDGE_SIZE."");
		$wpdb->query("DROP TABLE IF EXISTS  ".COLOR_ITEM."");
		$wpdb->query("DROP TABLE IF EXISTS  ".COLOR_CROSS_DSP."");
		$wpdb->query("DROP TABLE IF EXISTS  ".COLOR_CROSS_EDGE."");
		$wpdb->query("set foreign_key_checks=1");
}

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*ФУНКЦИИ ПОЛУЧЕНИЯ ДАННЫХ ИЗ ТАБЛИЦ БАЗЫ ДАННЫХ ПЛАГИНА*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*Получение данных из таблиц типов ДСП и связанных таблиц*/
function select_data () {
    global $wpdb;
    return $data = $wpdb->get_results("SELECT ".DSP_TYPE.".id_dsp, ".DSP_TYPE.".type, ".DSP_TYPE.".cash, ".DSP_WIDTH.".id_width, ".DSP_WIDTH.".width, GROUP_CONCAT(".COLOR_ITEM.".color_code)  as colors, GROUP_CONCAT(".COLOR_ITEM.".id_color)  as id_colors, GROUP_CONCAT(".COLOR_ITEM.".color_name)  as colors_name FROM ".DSP_TYPE." 
        left join ".DSP_WIDTH." USING(id_width)
        left join ".COLOR_CROSS_DSP." ON ".DSP_TYPE.".id_dsp = ".COLOR_CROSS_DSP.".id_type 
        left join ".COLOR_ITEM." USING (id_color)
            GROUP BY ".DSP_TYPE.".id_dsp
            ORDER BY ".DSP_TYPE.".id_dsp DESC" );
}
/*Получение данных из таблиц размеров ДСП*/ 
function dsp_width() {
    global $wpdb;
    return $width = $wpdb->get_results("SELECT * FROM ".DSP_WIDTH." ORDER BY width ASC");
}
/*Функция получения конкретнного типа ДСП*/
function show_dsp_id ($id) {
    global $wpdb;
    return $width = $wpdb->get_results("SELECT *, GROUP_CONCAT(id_color) as id_color FROM ".DSP_TYPE."
            left join ".DSP_WIDTH." ON ".DSP_TYPE.".id_width = ".DSP_WIDTH.".id_width 
            left join ".COLOR_CROSS_DSP." ON ".DSP_TYPE.".id_dsp = ".COLOR_CROSS_DSP.".id_type
            WHERE ".DSP_TYPE.".id_dsp = $id");
}
/*Функция получения данных из таблицы типов кромки*/
function show_edge_type () {
    global $wpdb;
    return $width = $wpdb->get_results("SELECT ".EDGE_TYPE.".id_edge, ".EDGE_TYPE.".type, ".EDGE_TYPE.".cash, ".EDGE_SIZE.".width ,".EDGE_SIZE.".size, GROUP_CONCAT(".COLOR_ITEM.".color_code)  as colors, GROUP_CONCAT(".COLOR_ITEM.".id_color)  as id_colors, GROUP_CONCAT(".COLOR_ITEM.".color_name)  as colors_name  FROM ".EDGE_TYPE." 
            left join ".EDGE_SIZE." USING(id_size) 
            left join ".COLOR_CROSS_EDGE." ON ".EDGE_TYPE.".id_edge = ".COLOR_CROSS_EDGE.".id_type 
            left join ".COLOR_ITEM." USING (id_color)
                GROUP BY ".EDGE_TYPE.".id_edge
                ORDER BY ".EDGE_TYPE.".id_edge DESC");
}
/*Функция получения конкретнного типа кромки*/
function show_edge_id($id) {
    global $wpdb;
    return $edge = $wpdb->get_results("SELECT *, GROUP_CONCAT(id_color) as id_color FROM ".EDGE_TYPE." 
            left join ".EDGE_SIZE." ON ".EDGE_TYPE.".id_size = ".EDGE_SIZE.".id_size 
            left join ".COLOR_CROSS_EDGE." ON ".EDGE_TYPE.".id_edge = ".COLOR_CROSS_EDGE.".id_type
            WHERE ".EDGE_TYPE.".id_edge = $id");
}
/*Функция получения цветов из таблицы цветов*/
function show_color () {
    global $wpdb;
    return $color = $wpdb->get_results ("SELECT * FROM ".COLOR_ITEM." ORDER BY id_color DESC"); 
}
/*Функция получения размеров кромки*/
function edge_size () {
     global $wpdb;
     return $width = $wpdb->get_results("SELECT * FROM ".EDGE_SIZE." ORDER BY width ASC");
}

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*ФУНКЦИИ УДАЛЕНИЯ ДАННЫХ ИЗ ТАБЛИЦ БАЗЫ ДАННЫХ ПЛАГИНА*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*Функция удаления записи ДСП из таблицы*/
function dsp_type_delete($id){
    global $wpdb;
    if($wpdb->query("DELETE FROM ".DSP_TYPE." WHERE id_dsp = $id")) return true;
}
/*Функция удаления записи размера ДСП из таблицы*/
function delete_dsp_width($id) {
    global $wpdb;
    if($wpdb->query("DELETE FROM ".DSP_WIDTH." WHERE id_width = $id")) return true;
}
/*Функция удаления записи типа кромки из таблицы*/
function edge_type_delete($id) {
    global $wpdb;
    if($wpdb->query("DELETE FROM ".EDGE_TYPE." WHERE id_edge = $id")) return true;
}
/*Функция удаления размера кромки из таблицы*/
function delete_edge_size ($id) {
    global $wpdb;
    if($wpdb->query("DELETE FROM ".EDGE_SIZE." WHERE id_size = $id")) return true;
}

/*Функция удаления цвета*/
function color_delete ($id) {
    global $wpdb;
    if($wpdb->query("DELETE FROM ".COLOR_ITEM." WHERE id_color = $id")) return true;
}
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*ФУНКЦИИ ДОБАВЛЕНИЯ ДАННЫХ В ТАБЛИЦЫ БАЗЫ ДАННЫХ ПЛАГИНА*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function add_type_dsp_insert ($name, $cash, $width_dsp, $colors) {
    global $wpdb;
    $wpdb->insert(DSP_TYPE, array(
        'type'=>$name,  
        'cash'=>$cash,
        'id_width'=>$width_dsp
    ), array('%s','%d','%d')
            )  ;
   
    $id_new_dsp = $wpdb->insert_id; 
    foreach ($colors as $color) {
        $wpdb->insert(COLOR_CROSS_DSP, array(
        'id_type'    =>  $id_new_dsp,  
        'id_color'  =>  $color
    ), array('%d','%d')
            ) ;
    }  
        return true;
}

function add_width_dsp_insert ($width) {
    global $wpdb;
    if($wpdb->insert(DSP_WIDTH, array(
        'width'=>$width, 
    ), array('%d')
            ) ) 
            return true;
}
function add_size_edge_insert($size, $width) {
    global $wpdb;
    if($wpdb->insert(EDGE_SIZE, array(
        'width'=>$width, 
        'size' =>$size
    ), array('%d', '%d')
            ) ) 
            return true;
    
}
function add_type_edge_insert ($type, $cash, $id_size, $colors) {
     global $wpdb;
     $wpdb->insert(EDGE_TYPE, array(
        'type'=>$type, 
        'cash' => $cash,
        'id_size' =>$id_size
    ), array('%s','%d','%d')
            );
    $id_new_edge = $wpdb->insert_id; 
    foreach ($colors as $color) {
        $wpdb->insert(COLOR_CROSS_EDGE, array(
        'id_type'    =>  $id_new_edge,  
        'id_color'  =>  $color
    ), array('%d','%d')
            ) ;
    }  
        return true;
}


/*Функция добавления цввета в таблицу*/
function add_color_insert ($color_name, $color_code) {
     global $wpdb;
        if($wpdb->insert(COLOR_ITEM, array(
            'color_name'=>$color_name, 
            'color_code' =>$color_code
    ), array('%s', '%s')
            ) ) 
            return true;
}
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/



/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*ФУНКЦИИ ИЗМЕНЕНИЯ ДАННЫХ В ТАБЛИЦАХ БАЗЫ ДАННЫХ ПЛАГИНА*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function dsp_edit_type ($name, $cash, $id_width, $id_dsp) {
     global $wpdb;
     if($wpdb->update(DSP_TYPE, array(
            'type'=>$name,
            'cash'=>$cash,
            'id_width'=>$id_width
     ), array('id_dsp' =>$id_dsp), array('%s','%d','%d'), array('%d')))return true;
}

function edge_edit_type ($type, $cash, $id_size, $id) {
    global $wpdb;
     if($wpdb->update(EDGE_TYPE, array(
            'type'=>$type, 
            'cash' => $cash,
            'id_size' =>$id_size
     ), array('id_edge' =>$id), array('%s','%d','%d'), array('%d')))return true;
}

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/



/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*СОЗДАНИЕ СТРАНИЦ ПЛАГИНА В АДМИНКЕ*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*Создание страницы настроек и отображения плагина*/
function dsp_admin_menu () {
    add_menu_page( 'ДСП', 'ДСП', 'manage_options', 'wp-cut-dsp/dsp.php', '' ); 
    add_submenu_page('wp-cut-dsp/dsp.php', 'Добавить тип ДСП', 'Добавить тип ДСП', 'manage_options', 'wp-cut-dsp/add_dsp_type.php', '');
    add_submenu_page('wp-cut-dsp/dsp.php', 'Добавить размер ДСП', 'Добавить размер ДСП', 'manage_options', 'add_dsp_size', 'add_dsp_size');
    add_submenu_page('wp-cut-dsp/dsp.php', 'Кромка', 'Кромка', 'manage_options', 'edge_show', 'show_edge');
    add_submenu_page('wp-cut-dsp/dsp.php', 'Добавить кромку', 'Добавить кромку', 'manage_options', 'add_edge', 'add_edge_type');
    add_submenu_page('wp-cut-dsp/dsp.php', 'Добавить размер кромки', 'Добавить размер кромки', 'manage_options', 'add_edge_size', 'add_edge_size');
    add_submenu_page('wp-cut-dsp/dsp.php', 'Цвет дсп и кромки', 'Цвет дсп и кромки', 'manage_options', 'show_color', 'show_color_type'); 
    add_submenu_page('wp-cut-dsp/dsp.php', 'Добавить цвет', 'Добавить цвет', 'manage_options', 'add_color', 'add_color');
    add_submenu_page('wp-cut-dsp/dsp.php', 'Курсы валют', 'Курсы валют', 'manage_options', 'kursExchange', 'kursExchange');   
}

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*ФУНКЦИИ ДЛЯ СТРАНИЦ ПЛАГИНА В АДМИНКЕ*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*Функция получения курсов валют через API БЕЛАРУСБАНКА*/
function kursExchange() {
    $url_kurs_belarusbank_api = 'https://belarusbank.by/api/kursExchange?city=Брест';
    $json_data = file_get_contents($url_kurs_belarusbank_api);
    $info = json_decode($json_data, true);
    include (ROOT_FOLDER.'views/show_kurs.php');          
}


/*Функция для страницы КРОМКИ*/
function show_edge () {
     $edge_type = show_edge_type();
     $bin_usd = bin_usd();
            include ROOT_FOLDER.'views/show_edge_type.php';
}

/*Функция для страницы ДОБАВЛЕНИЯ КРОМКИ УДАЛЕНИЯ и РЕДАКТИРОВАНИЯ*/
function add_edge_type () {
        $action = isset($_GET['action']) ? $_GET['action'] : null;
        $id_edge = isset($_GET['id']) ? $_GET['id'] : null;
    
    switch($action){
        case 'add':
            if(isset($_POST) && !empty($_POST)) { 
                         if ($_POST['name'])         { $name = trim($_POST['name']);}
                         if ($_POST['cash'])         { $cash = (int)(($_POST['cash']));}
                         if ($_POST['edge_size'])    { $edge_size = (int)(($_POST['edge_size']));}
                         if ($_POST['color_edge'])    {$color_edge = $_POST['color_edge'];}
                        $add_status = add_type_edge_insert($name, $cash, $edge_size, $color_edge);
                        if ($add_status) {
                            header("Location: admin.php?page=edge_show");
                        }else echo ERROR_MESSAGE;break;
                }else {
                        $color=show_color();
                        $edge_size=edge_size();
                        include (ROOT_FOLDER.'views/add_edge_type.php'); break;
                    }
        case 'edit':
            if($_GET['id']) {$id_edge = (int)$_GET['id'];}
                        if (isset($_POST) && !empty($_POST)) {
                                if ($_POST['name'])         { $name = trim($_POST['name']);}
                                if ($_POST['cash'])         { $cash = (int)(($_POST['cash']));}
                                if ($_POST['edge_size'])    { $edge_size = (int)(($_POST['edge_size']));} 
                                if ($_POST['color_edge'])    {$color_edge = $_POST['color_edge'];}
                                edge_edit_type($name, $cash, $edge_size, $id_edge, $color_edge);
                                if(color_dsp_cross_edit($id_edge, $color_edge, COLOR_CROSS_EDGE))
                                    {
                                        header("Location: admin.php?page=edge_show");
                                        break;     
                                    }               
                        }else {
                            $edge_size = edge_size();
                            $edge_show = show_edge_id($id_edge);
                            $color=show_color();
                            include (ROOT_FOLDER.'views/edit_size.php'); break;                     
                        }
        case 'delete':
            if($_GET['id']) {$id_edge = (int)$_GET['id'];}
                        if(edge_type_delete($id_edge) == true)
                            {
                               header("Location: admin.php?page=edge_show"); break;                               
                            }else echo ERROR_MESSAGE;break;
        default:
            $color=show_color();
            $edge_size = edge_size ();
            include ROOT_FOLDER.'views/add_edge_type.php';
    } 
} 

/*Функция для страницы ДОБАВЛЕНИЯ РАЗМЕРА ДСП*/
function add_dsp_size () {
        global $wpdb;
        $action = isset($_GET['action']) ? $_GET['action'] : null;
        $id_width = isset($_GET['id']) ? $_GET['id'] : null;
                              if($action == 'add_width'){                               
                                   if (isset($_POST) && !empty($_POST)) {
                                        if ($_POST['dsp_width']) { 
                                            $width_dsp = (int)(($_POST['dsp_width']));
                                            if($wpdb->get_var("SELECT COUNT(*) FROM ".DSP_WIDTH." WHERE width = $width_dsp") == 0) {
                                                if(add_width_dsp_insert($width_dsp)){
                                                    echo '<div>Данные добавлены</div>';
                                                  }else echo '<div>Ошибка</div>';
                                                }else echo '<div>Данный размер уже есть в базе</div>';
                                            }
                                        }       
                                    }elseif 
                                 ($action == 'delete_width'){
                                        if(delete_dsp_width($id_width)){
                                            echo '<div>Данные удалены</div>';
                                        };
                        }
    $dsp_width = dsp_width();
    include ROOT_FOLDER.'views/add_dsp_width.php';  
}

/*Функция для страницы ДОБАВЛЕНИЯ РАЗМЕРА КРОМКИ*/
function add_edge_size () {
        global $wpdb;
        $action = isset($_GET['action']) ? $_GET['action'] : null;
        $id_edge = isset($_GET['id']) ? $_GET['id'] : null;
                              if($action == 'add_size'){ 
                                   if (isset($_POST) && !empty($_POST)) {
                                        if ($_POST['edge_size']){$edge_size = (int)$_POST['edge_size'];}
                                        if ($_POST['edge_width']){$edge_width = (int)$_POST['edge_width'];}  
                                         if($wpdb->get_var("SELECT COUNT(*) FROM ".EDGE_SIZE." WHERE width = $edge_width AND size = $edge_size") == 0) {
                                            if(add_size_edge_insert($edge_size, $edge_width)){
                                                echo '<div>Данные добавлены</div>';
                                              }else echo '<div>Ошибка</div>';
                                         }else echo '<div>Указанный размер уже есть в базе</div>';
                                }
                        }elseif 
                                 ($action == 'delete_size'){
                                        if(delete_edge_size($id_edge)){
                                            echo '<div>Данные удалены</div>';
                                        }else echo "ERROR";
                        }
    $edge_size = edge_size();
    include ROOT_FOLDER.'views/add_edge_size.php';
}


/*Функция для страницы ЦВЕТА ДСП И КРОМКА*/
function show_color_type () {
    $action = isset($_GET['action']) ? $_GET['action'] : null;
    $id_color = isset($_GET['id']) ? $_GET['id'] : null;
    
    switch($action){

                case 'delete':
                     if($_GET['id']) {$id_color = (int)$_GET['id'];}
                                 if(color_delete($id_color) == true)
                                     {
                                        header("Location: admin.php?page=show_color"); break;                               
                                     }else echo ERROR_MESSAGE;break;
                default:
                     $colors = show_color();
                     include ROOT_FOLDER.'views/show_colors.php';
         }
}

/*ФУНКЦИЯ ДОБАВЛЕНИЯ ЦВЕТА В БД*/
function add_color () {
    global $wpdb;
    $id_color = isset($_GET['id']) ? $_GET['id'] : null;
                    if (isset($_POST) && !empty($_POST)) {
                            if ($_POST['color_name']){$color_name = $_POST['color_name'];}
                            if ($_POST['color_code']){$color_code = '#'.$_POST['color_code'];} 

                            if($wpdb->get_var("SELECT COUNT(*) FROM ".COLOR_ITEM." WHERE color_code = '$color_code'") == 0) 
                                {
                                        if(add_color_insert($color_name, $color_code) == true)
                                                {
                                                    header("Location: admin.php?page=show_color");     
                                                }else echo '<div>Ошибка</div>';
                                }else 
                                    {
                                        echo '<div>данный цвет есть в базе</div>';    
                                    }      
                    }    
               $colors = show_color();
               include ROOT_FOLDER.'views/add_colors.php';    
}

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*ФУНКЦИИ ДЛЯ ПОДКЛЮЧЕНИЯ СКРИПТОВ И СТИЛЕЙ*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*Подключение стилей и скриптов для админки плагина*/
function wp_admin_cuts_dsp_sctipts($hook) {
        //Скрипт для правильного ввода данных полей в админке
        wp_enqueue_script('wp-cuts-forms-valid', URL_ROOT_FOLDER.'/js/wp-cuts-forms-valid.js', array('jquery'), null, true);
        //Скрипт подтверждения удаления элемента 
        wp_enqueue_script('confirm', URL_ROOT_FOLDER.'/js/confirm-delete.js');
        //Стили оформления для админской части плагина
        wp_enqueue_style ('wp-cuts-plugin-admin-style', URL_ROOT_FOLDER.'/css/wp-cuts-plugin-admin-style.css');
        
    wp_enqueue_style ('bootstrap', URL_ROOT_FOLDER.'/css/bootstrap.min.css');   
    wp_enqueue_script('bootstrap', URL_ROOT_FOLDER .'/js/bootstrap.min.js', array(), 'v3.3.7', true);
  
    wp_enqueue_style ('bootstrap-select-css', URL_ROOT_FOLDER.'/css/bootstrap-select.min.css');   
    wp_enqueue_script('bootstrap-select-js', URL_ROOT_FOLDER .'/js/bootstrap-select.min.js');
    
    /*Плагин выбора цвета*/
    wp_enqueue_style ('bootstrap-colorpicker-css', URL_ROOT_FOLDER.'/css/bootstrap-colorpicker.min.css');   
    wp_enqueue_script('bootstrap-colorpicker-js', URL_ROOT_FOLDER .'/js/bootstrap-colorpicker.min.js');
    wp_enqueue_script('colorpicker-js', URL_ROOT_FOLDER .'/js/colorpicker.js');
    
    /*Плагин сортировки для таблиц*/
    wp_enqueue_script('jquery-tablesorter-js', URL_ROOT_FOLDER .'/js/jquery.tablesorter.min.js');
    wp_enqueue_script('sorttable-js', URL_ROOT_FOLDER .'/js/sorttable.js');

}

/*Функция формирования option для select Результат запроса GROUP CONCAT получение массива через explode PHP*/
function option_color_dsp_edge_type($d) {
                        $colors_code =  explode(',', $d->colors);
                        $colors_name =  explode(',', $d->colors_name);
                        $colors= array_combine($colors_name, $colors_code);
                        $color='<option></option>'; 
                        
                                foreach ($colors as $color_name=>$color_code) {
                                    $color.= '<option style="background-color:'.$color_code.'; color: #fff;">'.$color_name.'</option>';
                                }
                        return $color;
}

function colors_array_id ($d) {
    return explode(',', $d->id_color);
}




/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*ФУНКЦИИ ДЛЯ УДАЛЕНИЯ И ДОБАВЛЕНИЯ ДАННЫХ В КРОССТАБЛИЦУ ПРИ СВЯЗИ МНОГИЕ КО МНОГИМ (СООТВЕТСТВИЕ ЦВЕТОВ И ДСП, ЦВЕТОВ И КРОМКИ)*/
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*Функция удаления соответствия из кросстаблицы*/
function del_dsp_cross_table($id_dsp, $id_color, $table_cross_name) {
    global $wpdb;
    if($wpdb->query("DELETE FROM $table_cross_name WHERE id_type = $id_dsp and id_color=$id_color")) return true;  
}

/*Фунция добавления соостветствия в кросстаблицу*/
function add_dsp_cross_table($id_dsp, $id_color, $table_cross_name) {
    global $wpdb;
    if($wpdb->insert($table_cross_name, array(
        'id_type'=>$id_dsp,  
        'id_color'=>$id_color
    ), array('%d','%d')
            )) return true;
}  
/*Функция получения id цветов из кроссовой таблицы для определенного типа дсп или кромки*/
function show_id_color_cross($id, $table_cross_name) {   
    global $wpdb;
    return $color_id = $wpdb->get_results("SELECT GROUP_CONCAT(id_color) as id_colors FROM $table_cross_name WHERE id_type = ".$id."");
}

/*Функция обновления кросс таблицы соответствия цветов и дсп или цветов и кромки*/
function color_dsp_cross_edit($id_dsp, $id_color_array, $table_cross_name){
    /*Получение текущих цветов ДСП*/
    $colors_id = show_id_color_cross($id_dsp, $table_cross_name);
    /*Преобразуем в массив используя explode*/
    if (isset($colors_id) && !empty($colors_id)){
        foreach ($colors_id as $color_array) {
            $colors_id_old = explode(',', $color_array->id_colors);
        }
    }
    
    /*Сравнение id текущих цветов и новыми. Если выбран новый цвет его id в текущих будет отсутствовать поэтому будет 
     * выполнен INSERT в кроссовую таблицу.  */
    foreach ($id_color_array as $array_id){
        if (($key = array_search($array_id,$colors_id_old)) !== FALSE){
            unset($colors_id_old[$key]);
        }else {
            add_dsp_cross_table($id_dsp, $array_id, $table_cross_name);
        } 
    }
    
    if(!empty($colors_id_old)){
        foreach($colors_id_old as $id_color_del){
                del_dsp_cross_table($id_dsp,$id_color_del, $table_cross_name);
            } 
        }
   return true;
}
/*-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/


/*Функция получения курса валют BIN-USD*/
function bin_usd() {
    $url_kurs_belarusbank_api = 'https://belarusbank.by/api/kursExchange?city=Брест';
    $json_data = file_get_contents($url_kurs_belarusbank_api);
    $info = json_decode($json_data, true);
    $exc =0;
    foreach ($info as $usd) {
        if ($usd['USD_out']>$exc){
            $exc=$usd['USD_out'];
        }
    }
    return $exc;
}