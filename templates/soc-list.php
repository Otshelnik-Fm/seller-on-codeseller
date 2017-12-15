<?php
/*
Шаблон для отображения содержимого шорткода [ofm_addons_info] с указанием атрибута template='list',
Данный шаблон можно разместить в папке используемого шаблона /wp-content/wp-recall/templates/ и он будет подключаться оттуда
Работа с шаблонами описана тут: https://codeseller.ru/post-group/ispolzuem-funkcional-shablonov-v-plagine-wp-recall-spisok-shablonov/
*/
?>
<?php

/*
Структура xml файла:

SimpleXMLElement Object (
    [name] => Across Ocean
    [version] => 3.0.1
    [support-core] => 15.1.16
    [template] => Across Ocean
    [description] => Шаблон личного кабинета от Otshelnik-Fm. Идеально подойдет для отображения на ПК и мобильных устройствах
    [author] => Otshelnik-Fm
    [author-uri] => https://codeseller.ru/author/otshelnik-fm/
    [update] => 2016-09-05 16:41:57
    [slug] => across-ocean
    [thumbnail] => https://codeseller.ru/wp-content/uploads/2015/09/across-ocean-theme-150x150.jpg
    [price] => 0
    [author_id] => 44
    [post_id] => 10067
    [downloads] => 411
    [active-installs] => 40
)
*/

global $soc_xml_data;

$soc_price = $soc_xml_data->price;
if($soc_price == 0){ // хз зачем... может потом классами (цветом) буду выделять платные и бесплатные товары
    $soc_prices = '0р';
} else {
    $soc_prices = $soc_price.'р';
}

$soc_downloads = (string)$soc_xml_data->downloads;  // приводим объект к строке
if(empty($soc_downloads)){                          // если загрузок 0 - пишем ноль
    $soc_downloads = 0;
}
?>

<div class="soc_ava">
    <a rel="nofollow" target="_blank" title="Перейти" href="https://codeseller.ru/?p=<?php echo $soc_xml_data->post_id; ?>">
        <img src="<?php echo $soc_xml_data->thumbnail; ?>" class="" alt="Дополнение для WordPress плагина WP-Recall">
    </a>
</div>

<div class="soc_content">
    <div class="soc_title">
        <div class="soc_product_name">
            <a rel="nofollow" target="_blank" title="Перейти к описанию дополнения" href="https://codeseller.ru/?p=<?php echo $soc_xml_data->post_id; ?>"><?php echo $soc_xml_data->name; ?></a>
            <span title="Обновление от <?php echo $soc_xml_data->update; ?>">v.<?php echo $soc_xml_data->version; ?></span>
        </div>
        <div class="product_price" title="Стоимость"><?php echo $soc_prices; ?></div>
    </div>

    <div class="soc_support">поддержка WP-Recall: v.<?php echo $soc_xml_data->{'support-core'}; ?></div>

    <div class="soc_content_bottom">
        <div class="soc_description" data-title="<?php echo esc_html($soc_xml_data->description); ?>">
            <?php echo $soc_xml_data->description; ?>
        </div>
        <div class="soc_bottom">
            <span title="Загрузок"><i class="fa fa-download"></i><?php echo $soc_downloads; ?></span>
            <span title="Активных установок"><i class="fa fa-calendar-check-o"></i><?php echo $soc_xml_data->{'active-installs'}; ?></span>
        </div>
    </div>
</div>
