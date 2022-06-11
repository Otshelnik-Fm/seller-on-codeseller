<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SOC_Shortcode {

	public $attrs = [];         // белый список атрибутов
	private $cache_time = 3600; // время кеширования

	function __construct( $args ) {
		$attrs = shortcode_atts( [
			'type'         => 'add-ons',    // тип: add-ons, plugins, themes
			'slug'         => '',           // id допов
			'template'     => 'list',       // шаблон вывода
			'disable_ref'  => 0,            // выключить партнерскую ссылку
			'filter'       => 0,            // js-фильтр
			'author'       => '',           // вывод по id автора
			'sort'         => '',           // сортировка по: update, active-install, downloads, price
			'premium'      => 0,            // полезно для автора - получать все допы, но выводить только премиум (и для рандома)
			'random'       => '',           // рандомный вывод (полезно для премиум)
			'number'       => '',           // сколько запросить (полезно если по author берем)
			'limit'        => '',           // но показать только (полезно для premium)
			'hide_outsale' => 1,            // исключить те, которые сняты с распространения
		], $args, 'codeseller_product' );

		$this->attrs = $attrs;      // получаем атрибуты шорткода
		$this->load_resources();    // ресурсы (js,css)
	}

	private function load_resources() {
		soc_core_css();

		if ( $this->attrs['template'] == 'list' ) {
			soc_list_css();
		} else if ( $this->attrs['template'] == 'card' ) {
			soc_card_css();
		} else if ( $this->attrs['template'] == 'full-width' ) {
			soc_full_width_css();
		}

		// Нужен фильтр. Грузим скрипт и стиль для него
		if ( $this->attrs['filter'] == 1 ) {
			soc_filter_script();
			soc_filter_css();
		}
	}

	public function get_products() {
		$data = $this->get_data();

		$out = $this->get_template( $data );

		$is_live = '';
		if ( current_user_can( 'manage_options' ) && ! isset( $data->in_cache ) ) {
			$is_live = '<small>Показаны актуальные данные:</small>';
		}

		return $is_live . $out; // выведем контент
	}

	// получим массив данных и закешируем их
	private function get_data() {
		$rcl_cache = new Rcl_Cache( $this->cache_time );                    // время кеша
		$file      = $rcl_cache->get_file( json_encode( $this->attrs ) );   // получаем данные кеш-файла по указанному ключу

		if ( ! is_preview() && ! $file->need_update ) {                     // если кеш не просрочен
			$file_content = file_get_contents( $file->filepath );           // считаем из файла
			$result       = json_decode( $file_content );                   // декодируем
			$results      = ( object ) array_merge( ( array ) $result, [ 'in_cache' => '1' ] ); // добавим в конец, что это из кеша

			return $results;    // выведем содержимое кеш-файла
		} else {                // или "живые" данные
			return $this->get_remote_data( $rcl_cache );
		}
	}

	// удаленный запрос
	private function get_remote_data( $rcl_cache ) {
		$url           = $this->get_url();
		$response      = wp_remote_get( $url );
		$response_code = wp_remote_retrieve_response_code( $response );

		if ( 200 == $response_code ) {                 // все ок
			$data = wp_remote_retrieve_body( $response );

			if ( ! is_preview() ) {
				$rcl_cache->update_cache( $data );    // создаем или обновляем кеш-файл с сформированным контентом
			}

			return json_decode( $data );
		} else {                                      // что-то не так
			rcl_add_log( 'Seller on CodeSeller: ошибка запроса', [ $url, $response_code ] );

			$response_message = wp_remote_retrieve_response_message( $response );

			return new WP_Error( $response_code, $response_message );
		}
	}

	// сформируем урл до удаленного ресурса
	private function get_url() {
		/** @noinspection PhpUndefinedConstantInspection */
		$url = RCL_SERVICE_HOST . '/products-files/api/add-ons.php?rcl-addon-info=get-add-ons';

		// получаем по слагам
		if ( $this->attrs['slug'] ) {
			$slug = $this->attrs['slug'];

			// очистим пробелы после запятых
			if ( false !== strpos( $this->attrs['slug'], ', ' ) ) {
				$slug = str_replace( ', ', ',', $this->attrs['slug'] );
			}
			$url .= '&slug=' . $slug;
		}

		// по автору
		if ( $this->attrs['author'] ) {
			$url .= '&author_id=' . intval( $this->attrs['author'] );
		}

		// сортировка
		if ( $this->attrs['sort'] ) {
			$url .= '&sort=' . sanitize_title( $this->attrs['sort'] );
		}

		// предельное кол-во
		if ( $this->attrs['number'] ) {
			$url .= '&number=' . intval( $this->attrs['number'] );
		}

		return $url;
	}

	// проверим данные и подключим шаблон
	private function get_template( $data ) {
		if ( is_wp_error( $data ) ) {
			return 'Ошибка: ' . $data->get_error_message();
		} // если пришел объект WP_Error

		if ( $data->count == 0 || ! $data->addons ) {
			return 'Ничего не найдено';
		}

		// выведем контент
		return $this->include_template( $data );  // поступившие "живые" данные с контентом
	}

	// выбор шаблона
	private function include_template( $datas ) {
		$class_filter = '';
		$i            = 0;

		// нужен рандом - перемешаем
		if ( $this->attrs['random'] == 1 ) {
			shuffle( $datas->addons );
		}

		$out = '<div class="soc-main soc-main_' . $this->attrs['template'] . '">';

		if ( $this->attrs['filter'] == 1 ) {        // нужен фильтр
			$out          .= $this->js_filter();    // кнопки фильтра
			$class_filter = ' js_filter_ready';
		}

		$out .= '<div class="soc_wrapper' . $class_filter . '" style="opacity:0;">';
		foreach ( $datas->addons as $data ) {
			$price    = ( ! is_object( $data->price ) ) ? $data->price : '0';
			$vip      = ( isset( $data->vip ) ) ? $data->vip : 0;
			$outsale  = ( isset( $data->outsale ) ) ? $data->outsale : 0;
			$out_sale = ( isset( $data->outsale ) && 1 == $data->outsale ) ? 'soc_out_sale' : '';

			// не выводим не в продаже
			if ( $this->attrs['hide_outsale'] == 1 && $outsale == 1 ) {
				continue;
			}

			// нужен премиум
			if ( $this->attrs['premium'] == 1 && $price == 0 ) {
				continue;
			}

			$i ++;

			$active_installs = $data->{'active-installs'};
			if ( empty( ( array ) $active_installs ) ) {
				$active_installs = 0;
			}

			$br = 'n/a';
			if ( isset( $data->downloads ) && $data->downloads != 0 ) {
				$br = $active_installs / $data->downloads;
			}

			$out .= '<div class="soc_blk ' . $out_sale . '" data-num="' . $i . '" '
			        . 'data-price="' . $price . '" '
			        . 'data-vip="' . $vip . '" '
			        . 'data-popular="' . $data->downloads . '" '
			        . 'data-install="' . $active_installs . '" '
			        . 'data-bouncer="' . round( $br, 2 ) . '" '
			        . 'data-name="' . $data->name . '">';
			$out .= rcl_get_include_template( 'soc-' . esc_html( $this->attrs['template'] ) . '.php', __FILE__, [ $data, $this->attrs ] ); // цепляем шаблон
			$out .= '</div>';

			if ( isset( $this->attrs['limit'] ) && $this->attrs['limit'] == $i ) {
				break;
			}
		}
		$out .= '</div>';   /* END soc_wrapper */

		$out .= '</div>';   /* END soc-main */

		return $out;
	}

	// кнопки фильтра
	private function js_filter() {
		$out = '<div class="soc_sort_wrapper" style="opacity:0;">';
		$out .= '<div class="soc_line soc_first_line">';
		$out .= '<span class="soc_sort_text">Сортировка по цене:</span>';
		$out .= '<div class="soc_sort">';
		$out .= '<i class="rcli fa-sort-amount-desc soc_button" title="От большего к меньшему"></i><i class="rcli fa-sort-amount-asc soc_button" title="От меньшего к большему"></i>';
		$out .= '</div>';
		$out .= '<div class="soc_premium soc_button" title="Платные дополнения"><i class="rcli fa-usd"></i><span>Премиум</span></div>';
		$out .= '<div class="soc_vip_bttn soc_button" title="Vip дополнения"><i class="rcli fa-diamond"></i><span>Vip</span></div>';
		$out .= '<div class="soc_reset soc_button" title="Отобразит дополнения по времени обновления"><i class="rcli fa-refresh"></i><span>Сброс</span></div>';
		$out .= '</div>';

		$out .= '<div class="soc_line soc_second_line">';
		$out .= '<div class="soc_popular soc_button" title="Сортировка: самые скачиваемые"><i class="rcli fa-download"></i><span>По скачиванию</span></div>';
		$out .= '<div class="soc_install soc_button" title="Сортировка: больше всего активных установок"><i class="rcli fa-calendar-check-o"></i><span>По установкам</span></div>';
		$out .= '<div class="soc_br soc_button" title="Сортировка по показателю отказов (bounce rate)"><i class="rcli fa-bar-chart"></i><span>По отказам</span></div>';
		$out .= '<div class="soc_alphabet soc_button" title="Сортировка по алфавиту"><i class="rcli fa-sort-alpha-asc"></i><span>По алфавиту</span></div>';
		$out .= '</div>';
		$out .= '</div>'; /* END soc_sort_wrapper */

		return $out;
	}

}
