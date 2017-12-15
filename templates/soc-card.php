<?php
/*
Шаблон для отображения содержимого шорткода [ofm_addons_random],
Данный шаблон можно разместить в папке используемого шаблона /wp-content/wp-recall/templates/ и он будет подключаться оттуда
Работа с шаблонами описана тут: https://codeseller.ru/post-group/ispolzuem-funkcional-shablonov-v-plagine-wp-recall-spisok-shablonov/
*/
?>
<?php

/*
данные внутри глобальной переменной: global $soc_card_data;
Структура данных:

Array(
    [0] => Array(
        [name] => Lock Cabinet From Guests
        [version] => 1.1
        [support-core] => 15.5.1
        [description] => Закрывает контент личного кабинета от посторонних глаз. Кабинет будет виден только пользователям вошедшим на сайт (залогиненым)
        [author] => Владимир Дружаев (Otshelnik-Fm)
        [author-uri] => https://codeseller.ru/author/otshelnik-fm/
        [add-on-uri] => https://codeseller.ru/products/lock-cabinet-from-guests/
        [update] => 2016-11-26 09:07:30
        [slug] => lock-cabinet-from-guests
        [thumbnail] => https://codeseller.ru/wp-content/uploads/2016/11/Lock-Cabinet-From-Guests-150x150.jpg
        [price] => 708
        [author_id] => 44
        [post_id] => 13737
        [downloads] => 13
        [active-installs] => 11
        [terms] => SimpleXMLElement Object(
            [product_tag] => SimpleXMLElement Object(
                [profil] => профиль
                [avtorizaciya] => авторизация
            )
        )
    )
...
*/

global $soc_card_data;

?>

<div class="soc_box_ava">
    <a rel="nofollow" target="_blank" href="https://codeseller.ru/?p=<?php echo $soc_card_data['post_id']; ?>">
        <img alt="Дополнение для WordPress плагина WP-Recall" src="<?php echo $soc_card_data['thumbnail']; ?>">
        <div class="soc_box_price">Цена: <?php echo $soc_card_data['price']; ?> р.</div>
    </a>
    <div class="soc_more">
        <div class="soc_box_description"><?php echo $soc_card_data['description']; ?></div>
        <div class="soc_box_version">Версия: v<?php echo $soc_card_data['version']; ?></div>
        <div class="soc_box_update">Обновление: <?php echo $soc_card_data['update']; ?></div>
        <div class="soc_box_support">Поддержка WP-Recall: v<?php echo $soc_card_data['support-core']; ?></div>
    </div>
</div>
<div class="soc_box_title">
    <a rel="nofollow" target="_blank" title="Перейти в магазин и почитать описание" href="https://codeseller.ru/?p=<?php echo $soc_card_data['post_id']; ?>">
        <?php echo $soc_card_data['name']; ?>
    </a>
</div>


