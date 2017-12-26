<?php

if (!defined('ABSPATH')) exit; // запрет прямого доступа к файлу



function soc_general_short($atts){
    $attrs = shortcode_atts(array(
                'type'=>'add-ons',      // тип: add-ons, plugins, themes
                'slug'=>'',             // id допов
                'template' => 'list',   // шаблон вывода
                'disable_ref'=>0,       // выключить партнерскую ссылку
                'filter'=>0,            // js-фильтр
                'author'=>'',           // вывод по id автора
                'sort'=>'',             // сортировка по: update, active-install, downloads, price
                'premium'=>0,           // полезно для автора - получать все допы, но выводить только премиум (и для рандома)
                'random'=>'',           // рандомный вывод (полезно для премиум)
                'number'=>'',           // сколько запросить (полезно если по author берем)
                'limit'=>'',            // но показать только (полезно для premium)

             ), $atts, 'codeseller_product');

    soc_loader($attrs);


    $url = soc_get_url($attrs);


    $result = soc_get_remote_data($url, $attrs);

    $out = soc_get_template($result,$attrs);


    $is_live = '';
    if( current_user_can('manage_options') && !isset($result->in_cache) ){
        $is_live = '<small>Показаны актуальные данные:</small>';
    }

    return $is_live.$out;                          // выведем контент
}
add_shortcode('codeseller_product','soc_general_short');


function soc_loader($attrs){
    if($attrs['template'] == 'list'){
        soc_list_css();
    } else if ($attrs['template'] == 'card'){
        soc_card_css();
    } else if ($attrs['template'] == 'full-width'){
        soc_full_width_css();
    }


    if($attrs['filter'] == 1){ // нужен фильтр. Грузим скрипт и стиль для него
        soc_filter_script();
        soc_filter_css();
    }

}


// сформируем урл
function soc_get_url($attrs){
    $url = RCL_SERVICE_HOST.'/products-files/api/add-ons.php?rcl-addon-info=get-add-ons';

    // получаем по слагам
    if($attrs['slug']){
        $slug = $attrs['slug'];
        if( false !== strpos($attrs['slug'], ', ') ){       // очистим пробелы после запятых
            $slug = str_replace(', ', ',', $attrs['slug']);
        }
        $url .= '&slug='.$slug;
    }

    // по автору
    if($attrs['author']){
        $url .= '&author_id='.intval($attrs['author']);
    }

    // сортировка
    if($attrs['sort']){
        $url .= '&sort='.sanitize_title($attrs['sort']);
    }

    // предельное кол-во
    if($attrs['number']){
        $url .= '&number='.intval($attrs['number']);
    }

    return $url;
}


// удаленный запрос
function soc_get_remote_data($url, $attrs){
    $rcl_cache = new Rcl_Cache(3600); // время кеша
    $file = $rcl_cache->get_file(json_encode($attrs));      // получаем данные кеш-файла по указанному ключу

    if(!is_preview() && !$file->need_update){               // если кеш не просрочен
        $file_content = file_get_contents($file->filepath); // считаем из файла
        $result = json_decode($file_content);               // декодируем
        $results = (object) array_merge((array)$result, array('in_cache'=>'1')); // добавим в конец что это из кеша

        return $results;           // выведем содержимое кеш-файла
    } else {
        $response = wp_remote_get($url);
        $response_code = wp_remote_retrieve_response_code($response);

        if (200 == $response_code){                                         // все ок
            $out = wp_remote_retrieve_body( $response );

            if( !is_preview() ){
                $rcl_cache->update_cache($out);     // создаем или обновляем кеш-файл с сформированным контентом
            }

            $result = json_decode($out);
            return $result;
        } else {                                                            // что-то не так
            rcl_add_log('Seller on CodeSeller: ошибка запроса', array($url, $response_code) );

            $response_message = wp_remote_retrieve_response_message( $response );
            return new WP_Error( $response_code, $response_message );
        }
    }
}

// подключим
function soc_get_template($result,$attrs){
    if ( is_wp_error($result) ) return 'Ошибка: '.$result->get_error_message();   // если пришел объект WP_Error

    if($result->count == 0 || !$result->addons) return 'Ничего не найдено';

    $content = soc_get($result,$attrs); // поступившие "живые" данные с контентом

    return $content;                          // выведем контент
}

function soc_get($result,$attrs){
    $class_filter = '';
    $i = 0;
    $out = '<div id="soc_box" class="soc_addon_wrapper soc_'.$attrs['template'].'">';

    if($attrs['filter'] == 1){ // нужен фильтр
        $out .= soc_filter_button(); // кнопки фильтра
        $class_filter = 'js_filter_ready';
    }

    if($attrs['random'] == 1){
        shuffle($result->addons);
    }

        $out .= '<div class="soc_wrapper '.$class_filter.'">';
            foreach ($result->addons as $data){
                if($attrs['premium'] == 1 && $data->price == 0) continue; // выводим премиум
                $i++;

                $out .= '<div class="soc_blk" data-num="'.$i.'" data-price="'.$data->price.'" data-popular="'.$data->downloads.'" data-name="'.$data->name.'">';
                    $out .= rcl_get_include_template('soc-'.esc_html($attrs['template']).'.php', __FILE__, array($data, $attrs) ); // цепляем шаблон
                $out .= '</div>';

                if( isset($attrs['limit']) && $attrs['limit'] == $i) break;
            }
        $out .= '</div>'; /* END soc_wrapper */

    $out .= '</div>'; /* END soc_addon_wrapper */

    return $out;
}


// кнопки фильтра
function soc_filter_button(){
    $out = '<div class="soc_sort_wrapper" style="opacity:0;">';
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






