<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_filter( 'admin_options_wprecall', 'soc_get_setting' );
function soc_get_setting( $content ) {
	$opt = new Rcl_Options( __FILE__ );

	$content .= $opt->options( 'Настройки Seller on Codeseller', [
			$opt->options_box( '&nbsp;&nbsp;&nbsp;Основные&nbsp;настройки&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
				[
					[
						'type'   => 'number',
						'title'  => 'Впишите ID партнера:',
						'slug'   => 'soc_prtnr_id',
						'notice' => 'На основе этого id будет формироваться партнерская ссылка',
						'help'   => 'Смотри инструкцию по настройке на странице описания товара, вкладка "Настройки"',
					],
					[
						'type'       => 'runner',
						'slug'       => 'soc_round',
						'title'      => 'Скругление карточек (в пикселях)',
						'value_step' => '1',
						'value_max'  => '20',
						'value_min'  => '0',
						'default'    => '2',
					],
				]
			),
		]
	);

	return $content;
}
