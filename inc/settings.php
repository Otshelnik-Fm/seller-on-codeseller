<?php

if (!defined('ABSPATH')) exit; // запрет прямого доступа к файлу


function soc_get_setting($content){

    $opt = new Rcl_Options(__FILE__);

    $content .= $opt->options('Настройки Seller on Codeseller', array(
            $opt->options_box('&nbsp;&nbsp;&nbsp;Основные&nbsp;настройки&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                array(
                    array(
                        'type' => 'number',
                        'title'=>'Впишите ID партнера:',
                        'slug'=>'soc_prtnr_id',
                        'notice'=> 'На основе этого id будет формироваться партнерская ссылка',
                        'help'=> 'Смотри инструкцию по настройке на странице описания товара, вкладка "Настройки"'
                    )
                )
            ),
        )
    );

    return $content;
}
add_filter('admin_options_wprecall','soc_get_setting');
