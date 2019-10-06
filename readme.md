## Описание:  

Дополнение для WordPress плагина [WP-Recall](https://wordpress.org/plugins/wp-recall/)  

- С помощью этого дополнения автор товаров, ведущий свои продажи через сервис CodeSeller.ru, сможет вывести актуальную информацию и статистику о своих товарах, на своем сайте или блоге.  
- А любой желающий, с помощью этого дополнения, сможет вывести карточку товара (дополнения к WP-Recall) с сервиса CodeSeller.ru для работы по [партнерской программе](https://codeseller.ru/reklamiruj-codeseller-ru-stanovis-partnerom/)  

------------------------------

## Demo:  

[слева](https://otshelnik-fm.ru/?utm_source=free-addons&utm_medium=addon-description&utm_campaign=seller-on-codeseller&utm_content=github-com&utm_term=home-page) - 4-ре рандомных премиум товара выводятся карточкой  

[Список всех моих дополнений](https://otshelnik-fm.ru/?p=2562&utm_source=free-addons&utm_medium=addon-description&utm_campaign=seller-on-codeseller&utm_content=github-com&utm_term=all-my-addons) с фильтром  

------------------------------

## Возможности вывода:  
- Возможность указать свою партнерскую ссылку (на основе partner id)  
- Возможность отключения партнерской ссылки (например если вы выводите свои допы)  
- Множество настроек доступно через атрибуты шорткода  
- Три шаблона вывода карточки товара (list, full-width и card)  
- Получение товара или списка товаров по автору или по slug товара  
- Вкл/выкл js фильтра вверху списка  
- Показ только премиум дополнений (не нулевая цена у товара)  
- Рандомный вывод одного или нескольких товаров  

------------------------------

### В зависимости от выбранного из 3-х шаблонов выводится:  
- Вывод информации о товаре  
- Вывод текущей версии  
- Вывод совместимости с WP-Recall  
- Вывод миниатюры товара  
- Количество скачиваний  
- Количество активных установок  
- Цена  
- Дата последнего обновления  
- Сортировка и фильтр товаров  

------------------------------

## Возможности сортировки и фильтра:  
- Сортировка по цене (увеличение/уменьшение)  
- Вывод премиум товаров (только платные)  
- Вывод популярных товаров  
- Сортировка по алфавиту (а-я)  

------------------------------

## Установка/Обновление  

**Установка:**  
Т.к. это дополнение для WordPress плагина WP-Recall, то оно устанавливается через [менеджер дополнений WP-Recall](https://codeseller.ru/obshhie-svedeniya-o-dopolneniyax-wp-recall/)  

1. В админке вашего сайта перейдите на страницу "WP-Recall" -> "Дополнения" и в самом верху нажмите на кнопку "Обзор", выберите .zip архив дополнения на вашем пк и нажмите кнопку "Установить".  
2. В списке загруженных дополнений, на этой странице, найдите это дополнение, наведите на него курсор мыши и нажмите кнопку "Активировать". Или выберите чекбокс и в выпадающем списке действия выберите "Активировать". Нажмите применить.  


**Обновление:**  
Дополнение поддерживает [автоматическое обновление](https://codeseller.ru/avtomaticheskie-obnovleniya-dopolnenij-plagina-wp-recall/) - два раза в день отправляются вашим сервером запросы на обновление.  
Если в течении суток вы не видите обновления (а на странице дополнения вы видите что версия вышла новая), советую ознакомиться с этой [статьёй](https://codeseller.ru/post-group/rabota-wordpress-krona-cron-prinuditelnoe-vypolnenie-kron-zadach-dlya-wp-recall/) 

------------------------------

## Настройки  

### Настройки партнерской ссылки:  
В админке одна настройка: "WP-Recall" -> "Настройки" -> "Настройки Seller on CodeSeller" -> "Впишите ID партнера"  
Позволяет вписать свою партнерскую ссылку и получать % с продаж по вашей реф ссылке. [Подробней](https://codeseller.ru/reklamiruj-codeseller-ru-stanovis-partnerom/)  
Вписывать туда число: ваш id зарегистрированного юзера с сервиса CodeSeller.  

**Как получить id?**  

1. Заходим на кодеселлер (обязательно залогиненным)  
2. Выбираем товар, что участвует в партнерской программе и переходим на его страницу  
3. Слева вверху нажимаем "Получить партнерскую ссылку"  
4. Копируем первое число (второе id товара. Его вписывать не нужно)  
[Скриншот](https://yadi.sk/i/eQeYmd1w3QyiT7)  


### Использование шорткода:  

В нужном месте впишите шорткод (это может быть текст записи - например после обзора - для того чтобы расположить партнерский блок  
Или его можно вписать в виджет "Текст" и расположить в сайдбаре вашего сайта)  

`[codeseller_product]` - шорткод для вывода товаров (если вписать только этот шорткод - мы получим 21 товар, отсортированный по обновлению)  

#### Дополнительные атрибуты шорткода:  
Шорткод может принимать атрибуты:  
**slug** - вписывайте, через запятую, слаги (slug) товара (название папки дополнения. Например у дополнения Hello Private Message слаг: hello-private-message)  
**template** - (по умолчанию list) используемый для вывода шаблон. Доступны так же full-width и card  
**disable_ref** - (по умолчанию 0) ставьте 1, чтобы отключить партнерскую ссылку (полезно для авторов дополнений)  
**filter** - (по умолчанию 0) - ставьте 1, чтобы включить над товарами кнопки js-фильтра  
**author** - id автора дополнений (полезно для авторов дополнений)  
**sort** - начальная сортировка списка. Доступные значения update, active-install, downloads, price. По умолчанию сервис отдает по времени обновления допа  
**premium** - ставьте 1, чтобы выбирать товары только с ценой (премиум дополнения)  
**random** - ставьте 1, чтобы выводить дополнения в случайном порядке  
**number** - предельное количество дополнений в удаленном запросе (по умолчанию сервис отдает 21)  
**limit** - но выводить на экран только это значение (полезно для random)  

#### Примеры:  
1. допустим мы делаем обзор фриланс биржи и в конце записи хотим разместить блок с актуальной ценой на нее и чтобы была включена партнерская ссылка для заработка по партнерской программе.  
Шорткод для этого такой:
`[codeseller_product template="full-width" slug="freelance-nextgen"]`  
- Внимание! Если вы затрудняетесь какой slug вписать для товара - вы всегда можете задать этот вопрос автору дополнения в комментариях или ЛС  

2. Вывести пару случайных дополнений в сайдбаре.  
Для этого впишем к примеру 5 slug, поставим в атрибуте рандом, но для вывода поставим 2:  
`[codeseller_product template="card" slug="freelance-nextgen,user-info-tab,partners-system,users-market,invest-system" random="1" limit="2"]`  
- мы запросили нужные нам 5 товаров и ротируем их в случайном порядке выводя по 2  

3. Вывести все товары автора и вверху показать js-фильтр  
На примере моего аккаунта:  
`[codeseller_product author="44" filter="1"]`  
- но сервис кодеселлер по умолчанию отдаст нам только 21 товар. И в этом списке он выведет по умолчанию допы по времени обновления  
Снимем это ограничение, и выведем все мои дополнения отсортированные по цене:  
`[codeseller_product author="44" filter="1" number="100" sort="price"]`  

4. Если вы автор дополнения - выводить реф ссылку на самого себя нет смысла. Выведем свои товары отключив реф ссылку  
`[codeseller_product author="44" filter="1" number="100" disable_ref="1"]`  

5. Вывести все свои премиум дополнения в случайном порядке, отобразив 4-ре  
`[codeseller_product author="44" template="card" number="100" disable_ref="1" premium="1" random="1" limit="4"]`  

Таким образом мы можем получить нужный нам набор дополнений. Причем как для своего портфолио (свои дополнения), так и для продвижения по партнерской программе.  


------------------------------


## FAQ:  
#### Принцип работы:  

1. Есть настройка в админке - где вписывается ID партнера для формирования партнерской ссылки (можно отключить - смотри в пункте "Настройки" доступные атрибуты шорткода)  
2. Вписываете шорткод с атрибутами и можно сразу начинать работать  

Дополнение, на основе сформированного шорткода, раз в час обращается к api сервиса codeseller. И кеширует полученные данные с удаленного сервера на час.  
Админ может увидеть надпись (видна только ему) "Показаны актуальные данные" - это значит что данные только что пришли из сервиса кодеселлер  
Эта же надпись показывается если вы используете предпросмотр записи из админки - пока вы настраиваете шорткод смысла кешировать данные нет.  

Благодаря такому кешированию все происходит очень быстро - это не замедляет вашу страницу.  

#### Разное:  
Это дополнение использует шаблоны - вы с легкостью можете этим воспользоваться - кастомизировав под себя. Читайте [тут](https://codeseller.ru/post-group/ispolzuem-funkcional-shablonov-v-plagine-wp-recall-spisok-shablonov/) как с ними работать.  


------------------------------


## ToDo:  
#### Приоритет:  

- ~~Переработать настройки, позволить выводить по автору или по слагу~~ - с версии v2.0  
- ~~Возможность вписать партнерскую ссылку и в шорткоде ее отключать (по умолчанию включена будет) - позволит этому допу работать по партнерской программе~~ - с версии v2.0  
- ~~Новый шаблон для вывода в одиночной записи - во всю ширину~~ - с версии v2.0  

#### Второстепенно:  
- Сейчас выводятся только дополнения к WP-Recall, в следующих версиях будет вывод вордпресс шаблонов и плагинов (api codeseller пока это не поддерживает)  
- Вывод сводной статистики: Кол-во аддонов, плагинов и шаблонов (вкл/выкл)  
- ~~Отключение фильтра и сортировки (у кого товаров мало - смысла в нем нет)~~ - с версии v2.0  
- Кеширование миниатюр изображений товаров - частично реализовано с версии 2.3 (кеш на клиенте)  
- ~~Еще один шаблон вывода (возможность его выбора в атрибуте шорткода)~~ - с версии v2.0  

------------------------------

## Changelog:  
**2019-10-06**  
v2.5  
* Исправлена ошибка в шаблонах, когда у товара вдруг нет прикрепленного изображения (обложки)  
затронуты все шаблоны в папке templates - если вы их переносили и правили под себя - актуализируйте под себя  



**2019-05-18**  
v2.4  
* Исправлена ошибка когда товар снят с продажи  
* В шаблоне list рядом с ценой идет (vip) - если это дополнение закрыто Vip доступом  


**2018-10-11**  
v2.3  
* работа над доступностью (accessibility)  
* id блока убрал т.к. на странице может быть множество блоков (вызовов шорткодов)  
* добавил атрибут rel="noopener" внешним ссылкам (безопасность)  
* полностью перешел на реколл анимацию  
* минимизированы скрипт и стили  
* добавил к обложкам товаров их версию - на клиенте сразу заработало кеширование этих обложек (кеш на клиенте)  


**2018-10-08**  
v2.2  
* Работа с WP-Recall 16.16  


**2018-02-27**  
v2.1  
* Исправлена ошибка в шаблоне list - появляющаяся когда только что загруженное дополнение в каталог CodeSeller еще не имело в значении кол-во активных установок  
* Стили грузятся сверху.  
* Проработана анимация появления при загрузке страницы. Теперь блоки появляются плавней, без дёрганья, в большинстве случаев (для full-width и list шаблонов)  


**2017-12-27**  
v2.0.1  
- Небольшие css-фиксы  


**2017-12-26**  
v2.0  
- Полностью переписан на ооп и поддерживает api codeseller  
- Увы, 2 прошлых шорткода более не поддерживаются. Все заменилось новым одним. Смотри доступные атрибуты в секции "Настройки"  
- Страница настроек содержит только одну опцию. Остальные убрал. Слаги дополнений теперь вписываются в шорткод  
- Поддерживает формирование партнерской ссылки  
- Новые атрибуты шорткода (вывод по автору, вывод по slug дополнения, выбор шаблона, отключение фильтра, отключение реф ссылки, возможность назначить начальную сортировку, вывод только премиум допов)  
- Новый шаблон вывода (всего их 3)  
- Новый принцип кеширования - использует реколл кеширование  
- Благодаря новому шорткоду и новому принципу кеширования нет проблем как раньше - приходилось или ждать час или принудительно часовой крон дергать  
- Анимация теперь берется из ядра WP-Recall  



**2017-12-23**  
v1.0  
- Доп успешно прошел испытания. Присвоил ему версию 1.0.  
- Небольшая файловая реорганизация  



**2017-12-15**  
v0.3  
- Внешние ссылки закрыты nofollow  
- Исправлено: всплывающий блок в карточке рандомного товара теперь не ловит курсор. Были залипания  



**2017-10-19**  
v0.2  
- Добавлены новые настройки позволяющие грузить ресурсы (js,css) только там, где необходимо.  
- Добавлен шорткод рандомного вывода 4-х премиум (с ценой) дополнений. Шорткод [ofm_addons_random]  
- Если папка xml-файлов была удалена, то при проверке обновления вп-кроном он ее создаст заново.  
- Исправлена ошибка не вывода текста в data атрибуте (по ховеру всплывающий блок) если он содержит кавычки  
- Изменения в верстке и стилях  
- TimeLapse анимация  


**2017-02-27**  
v0.1.1  
- Подправил некоторые стили  


**2016-09-22**  
v0.1  
- Beta Release  

------------------------------

## Поддержка и контакты  

* Поддержка осуществляется в рамках текущего функционала дополнения  
* При возникновении проблемы, создайте соотвествующую тему на [форуме поддержки](https://codeseller.ru/forum/product-13291/) товара  
* Если вам нужна доработка под ваши нужды - вы можете обратиться ко мне в <a href="https://codeseller.ru/author/otshelnik-fm/?tab=chat" target="_blank">ЛС</a> с техзаданием на платную доработку.  

Полный список моих работ опубликован на [моём сайте](https://otshelnik-fm.ru/?p=2562&utm_source=free-addons&utm_medium=addon-description&utm_campaign=seller-on-codeseller&utm_content=github-com&utm_term=all-my-addons) и в каталоге магазина [CodeSeller.ru](https://codeseller.ru/author/otshelnik-fm/?tab=publics&subtab=type-products)  

------------------------------

## Author

**Wladimir Druzhaev** (Otshelnik-Fm)