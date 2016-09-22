<?php

// подключаем настройки
require_once('settings.php');

// скрипты и стили поддерживают объединение от реколл
function soc_load_style(){
    rcl_enqueue_style('soc_cool_style',rcl_addon_url('style.css', __FILE__));
    rcl_enqueue_script('soc_cool_script', rcl_addon_url('inc/script.js', __FILE__));
}
if (!is_admin()){
    add_action('rcl_enqueue_scripts','soc_load_style',10);
}


// сообщение первой активации
function soc_first_info(){
    $out_empty = '<strong>Файлы еще не получены</strong><br/><br/>';
    $out_empty .= 'Проверьте что вы вписали и сохранили id дополнений в настройках в админке.<br/>';
    $out_empty .= 'В течении часа файлы будут получены.<br/>';
    $out_empty .= 'Если по истечению этого времени файлов нет - возможно у вас проблема с кроном.';
    return $out_empty;
}


// кнопки фильтра
function soc_filter_button(){
    $out = '<div class="soc_sort_wrapper">';
        $out .= '<div class="soc_first_line">';
        $out .=     '<span>Сортировка по цене:</span>';
        $out .=     '<div class="soc_sort">';
        $out .=         '<i class="fa fa-sort-amount-desc soc_button" title="От большего к меньшему"></i><i class="fa fa-sort-amount-asc soc_button" title="От меньшего к большему"></i>';
        $out .=     '</div>';
        $out .=     '<div class="soc_premium soc_button"><i class="fa fa-usd"></i>Премиум</div>';
        $out .=     '<div class="soc_reset soc_button"><i class="fa fa-refresh"></i>Сброс</div>';
        $out .= '</div>';

        $out .= '<div class="soc_second_line">';
        $out .=     '<div class="soc_popular soc_button" title="По скачиванию"><i class="fa fa-download"></i>Популярные</div>';
        $out .=     '<div class="soc_alphabet soc_button"><i class="fa fa-sort-alpha-asc"></i>По алфавиту</div>';
        $out .= '</div>';
    $out .= '</div>'; /* END soc_sort_wrapper */
    return $out;
}


// шорткод
function soc_get_local_addons_info($atts){
    $attrs = shortcode_atts(array(
                'template' => 'list',
             ), $atts, 'ofm_addons_info');

    global $rcl_options, $soc_xml_data;         // настройки реколл и переменная для передачи в темплейт данных

    $soc_path = RCL_UPLOAD_PATH.'seller-xml/';  // наша папка под файлы
    if (count(glob($soc_path.'*')) === 0 ) {    // если папка еще пуста - останавливаем. Выводим мессадж
        $out_empty = soc_first_info();
        return $out_empty;
    }

    $ids = explode(',',$rcl_options['soc_id_addons']);
    $out = '<div class="soc_addon_wrapper">';

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


// удаленный запрос: раз в час - копирование на свой сервер
function soc_remote_get_addons_info(){

    global $rcl_options;
    $ids = explode(',',$rcl_options['soc_id_addons']);

    foreach($ids as $k => $id_one){
        $id_one = trim($id_one);                                                            // очищаем от возможных пробелов
        $url = 'http://downloads.codeseller.ru/products-files/info/'.$id_one.'/info.xml';   // путь до удаленного файла
        $resp = wp_remote_get(                                                              // удаленный запрос с таймаутом в 5 сек
            $url,
            array('timeout' => 5,)
        );

        if( wp_remote_retrieve_response_code($resp) === 200 ){              // код ответа 200
            $body = wp_remote_retrieve_body( $resp );                       // получаем файл
            $soc_path_file = RCL_UPLOAD_PATH.'seller-xml/'.$id_one.'.xml';  // путь и имя файла
            file_put_contents($soc_path_file, $body);                       // если нет файла - создаем. И/или открываем и пишем
        }
    }
}
add_action('rcl_cron_hourly','soc_remote_get_addons_info');

