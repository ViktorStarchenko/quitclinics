<?php


//SHOW 3 LEVEL MENU
function wp_get_menu_array($current_menu) {

    $array_menu = wp_get_nav_menu_items($current_menu);
    $menu = array(); // Создаем массив для меню
    foreach ($array_menu as $m) { // Добавляем верхний уровень меню.
        if (empty($m->menu_item_parent)) { // Создаем верхние пункты меню у которых нет родителя
            $menu[$m->ID] = array();
            $menu[$m->ID]['ID']      =   $m->ID;
            $menu[$m->ID]['title']       =   $m->title;
            $menu[$m->ID]['url']         =   $m->url;
            $menu[$m->ID]['children']    =   array();
        }
    }
    $submenu = array(); // Массив для подпунктов меню второго и третьего уровня
    $menu_items = array(); //Создаем контрольный проверочный массив с ID пунктов и подпунктов меню и ID их родителей
    foreach ($array_menu as $m) {
        if ($m->menu_item_parent) {

            $menu_items[$m->ID] = array(); // наполняем контрольный проверочный массив пунктов меню
            $menu_items[$m->ID]['ID'] = $m->ID;
            $menu_items[$m->ID]['parent'] = $m->menu_item_parent;

            $submenu[$m->ID] = array(); // Создаем подпункты у которых есть родитель
            $submenu[$m->ID]['ID']       =   $m->ID;
            $submenu[$m->ID]['title']    =   $m->title;
            $submenu[$m->ID]['url']  =   $m->url;
            $submenu[$m->ID]['children']  =   array();

            foreach ($menu_items as $menu_item) { // Перебираем контрольный массив
                if ( $menu_item['ID']  == $m->menu_item_parent and !empty($menu_item['parent']) ) { // Если ID пункта меню равен ID родителя нашего подменю тогда получаем ID родителя у родитя нашего меню
                    $parent_id = $menu_item['parent'];
                    // echo $menu_item['parent'];
                    // echo '|';
                    // echo 'НАШ КЛИЕНТ';
                    // echo '<hr>';

                    $menu[$parent_id]['children'][$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID]; // Если все так тогда добавляем пункт третьего уровня вложенности дочерним пункту второго уровня
                } else {
                    $menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID]; // если же у
                }
            }

        }

    }

    return $menu;
}


//SET ANCHOW TO MENU LINK
function setAnchor($url) {
    $current_url = $_SERVER['REQUEST_URI'];
    if (!empty($current_url)) {
        $current_url = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$current_url);
        if ( strpos($url, '/' . $current_url . '#') !== false ) {
            $arr=explode('#',$url);
            $anchor = '#'.end($arr);
            return $anchor;
        } else {
            return $url;
        }
    }
}