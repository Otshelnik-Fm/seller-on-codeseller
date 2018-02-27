<?php

if (!defined('ABSPATH')) exit; // запрет прямого доступа к файлу


class SOC_Shortcode {
    public $attrs = array();    // белый список атрибутов
    private $cache_time = 3600; // время кеширования

    function __construct($args){
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
                 ), $args, 'codeseller_product');

        $this->attrs = $attrs;      // получаем атрибуты шорткода
        $this->load_resources();    // ресурсы (js,css)
    }


    public function get_products(){
        $data = $this->get_data();

        $out = $this->get_template($data);

        $is_live = '';
        if( current_user_can('manage_options') && !isset($data->in_cache) ){
            $is_live = '<small>Показаны актуальные данные:</small>';
        }

        return $is_live.$out;                          // выведем контент
    }


    private function load_resources(){
        if($this->attrs['template'] == 'list'){
            soc_list_css();
        } else if ($this->attrs['template'] == 'card'){
            soc_card_css();
        } else if ($this->attrs['template'] == 'full-width'){
            soc_full_width_css();
        }

        if($this->attrs['filter'] == 1){ // нужен фильтр. Грузим скрипт и стиль для него
            soc_filter_script();
            soc_filter_css();
        }
    }


    // получим массив данных и закешируем их
    private function get_data(){
        $rcl_cache = new Rcl_Cache($this->cache_time); // время кеша
        $file = $rcl_cache->get_file(json_encode($this->attrs));    // получаем данные кеш-файла по указанному ключу

        if(!is_preview() && !$file->need_update){               // если кеш не просрочен
            $file_content = file_get_contents($file->filepath); // считаем из файла
            $result = json_decode($file_content);               // декодируем
            $results = (object) array_merge((array)$result, array('in_cache'=>'1')); // добавим в конец что это из кеша

            return $results;    // выведем содержимое кеш-файла
        } else {                // или "живые" данные
            return $this->get_remote_data($rcl_cache);
        }
    }

    // удаленный запрос
    private function get_remote_data($rcl_cache){
        $url = $this->get_url();
        $response = wp_remote_get($url);
        $response_code = wp_remote_retrieve_response_code($response);

        if (200 == $response_code){                 // все ок
            $data = wp_remote_retrieve_body($response);

            if( !is_preview() ){
                $rcl_cache->update_cache($data);    // создаем или обновляем кеш-файл с сформированным контентом
            }

            return json_decode($data);
        }
        else {                                      // что-то не так
            rcl_add_log( 'Seller on CodeSeller: ошибка запроса', array($url, $response_code) );

            $response_message = wp_remote_retrieve_response_message($response);
            return new WP_Error( $response_code, $response_message );
        }
    }


    // сформируем урл до удаленного ресурса
    private function get_url(){
        $url = RCL_SERVICE_HOST.'/products-files/api/add-ons.php?rcl-addon-info=get-add-ons';

        // получаем по слагам
        if($this->attrs['slug']){
            $slug = $this->attrs['slug'];
            if( false !== strpos($this->attrs['slug'], ', ') ){       // очистим пробелы после запятых
                $slug = str_replace(', ', ',', $this->attrs['slug']);
            }
            $url .= '&slug='.$slug;
        }

        // по автору
        if($this->attrs['author']){
            $url .= '&author_id='.intval($this->attrs['author']);
        }

        // сортировка
        if($this->attrs['sort']){
            $url .= '&sort='.sanitize_title($this->attrs['sort']);
        }

        // предельное кол-во
        if($this->attrs['number']){
            $url .= '&number='.intval($this->attrs['number']);
        }

        return $url;
    }


    // проверим данные и подключим шаблон
    private function get_template($data){
        if( is_wp_error($data) ) return 'Ошибка: '.$data->get_error_message(); // если пришел объект WP_Error

        if($data->count == 0 || !$data->addons) return 'Ничего не найдено';

        $content = $this->include_template($data);  // поступившие "живые" данные с контентом

        return $content;                            // выведем контент
    }


    // выбор шаблона
    private function include_template($datas){
        $class_filter = '';
        $i = 0;

        if($this->attrs['random'] == 1){ // нужен рандом - перемешаем
            shuffle($datas->addons);
        }

        $out = '<div id="soc_box" class="soc_addon_wrapper soc_'.$this->attrs['template'].'">';

            if($this->attrs['filter'] == 1){    // нужен фильтр
                $out .= $this->js_filter();     // кнопки фильтра
                $class_filter = 'js_filter_ready';
            }

            $d_style = '';
            if($this->attrs['template'] != 'card'){
                $d_style = 'style="opacity:0;"';
            }

            $out .= '<div class="soc_wrapper '.$class_filter.'" '.$d_style.'>';
                foreach ($datas->addons as $data){
                    if($this->attrs['premium'] == 1 && $data->price == 0) continue; // нужен премиум
                    $i++;

                    $out .= '<div class="soc_blk" data-num="'.$i.'" data-price="'.$data->price.'" data-popular="'.$data->downloads.'" data-name="'.$data->name.'">';
                        $out .= rcl_get_include_template('soc-'.esc_html($this->attrs['template']).'.php', __FILE__, array($data, $this->attrs) ); // цепляем шаблон
                    $out .= '</div>';

                    if( isset($this->attrs['limit']) && $this->attrs['limit'] == $i) break;
                }
            $out .= '</div>';   /* END soc_wrapper */

        $out .= '</div>';       /* END soc_addon_wrapper */

        return $out;
    }


    // кнопки фильтра
    private function js_filter(){
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

}
