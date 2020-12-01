<?php
/*
  Шаблон дополнения Seller on Codeseller
  Версия шаблона: v1.5
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
  [name] => User Info Tab
  [version] => 3.0.2
  [support-core] => 16.24.28
  [description] => Добавляет вкладку с информацией о пользователе и его статистикой. Отменяет всплывающий блок "Информация о пользователе"
  [author] => Владимир Дружаев (Otshelnik-Fm)
  [author-uri] => http://otshelnik-fm.ru/
  [add-on-uri] => https://codeseller.ru/?p=13876
  [update] => 2020-11-30 15:24:39
  [slug] => user-info-tab
  [thumbnail] => https://codeseller.ru/wp-content/uploads/2016/12/User-info-tab-150x150.jpg
  [price] => 1299
  [author_id] => 44
  [post_id] => 13876
  [downloads] => 94
  [rating] => stdClass Object(
  [votes] => 12
  [value] => 5
  )

  [partner] => 1
  [vip] => 0
  [active-installs] => 67
  [terms] => stdClass Object(
  [product_tag] => stdClass Object(
  [profil] => профиль
  [kontakty] => контакты
  [rasshirennyj-profil] => Расширенный профиль
  [polzovateli] => Пользователи
  [lichnyj-kabinet] => Личный кабинет
  )))

  [1] => Array(
  [type] => add-ons
  [slug] =>
  [template] => list
  [disable_ref] => 0
  [filter] => 1
  [author] => 44
  [sort] =>
  [premium] => 0
  [random] =>
  [number] => 150
  [limit] =>
  ))

 */

$prices = ( ! is_object( $data[0]->price )) ? $data[0]->price : '0';

$url     = soc_get_link( $data[0]->post_id, $data[1]['disable_ref'] );
$pict    = ( ! is_object( $data[0]->thumbnail )) ? $data[0]->thumbnail : '';
$name    = $data[0]->name;
$update  = $data[0]->update;
$version = $data[0]->version;
$price   = ( string ) $prices . ' р.';
if ( $data[0]->vip == 1 ) {
    $price .= '<span class="soc_vip"> (vip)</span>';
}
$support         = $data[0]->{'support-core'};
$description     = $data[0]->description;
$downloads       = ( string ) $data[0]->downloads;
$active_installs = $data[0]->{'active-installs'};
if ( empty( ( array ) $active_installs ) )
    $active_installs = 0;

$br = 'n/a';
if ( isset( $downloads ) && $downloads != 0 ) {
    $br = $active_installs / $downloads;
}
// ниже сам шаблон для редактирования
?>

<div class="soc_tl_ava">
    <a class="no_marked_icon cwb_no_animate" rel="nofollow noopener" target="_blank" title="Перейти" href="<?php echo $url; ?>">
        <?php if ( rcl_exist_addon( 'lazy-daisy' ) ) { ?>
            <img class="lzy_img" alt="Дополнение для WordPress плагина WP-Recall" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $pict . '?ver=' . $version . ''; ?>">
        <?php } else { ?>
            <img loading="lazy" alt="Дополнение для WordPress плагина WP-Recall" src="<?php echo $pict . '?ver=' . $version . ''; ?>">
        <?php } ?>
    </a>
</div>

<div class="soc_tl_content">
    <div class="soc_tl_title">
        <div class="soc_tl_product_name">
            <a class="no_marked_icon cwb_no_animate" rel="nofollow noopener" target="_blank" title="Перейти к описанию дополнения" href="<?php echo $url; ?>"><?php echo $name; ?></a>
            <span title="Обновление от <?php echo $update; ?>">v.<?php echo $version; ?></span>
        </div>
        <div class="product_tl_price" title="Стоимость"><?php echo $price; ?></div>
    </div>

    <div class="soc_tl_support">поддержка WP-Recall: v.<?php echo $support; ?></div>

    <div class="soc_tl_description" data-title="<?php echo esc_html( $description ); ?>">
        <?php echo $description; ?>
    </div>

    <div class="soc_tl_bottom">
        <span class="soc_tl_downloads" title="Количество скачиваний"><i class="rcli fa-download"></i><span><?php echo $downloads; ?></span></span>
        <span class="soc_tl_install" title="Активных установок"><i class="rcli fa-calendar-check-o"></i><span><?php echo $active_installs; ?></span></span>
        <span class="soc_tl_bounce" title="Показатель отказов (bounce rate)"><i class="rcli fa-bar-chart"></i><span><?php echo round( $br, 2 ); ?></span></span>
    </div>
</div>
