<?php

function soc_get_setting($options){
    $opt = new Rcl_Options(__FILE__);
    $options .= $opt->options(
        'Настройки Seller on Codeseller',
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
        )
    );
    return $options;
}
add_filter('admin_options_wprecall','soc_get_setting');