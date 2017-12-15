## Описание:  

Дополнение для WordPress плагина [WP-Recall](https://wordpress.org/plugins/wp-recall/) - С помощью этого дополнения автор товаров, ведущий свои продажи через сервис CodeSeller.ru, сможет вывести актуальную информацию и статистику о своих товарах, на своем сайте или блоге.  

------------------------------

## Demo:  

[слева](https://otshelnik-fm.ru/) - 4-ре рандомных премиум товара выводятся карточкой  

[Список всех моих дополнений](https://otshelnik-fm.ru/all-my-addons-for-wp-recall/) с фильтром  

------------------------------

## Возможности вывода:  
- Вывод ваших товаров в виде карточки  
- Вывод информации о товаре  
- Вывод текущей версии  
- Вывод совместимости с WP-Recall  
- Вывод миниатюры товара  
- Количество скачиваний  
- Количество активных установок  
- Цена  
- Дата последнего обновления  
- Сортировка и фильтр товаров  
- Второй шорткод позволит вам вывести карточкой ваши 4-ре случайных премиум дополнения (с ценой)  

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

## FAQ:  
#### Принцип работы:  
1. После активации он создает по пути `/wp-content/uploads/rcl-uploads/seller-xml/` папку.  
2. Вы переходите в "настройки WP-Recall" ->  "Настройки Seller on CodeSeller" и вписываете в текстовое поле, через запятую, идентификаторы (слаги) ваших товаров (название папки вашего товара. Например: seller-on-codeseller) и сохраняете.  
3. По крону, он раз в час обращается к api сервиса CodeSeller.ru и копирует в эту папку xml файлы ваших товаров.  
4. Благодаря такому кешированию он быстро выводит необходимую информацию с вашего сайта.  

5. Чтобы вывести список товаров разместите шорткод [ofm_addons_info] на нужной странице  

Это дополнение использует шаблоны - вы с легкостью можете этим воспользоваться - кастомизировав под себя. Читайте [тут](https://codeseller.ru/post-group/ispolzuem-funkcional-shablonov-v-plagine-wp-recall-spisok-shablonov/) как с ними работать.  

Внимание! Есть вероятность - после первой активации, и после того, как вы вписали id своих товаров, сохранили и разместили шорткод - вы увидите информацию "В течении часа файлы будут получены" - как только часовой крон (rcl_cron_hourly_schedule) отработает - ваши товары начнут выводиться  


#### Вписал настройки, как мне не ждать час, а увидеть сразу?  
- Ставим плагин Advanced Cron Manager, активируем. Переходим в админке «Инструменты» - «Cron Manager» и нажимаем возле rcl_cron_hourly_schedule кнопку «Execute».  

#### Как вывести случайные премиум дополнения?  
- Впишите в нужном месте шорткод [ofm_addons_random]  

------------------------------

## ToDo:  
#### Приоритет:  
- Переработать настройки, позволить выводить по автору или по слагу  
- Возможность вписать партнерскую ссылку и в шорткоде ее отключать (по умолчанию включена будет) - позволит этому допу работать по партнерской программе  
- Новый шаблон для вывода в одиночной записи - во всю ширину  


- Сейчас выводятся только дополнения к WP-Recall, в следующих версиях будет вывод вордпресс шаблонов и плагинов  
- Вывод сводной статистики: Кол-во аддонов, плагинов и шаблонов (вкл/выкл)  
- Отключение фильтра и сортировки (у кого товаров мало - смысла в нем нет)  
- Кеширование миниатюр изображений товаров  
- При активации принудительно запрашивать по api список файлов, чтобы не ждать час  
- Если в процессе работы вписать дополнительно еще идентификатор - то выводит пустую ячейку - до выполнения часового крона. Скрыть ее т.к. формирует предупреждение PHP Warning: simplexml_load_file (сейчас решается принудительным выполнением часового крона)  
- Для админа вывод времени последнего обновления файлов - если крон сломается - вам не придется смотреть по ftp время этих файлов  
- Еще один шаблон вывода (возможность его выбора в атрибуте шорткода)  
- Удаление своих настроек (своей папки) при удалении аддона  

------------------------------

## Changelog:  
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

Полный список моих работ опубликован на [моём сайте](https://otshelnik-fm.ru/all-my-addons-for-wp-recall/) и в каталоге магазина [CodeSeller.ru](https://codeseller.ru/author/otshelnik-fm/?tab=publics&subtab=type-products)  

------------------------------

## Author

**Wladimir Druzhaev** (Otshelnik-Fm)