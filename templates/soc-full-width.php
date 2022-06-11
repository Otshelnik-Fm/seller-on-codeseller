<?php
/*
  Шаблон дополнения Seller on Codeseller
  Версия шаблона: v2.0
  Шаблон для отображения содержимого шорткода [codeseller_product] с указанием атрибута template="full-width",
  Этот шаблон можно скопировать в папку реколл шаблонов по пути: ваш-сайт/wp-content/wp-recall/templates/
  - сделать нужные вам правки и изменения и он будет подключаться оттуда
  Работа с шаблонами описана тут: https://codeseller.ru/?p=11632
 */

/**
 * @var    $data array   Массив данных: товара и шорткода
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
          [outsale] => 0  // 1 - снят с распространения
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
              )
        )
    )
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

$prices   = ( ! is_object( $data[0]->price ) ) ? $data[0]->price : '0';
$out_sale = ( isset( $data[0]->outsale ) && 1 == $data[0]->outsale ) ? true : false;

$url   = soc_get_link( $data[0]->post_id, $data[1]['disable_ref'] );
$pict  = ( ! is_object( $data[0]->thumbnail ) ) ? $data[0]->thumbnail : '';
$name  = $data[0]->name;
$price = ( string ) $prices . ' р.';
if ( $data[0]->vip == 1 ) {
	$price .= '<span class="soc_vip"> (vip)</span>';
}
if ( $out_sale ) {
	$price = '<small>Снят с продажи</small>';
}
$description = $data[0]->description;
$version     = $data[0]->version;

// ниже сам шаблон для редактирования
?>

<div class="soc-blk-ava">
    <a class="soc-blk-ava-a no_marked_icon cwb_no_animate" rel="nofollow noopener noindex" title="Перейти в магазин и почитать описание" target="_blank" href="<?php echo $url; ?>">
		<?php if ( rcl_exist_addon( 'lazy-daisy' ) ) { ?>
            <img class="soc-blk-ava-img lzy_img" alt="Дополнение для WordPress плагина WP-Recall" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $pict . '?ver=' . $version . ''; ?>"
                 width="140" height="150">
		<?php } else { ?>
            <img class="soc-blk-ava-img" loading="lazy" alt="Дополнение для WordPress плагина WP-Recall" src="<?php echo $pict . '?ver=' . $version . ''; ?>" width="140" height="150">
		<?php } ?>
    </a>
</div>
<div class="soc_fw_right">
    <a class="soc-title no_marked_icon cwb_no_animate" rel="nofollow noopener noindex" target="_blank" title="Перейти в магазин и почитать описание" href="<?php echo $url; ?>">
		<?php echo $name; ?>
    </a>
    <div class="soc_fw_description"><?php echo $description; ?></div>
    <div class="soc_fw_price"><?php echo $price ?></div>
</div>
