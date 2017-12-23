<?php

function soc_get_setting($options){
    $opt = new Rcl_Options(__FILE__);
    $options .= $opt->options(
        'Настройки Seller on Codeseller', array(
            $opt->option_block(
                array(
                    $opt->title('Настройки ваших товаров:'),

                    $opt->label('ID ваших дополнений к WP-Recall:'),
                    $opt->option('textarea',array(
                        'name'=>'soc_id_addons',
                        )),
                    //$opt->help(''),
                    $opt->notice('Через запятую<br/><br/>'),

                    $opt->label('ID ваших плагинов к WordPress:'),
                    $opt->option('textarea',array(
                        'name'=>'soc_id_plugins',
                        )),
                    $opt->notice('Через запятую<br/><br/>'),

                    $opt->label('ID ваших шаблонов к WordPress:'),
                    $opt->option('textarea',array(
                        'name'=>'soc_id_themes',
                        )),
                    $opt->notice('Через запятую'),
                )
            ),
            $opt->option_block(
                array(
                    $opt->title('Настройки ресурсов (js,css):'),

                    $opt->label('Страница с шорткодом [ofm_addons_info]:'),
                    $opt->option('number',array(
                        'name'=>'soc_id_all',
                        )),
                    $opt->help('Данная опция - для указания id страницы на которой размещен шорткод [ofm_addons_info].'
                            . '<br/><br/>Если вы оставите пустым - то css-стиль и js-скрипт будут загружаться на всем сайте,'
                            . ' если укажете id страницы с размешенным шорткодом - то стиль и скрипт будут грузиться только на ней - что позволит их впустую не загружать там, где это не требуется'),
                    $opt->notice('Число, id страницы'),



                    $opt->label('Страница с шорткодом [ofm_addons_random]:'),
                    $opt->option('number',array(
                        'name'=>'soc_id_rand',
                        )),
                    $opt->help('Данная опция - для указания id страницы на которой размещен шорткод [ofm_addons_random].'
                            . '<br/><br/>Если вы оставите пустым - то css-стиль будет загружаться на всем сайте,'
                            . ' если укажете id страницы с размешенным шорткодом - то стиль будет грузиться только на ней - что позволит его впустую не загружать там, где это не требуется'),
                    $opt->notice('Число, id страницы'),
                )
            )
        )
    );
    return $options;
}
add_filter('admin_options_wprecall','soc_get_setting');