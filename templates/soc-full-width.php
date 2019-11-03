<?php
/*
  Шаблон дополнения Seller on Codeseller
  Версия шаблона: v1.4
  Шаблон для отображения содержимого шорткода [codeseller_product] с указанием атрибута template="full-width",
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

$prices = ( ! is_object( $data[0]->price )) ? $data[0]->price : '0';

$url         = soc_get_link( $data[0]->post_id, $data[1]['disable_ref'] );
$pict        = ( ! is_object( $data[0]->thumbnail )) ? $data[0]->thumbnail : '';
$name        = $data[0]->name;
$price       = ( string ) $prices . ' р.';
$description = $data[0]->description;
$version     = $data[0]->version;

// ниже сам шаблон для редактирования
?>

<div class="soc_fw_left">
    <a class="soc_fw_ava no_marked_icon cwb_no_animate" rel="nofollow noopener" title="Перейти в магазин и почитать описание" target="_blank" href="<?php echo $url; ?>">
        <?php if ( rcl_exist_addon( 'lazy-daisy' ) ) { ?>
            <img class="lzy_img" alt="Дополнение для WordPress плагина WP-Recall" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $pict . '?ver=' . $version . ''; ?>">
        <?php } else { ?>
            <img loading="lazy" alt="Дополнение для WordPress плагина WP-Recall" src="<?php echo $pict . '?ver=' . $version . ''; ?>">
        <?php } ?>
    </a>
</div>
<div class="soc_fw_right">
    <a class="soc_fw_title no_marked_icon cwb_no_animate" rel="nofollow noopener" target="_blank" title="Перейти в магазин и почитать описание" href="<?php echo $url; ?>">
        <?php echo $name; ?>
    </a>
    <div class="soc_fw_description"><?php echo $description; ?></div>
    <div class="soc_fw_price">Цена: <?php echo $price ?></div>
</div>
