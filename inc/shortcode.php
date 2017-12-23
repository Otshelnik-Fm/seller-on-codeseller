<?php

if (!defined('ABSPATH')) exit; // запрет прямого доступа к файлу



// шорткод
function soc_get_local_addons_info($atts){
    $attrs = shortcode_atts(array(
                'template' => 'list',
             ), $atts, 'ofm_addons_info');

    global $rcl_options, $soc_xml_data;         // настройки реколл и переменная для передачи в темплейт данных

    $soc_path = RCL_UPLOAD_PATH.'seller-xml/';  // наша папка под файлы
    if (count(glob($soc_path.'*')) === 0 ) {    // если папка еще пуста - останавливаем. Выводим мессадж
        return soc_first_info();
    }

    $ids = explode(',',$rcl_options['soc_id_addons']);
    $out = '<div id="soc_list_box" class="soc_addon_wrapper">';

        $out .= soc_filter_button(); // кнопки фильтра

        $out .= '<div class="shipment_wrapper">';
            $i = 0;
            foreach($ids as $k => $id_one){
                $i++;
                $id_one = trim($id_one);                                // очищаем от возможных пробелов
                $soc_path_file = $soc_path.$id_one.'.xml';              // путь и имя файла
                $soc_xml_data = simplexml_load_file($soc_path_file);    // грузим файл

                $out .= '<div class="soc_blk" data-num="'.$i.'" data-price="'.$soc_xml_data->price.'" data-popular="'.$soc_xml_data->downloads.'" data-name="'.$soc_xml_data->name.'">';
                $out .= rcl_get_include_template('soc-'.esc_html($attrs['template']).'.php',__FILE__); // цепляем шаблон
                $out .= '</div>';
            }
        $out .= '</div>'; /* END shipment_wrapper */

    $out .= '</div>'; /* END soc_addon_wrapper */
    return $out;
}
add_shortcode('ofm_addons_info','soc_get_local_addons_info');



// шорткод рандомных
function soc_random_shortcode(){
    return soc_random_box();
}
add_shortcode('ofm_addons_random','soc_random_shortcode');
