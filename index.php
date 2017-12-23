<?php

/*

╔═╗╔╦╗╔═╗╔╦╗
║ ║ ║ ╠╣ ║║║ https://otshelnik-fm.ru
╚═╝ ╩ ╚  ╩ ╩

*/

// подключаем настройки
require_once 'inc/settings.php';

// скрипты и стили поддерживают объединение от реколл
function soc_load_resource(){
    global $post;
    $id_page = rcl_get_option('soc_id_all','all-pages');

    // находимся на той странице что указана в настройках или не указано (значит на всех нужны) - грузим ресурсы
    if( $post->ID == $id_page || $id_page == 'all-pages' ){
        rcl_enqueue_style('soc_cool_style',rcl_addon_url('res/soc-style.css', __FILE__));
        rcl_enqueue_script('soc_cool_script', rcl_addon_url('res/soc-script.js', __FILE__));
    }
}
if (!is_admin()){
    add_action('rcl_enqueue_scripts','soc_load_resource',10);
}


// стиль для рандомного вывода допов
function soc_load_random(){
    global $post;
    $id_page = rcl_get_option('soc_id_rand','all-pages');

    if( $post->ID == $id_page || $id_page == 'all-pages' ){
        rcl_enqueue_style('soc_rand_style',rcl_addon_url('res/soc-card.css', __FILE__));
    }
}
if (!is_admin()){
    add_action('rcl_enqueue_scripts','soc_load_random',10);
}


// сообщение первой активации
function soc_first_info(){
    $out_empty = '<div>Файлы еще не получены.</div>';
    $out_empty .= 'Проверьте - что вы вписали и сохранили id дополнений в настройках в админке.<br/>';
    $out_empty .= 'В течении часа файлы будут получены.<br/>';
    $out_empty .= 'Если по истечению этого времени файлов нет - возможно у вас проблема с кроном.';

    return '<div class="soc_no_data">'.$out_empty.'</div>';
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






// случайная выборка n-товаров
function soc_get_priceless_items(){
    $soc_path = RCL_UPLOAD_PATH.'seller-xml/';  // наша папка под файлы
    if (count(glob($soc_path.'*')) === 0 ) {    // если папка еще пуста - останавливаем
        return false;
    }

    $ids = explode(',',rcl_get_option('soc_id_addons'));
    foreach($ids as $k => $id_one){
        $id_one = trim($id_one);                        // очищаем от возможных пробелов
        $soc_path_file = $soc_path.$id_one.'.xml';      // путь и имя файла

        if (!file_exists($soc_path_file)) continue;     // нет файла

        $data = simplexml_load_file($soc_path_file);    // грузим файл
        if($data->price == 0) continue;                 // бесплатные нам не нужны

        $datas[] = (array)$data;
    }


    if(!isset($datas)) return false;            // ничего нет

    $num = 4;                                   // надо нам 4-ре товара
    $count = count($datas);                     // посчитаем по факту
    if($count < 4) $num = $count;               // если меньше - то сколько есть выводим
    if($count == 1) return $datas;              // один элемент. Прекратим, сортировать нечего рандомом

    $soc_card_datas = array_rand($datas,$num);  // перемешиваем индексы массива и выбираем n-кол-во

    foreach($soc_card_datas as $soc_card_dat){  // новый массив
        $dat[] = $datas[$soc_card_dat];
    }

    return $dat;
}


// и ее вывод
function soc_random_box(){
    global $soc_card_data, $post;

    $soc_data = soc_get_priceless_items();  // получим массив товаров

    if(!$soc_data) return soc_first_info(); // ничего нет

    $id_page = rcl_get_option('soc_id_all');
    $footer_link = '';
    if( !empty($id_page) && $post->ID != $id_page){ // страница размещения совпадает с текущей
        $footer_link = '<div class="soc_footer_link"><a title="Посмотреть все мои работы для плагина WP-Recall" href="/?p='.$id_page.'">Все дополнения<i class="fa fa-angle-right"></i></a></div>';
    }

    $out = '<div id="soc_box" class="soc_card_box">';
        foreach($soc_data as $soc_card_data){
            $out .= '<div class="soc_box_blk">';
                $out .= rcl_get_include_template('soc-card.php', __FILE__); // цепляем шаблон
            $out .= '</div>';
        }
        $out .= $footer_link;
    $out .= '</div>';

    return $out;
}


// шорткод рандомных
function soc_random_shortcode(){
    return soc_random_box();
}
add_shortcode('ofm_addons_random','soc_random_shortcode');





// удаленный запрос: раз в час - копирование на свой сервер
function soc_remote_get_addons_info(){
    $ids = explode(',',rcl_get_option('soc_id_addons'));

    $soc_dir_path = RCL_UPLOAD_PATH.'seller-xml/';
    if(!wp_mkdir_p($soc_dir_path)){ // если папки нет - создадим
        wp_mkdir_p($soc_dir_path);
    }

    foreach($ids as $k => $id_one){
        $id_one = trim($id_one);                                                            // очищаем от возможных пробелов
        $url = 'http://downloads.codeseller.ru/products-files/info/'.$id_one.'/info.xml';   // путь до удаленного файла
        $resp = wp_remote_get(                                                              // удаленный запрос с таймаутом в 5 сек
            $url,
            array('timeout' => 5,)
        );

        if( wp_remote_retrieve_response_code($resp) === 200 ){  // код ответа 200
            $body = wp_remote_retrieve_body( $resp );           // получаем файл
            $soc_path_file = $soc_dir_path.$id_one.'.xml';      // путь и имя файла
            file_put_contents($soc_path_file, $body);           // если нет файла - создаем. И/или открываем и пишем
        }
    }
}
add_action('rcl_cron_hourly','soc_remote_get_addons_info');

