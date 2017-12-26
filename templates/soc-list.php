<?php
/*
Шаблон дополнения Seller on Codeseller
Шаблон для отображения содержимого шорткода [codeseller_product] с указанием атрибута template="list",
Этот шаблон можно скопировать в папку реколл шаблонов по пути: ваш-сайт/wp-content/wp-recall/templates/
- сделать нужные вам правки и изменения и он будет подключаться оттуда
Работа с шаблонами описана тут: https://codeseller.ru/?p=11632
*/
?>
<?php

/*
Структура $data:

Array(
    [0] => stdClass Object(
            [name] => AutoBot Cabinet
            [version] => 1.0
            [support-core] => 16.9.0
            [description] => Если это кабинет автобота - то в нем только вкладка Сообщения сайта. Автобот - автоматический помощник сайта
            [author] => Владимир Дружаев (Otshelnik-Fm)
            [author-uri] => https://otshelnik-fm.ru/
            [add-on-uri] => https://codeseller.ru/?p=16887
            [update] => 2017-12-22 15:46:23
            [slug] => autobot-cabinet
            [thumbnail] => https://codeseller.ru/wp-content/uploads/2017/12/AutoBot-Cabinet-150x150.jpg
            [price] => 0
            [author_id] => 44
            [post_id] => 16887
            [downloads] => 11
            [active-installs] => 8
            [terms] => stdClass Object(
                    [product_tag] => stdClass Object(
                            [uvedomleniya] => уведомления
                            [lichnye-soobshheniya] => личные сообщения
                        )
                )
        )
    [1] => Array(
            [type] => add-ons
            [slug] =>
            [template] => list
            [disable_ref] => 0
            [filter] => 0
            [author] => 44
            [sort] =>
            [premium] => 0
            [random] =>
            [number] => 100
        )
)

*/

$url = soc_get_link($data[0]->post_id, $data[1]['disable_ref']);
$pict = $data[0]->thumbnail;
$name = $data[0]->name;
$update = $data[0]->update;
$version = $data[0]->version;
$price = $data[0]->price.'р';
$support = $data[0]->{'support-core'};
$description = $data[0]->description;
$downloads = (string)$data[0]->downloads;
$active_installs = $data[0]->{'active-installs'};

// ниже сам шаблон для редактирования
?>

<div class="soc_tl_ava">
    <a rel="nofollow" target="_blank" title="Перейти" href="<?php echo $url; ?>">
        <img src="<?php echo $pict; ?>" alt="Дополнение для WordPress плагина WP-Recall">
    </a>
</div>

<div class="soc_tl_content">
    <div class="soc_tl_title">
        <div class="soc_tl_product_name">
            <a rel="nofollow" target="_blank" title="Перейти к описанию дополнения" href="<?php echo $url; ?>"><?php echo $name; ?></a>
            <span title="Обновление от <?php echo $update; ?>">v.<?php echo $version; ?></span>
        </div>
        <div class="product_tl_price" title="Стоимость"><?php echo $price; ?></div>
    </div>

    <div class="soc_tl_support">поддержка WP-Recall: v.<?php echo $support; ?></div>

    <div class="soc_tl_content_bottom">
        <div class="soc_tl_description" data-title="<?php echo esc_html($description); ?>">
            <?php echo $description; ?>
        </div>
        <div class="soc_tl_bottom">
            <span title="Загрузок"><i class="fa fa-download"></i><?php echo $downloads; ?></span>
            <span title="Активных установок"><i class="fa fa-calendar-check-o"></i><?php echo $active_installs; ?></span>
        </div>
    </div>
</div>
