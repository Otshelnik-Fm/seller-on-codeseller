<?php

/*

╔═╗╔╦╗╔═╗╔╦╗
║ ║ ║ ╠╣ ║║║ https://otshelnik-fm.ru
╚═╝ ╩ ╚  ╩ ╩

*/


require_once 'inc/settings.php';    // подключаем настройки
require_once 'inc/resources.php';   // подключаем ресурсы



// регистрируем шорткод
function soc_shortcode($atts){
    if( !class_exists('SOC_Shortcode') ){
        require_once('inc/class-soc-shortcode.php');
    }
    $shrt = new SOC_Shortcode($atts);
    return $shrt->get_products();
}
add_shortcode('codeseller_product','soc_shortcode');



// сформируем урл
function soc_get_link($product_id, $disable_ref){
    $partner_id = '';
    $url = 'https://codeseller.ru/';

    if($disable_ref == 0){
        $partner_id = rcl_get_option('soc_prtnr_id');
    }

    if($partner_id){
        $url .= '?product-ref='.$partner_id.'-'.$product_id;
    } else {
        $url .= '?p='.$product_id;
    }

    return $url;
}

